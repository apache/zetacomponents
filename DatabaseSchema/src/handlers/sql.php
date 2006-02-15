<?php
/**
 * File containing the ezcDbSchemaHandlerSql class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Incapsulates common functionality for DBMS schema handlers
 * (MySQL, Oracle, etc).
 *
 * @package DatabaseSchema
 */
abstract class ezcDbSchemaHandlerSql extends ezcDbSchemaHandler
{
    public abstract function getDbmsName();

    /**
     * Represents given delta (difference) between two database schemas
     * as an array of SQL queries.
     *
     * If The queries are then run on the first schema the schema will become
     * equal to the second one.
     * So this is the way schema synchronizations is done.
     *
     * @return array(string) The set of queries to make schema #1 equal to schema #2.
     */
    protected function generateDeltaSQL( $differences, $params = array() )
    {
        $params = array_merge( array( 'schema' => true,
                                      'data' => false,
                                      'allow_multi_insert' => false,
                                      'diff_friendly' => false ),
                               $params );
        $sql = array();

        /* Loop over all 'table_changes' */
        if ( isset( $differences['table_changes'] ) )
        {
            foreach ( $differences['table_changes'] as $table => $table_diff )
            {
                if ( isset ( $table_diff['added_fields'] ) )
                {
                    foreach ( $table_diff['added_fields'] as $field_name => $added_field )
                        $sql[]= $this->generateAddFieldSql( $table, $field_name, $added_field, $params );
                }

                if ( isset ( $table_diff['changed_fields'] ) )
                {
                    foreach ( $table_diff['changed_fields'] as $field_name => $changed_field )
                    {
                        $changed_field_def =/*&*/ $changed_field['field-def'];
                        $diffPrams = array_merge( $params, array( 'different-options' => $changed_field['different-options'] ) );
                        $sql[] = $this->generateAlterFieldSql( $table, $field_name, $changed_field_def, $diffPrams );
                        unset( $diffPrams );
                    }
                }
                if ( isset ( $table_diff['removed_fields'] ) )
                {
                    foreach ( $table_diff['removed_fields'] as $field_name => $removed_field)
                        $sql[] = $this->generateDropFieldSql( $table, $field_name, $params );
                }

                if ( isset ( $table_diff['removed_indexes'] ) )
                {
                    foreach ( $table_diff['removed_indexes'] as $index_name => $removed_index)
                        $sql[] = $this->generateDropIndexSql( $table, $index_name, $removed_index, $params );
                }
                if ( isset ( $table_diff['added_indexes'] ) )
                {
                    foreach ( $table_diff['added_indexes'] as $index_name => $added_index)
                        $sql[] = $this->generateAddIndexSql( $table, $index_name, $added_index, $params );
                }

                if ( isset ( $table_diff['changed_indexes'] ) )
                {
                    foreach ( $table_diff['changed_indexes'] as $index_name => $changed_index )
                    {
                        $sql[] = $this->generateDropIndexSql( $table, $index_name, $changed_index, $params );
                        $sql[] = $this->generateAddIndexSql( $table, $index_name, $changed_index, $params );
                    }
                }
            }
        }
        if ( isset( $differences['new_tables'] ) )
        {
            foreach ( $differences['new_tables'] as $table => $table_def )
                $sql = array_merge( $sql,  $this->generateCreateTableSql( $table, $table_def, $params ) );
        }
        if ( isset( $differences['removed_tables'] ) )
        {
            foreach ( $differences['removed_tables'] as $table => $table_def )
                $sql[] = $this->generateDropTableSql( $table, $params );
        }

        return $sql;
    }

    /**
     * Generate SQL queries for table creation.
     *
     * @return array(string) Array of queries needed to create the table
     *                        (along with its indexes, etc).
     */
    protected abstract function generateCreateTableSql( $tableName, $tableSchema, $params = array() );

    /**
     * Generate table dropping SQL query.
     *
     * @return string The query.
     */
    protected abstract function generateDropTableSql( $tableName, $params = array() );


    /**
     * Generate SQL query for adding a table field.
     *
     * @return string The query.
     */
    protected abstract function generateAddFieldSql( $tableName, $fieldName, $fieldSchema, $params = array() );

    /**
     * Generate SQL query for altering table field schema.
     *
     * @return string The query.
     */
    protected abstract function generateAlterFieldSql( $tableName, $fieldName, $fieldSchema, $diffParams = array() );

    /**
     * Generate SQL query for dropping a table field.
     *
     * @return string The query.
     */
    protected abstract function generateDropFieldSql( $tableName, $fieldName, $params = array() );


    /**
     * Generate index creation SQL query.
     *
     * @return string The query.
     */
    protected abstract function generateAddIndexSql( $tableName, $indexName, $indexSchema, $params = array(), $isEmbedded = false );


    /**
     * Generate drop index SQL query.
     *
     * @return string The query.
     */
    protected abstract function generateDropIndexSql( $tableName, $indexName, $indexSchema, $params = array() );


    /* TODO:
     * create sequence
     * drop sequence
     *
     * create trigger
     * drop trigger
     */
}

?>