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
abstract class ezcDbSchemaCommonSqlWriter
{
    /**
     * Dump specified schema as an array of SQL queries.
     *
     * @return array The queries.
     */
    protected function generateSchemaAsSql()
    {
        foreach ( $this->schema as $tableName => $tableDefinition )
        {
            $this->generateDropTableSql( $tableName );
            $this->generateCreateTableSql( $tableName, $tableDefinition );
        }
    }

    /**
     * Generate SQL queries for table creation.
     */
    private function generateCreateTableSql( $tableName, ezcDbSchemaTable $tableDefinition )
    {
        $sql = '';

        $sql .= "CREATE TABLE $tableName (\n";

        // dump fields
        $fieldsSQL = array();

        foreach ( $tableDefinition->fields as $fieldName => $fieldDefinition )
        {
            $fieldsSQL[] = "\t" . $this->generateFieldSql( $fieldName, $fieldDefinition );
        }

        $sql .= join( ",\n", $fieldsSQL );

        $sql .= "\n)";

        $this->queries[] = $sql;

        // dump indexes
        foreach ( $tableDefinition->indexes as $indexName => $indexDefinition)
        {
            $fieldsSQL[] = $this->generateAddIndexSql( $tableName, $indexName, $indexDefinition );
        }

    }

    protected function generateDefault( $type, $value )
    {
        switch ( $type )
        {
            case 'boolean':
                return $value ? 'true' : 'false';

            case 'integer':
                return (int) $value;

            case 'float':
            case 'decimal':
                return (float) $value;

            case 'timestamp':
                return (int) $value;

            default:
                return "'$value'";
        }
    }

/******************************/
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
    protected function generateDiffSchemaAsSql()
    {
        foreach ( $this->diffSchema->changedTables as $tableName => $tableDiff )
        {
            foreach ( $tableDiff->removedIndexes as $indexName => $isRemoved )
            {
                if ( $isRemoved )
                {
                    $this->generateDropIndexSql( $tableName, $indexName );
                }
            }

            foreach ( $tableDiff->changedIndexes as $indexName => $indexDefinition )
            {
                $this->generateDropIndexSql( $tableName, $indexName );
            }

            foreach ( $tableDiff->removedFields as $fieldName => $isRemoved )
            {
                if ( $isRemoved )
                {
                    $this->generateDropFieldSql( $tableName, $fieldName );
                }
            }

            foreach ( $tableDiff->changedFields as $fieldName => $fieldDefinition )
            {
                $this->generateChangeFieldSql( $tableName, $fieldName, $fieldDefinition );
            }

            foreach ( $tableDiff->addedFields as $fieldName => $fieldDefinition )
            {
                $this->generateAddFieldSql( $tableName, $fieldName, $fieldDefinition );
            }

            foreach ( $tableDiff->changedIndexes as $indexName => $indexDefinition )
            {
                $this->generateAddIndexSql( $tableName, $indexName, $indexDefinition );
            }

            foreach ( $tableDiff->addedIndexes as $indexName => $indexDefinition )
            {
                $this->generateAddIndexSql( $tableName, $indexName, $indexDefinition );
            }
        }

        foreach ( $this->diffSchema->newTables as $tableName => $tableDef )
        {
            $this->generateCreateTableSql( $tableName, $tableDef );
        }

        foreach ( $this->diffSchema->removedTables as $tableName => $dummy )
        {
            $this->generateDropTableSql( $tableName );
        }
    }

    /**
     * Generate table dropping SQL query.
     *
     * @return string The query.
     */
    protected abstract function generateDropTableSql( $tableName );

    /**
     * Generate SQL fragment for a table field.
     *
     * @return string The query.
     */
    protected abstract function generateFieldSql( $fieldName, ezcDbSchemaField $fieldDefinition );

    /**
     * Generate SQL query for adding a table field.
     *
     * @return string The query.
     */
    protected abstract function generateAddFieldSql( $tableName, $fieldName, ezcDbSchemaField $fieldDefinition );

    /**
     * Generate SQL query for changing a table field.
     *
     * @return string The query.
     */
    protected abstract function generateChangeFieldSql( $tableName, $fieldName, ezcDbSchemaField $fieldDefinition );

    /**
     * Generate SQL query for dropping a table field.
     *
     * @return string The query.
     */
    protected abstract function generateDropFieldSql( $tableName, $fieldName );


    /**
     * Generate index creation SQL query.
     *
     * @return string The query.
     */
    protected abstract function generateAddIndexSql( $tableName, $indexName, ezcDbSchemaIndex $indexDefinition );


    /**
     * Generate drop index SQL query.
     *
     * @return string The query.
     */
    protected abstract function generateDropIndexSql( $tableName, $indexName );
}
?>
