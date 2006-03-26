<?php
/**
 * File containing the ezcDbSchemaComparator class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Incapsulates schema comparison functionality.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaComparator
{
    /**
     * Finds the difference between the scemas \a $schema1 and \a $schema2.
     * @return array(mixed) an array containing:
     *        - new_tables - A list of new tables that have been added
     *        - removed_tables - A list of tables that have been removed
     *        - table_changes - Changes in table definition
     *          - added_fields - A list of new fields in the table
     *          - removed_fields - A list of removed fields in the table
     *          - changed_fields - A list of fields that have changed definition
     *          - added_indexes - A list of new indexes in the table
     *          - removed_indexes - A list of removed indexes in the table
     *          - changed_indexes - A list of indexes that have changed definition
     */
    public static final function compareSchemas( ezcDbSchema $schema1, ezcDbSchema $schema2 )
    {
        $diff = array();
        $schema1 = $schema1->getSchema();
        $schema2 = $schema2->getSchema();

        foreach ( $schema2 as $tableName => $tableDefinition )
        {
            if ( !isset( $schema1[$tableName] ) )
            {
                $diff['new_tables'][$tableName] = $tableDefinition;
            }
            else
            {
                $tableDifferences = ezcDbSchemaComparator::diffTable( $schema1[$tableName], $tableDefinition );
                if ( count( $tableDifferences ) )
                {
                    $diff['table_changes'][$tableName] = $tableDifferences;
                }
            }
        }

        /* Check if there are tables removed */
        foreach ( $schema1 as $tableName => $tableDefinition )
        {
            if ( !isset( $schema2[$tableName] ) )
            {
                $diff['removed_tables'][$tableName] = $tableDefinition;
            }
        }

        return $diff;
    }

    /**
     * Finds the difference between the tables \a $table1 and \a $table2 by looking
     * at the fields and indexes.
     *
     * @return array(mixed)  an array containing:
     *        - added_fields - A list of new fields in the table
     *        - removed_fields - A list of removed fields in the table
     *        - changed_fields - A list of fields that have changed definition
     *        - added_indexes - A list of new indexes in the table
     *        - removed_indexes - A list of removed indexes in the table
     *        - changed_indexes - A list of indexes that have changed definition
     */
    private static final function diffTable( ezcDbSchemaTable $table1, ezcDbSchemaTable $table2 )
    {
        $tableDifferences = array();

        /* See if all the fields in table 1 exist in table 2 */
        foreach ( $table2->fields as $fieldName => $fieldDefinition )
        {
            if ( !isset( $table1->fields[$fieldName] ) )
            {
                $tableDifferences['added_fields'][$fieldName] = $fieldDefinition;
            }
        }
        /* See if there are any removed fields in table 2 */
        foreach ( $table1->fields as $fieldName => $fieldDefinition )
        {
            if ( !isset( $table2->fields[$fieldName] ) )
            {
                $tableDifferences['removed_fields'][$fieldName] = true;
            }
        }
        /* See if there are any changed fieldDefinitioninitions */
        foreach ( $table1->fields as $fieldName => $fieldDefinition )
        {
            if ( isset( $table2->fields[$fieldName] ) )
            {
                $fieldDifferences = ezcDbSchemaComparator::diffField( $fieldDefinition, $table2->fields[$fieldName] );
                if ( $fieldDifferences )
                {
                    $tableDifferences['changed_fields'][$fieldName] = $fieldDifferences;
                }
            }
        }

        $table1Indexes = $table1->indexes;
        $table2Indexes = $table2->indexes;

        /* See if all the indexes in table 1 exist in table 2 */
        foreach ( $table2Indexes as $indexName => $indexDefinition )
        {
            if ( !isset( $table1Indexes[$indexName] ) )
            {
                $tableDifferences['added_indexes'][$indexName] = $indexDefinition;
            }
        }
        /* See if there are any removed indexes in table 2 */
        foreach ( $table1Indexes as $indexName => $indexDefinition )
        {
            if ( !isset( $table2Indexes[$indexName] ) )
            {
                $tableDifferences['removed_indexes'][$indexName] = $indexDefinition;
            }
        }
        /* See if there are any changed indexDefinitions */
        foreach ( $table1Indexes as $indexName => $indexDefinition )
        {
            if ( isset( $table2Indexes[$indexName] ) )
            {
                $indexDifferences = ezcDbSchemaComparator::diffIndex( $indexDefinition, $table2Indexes[$indexName] );
                if ( $indexDifferences )
                {
                    $tableDifferences['changed_indexes'][$indexName] = $indexDifferences;
                }
            }
        }

        return $tableDifferences;
    }

    /**
     * Finds the difference between the field \a $field1 and \a $field2.
     *
     * @return The field definition of the changed field or \c false if there are no changes.
     */
    private static final function diffField( ezcDbSchemaField $field1, ezcDbSchemaField $field2 )
    {
        /* Type is always available */
        if ( $field1->type != $field2->type )
        {
            return $field2;
        }

        $testFields = array( 'type', 'length', 'notNull', 'default', 'autoIncrement' );
        foreach ( $testFields as $property )
        {
            if ( $field1->$property !== $field2->$property )
            {
                return $field2;
            }
        }

        return false;
    }

    /**
     * Finds the difference between the indexes $index1 and $index2.
     *
     * Compares $index1 with $index2 and returns $index2 if there are any
     * differences or false in case there are no differences.
     *
     * @param ezcDbSchemaIndex $index1
     * @param ezcDbSchemaIndex $index2
     * @return ezcDbSchemaIndex
     */
    private static final function diffIndex( ezcDbSchemaIndex $index1, ezcDbSchemaIndex $index2 )
    {
        $testFields = array( 'primary', 'unique' );
        foreach ( $testFields as $property )
        {
            if ( $index1->$property !== $index2->$property )
            {
                return $index2;
            }
        }

        // Check for removed index fields in $index2
        foreach ( $index1->indexFields as $indexFieldName => $indexFieldDefinition )
        {
            if ( !isset( $index2->indexFields[$indexFieldName] ) )
            {
                return $index2;
            }
        }

        // Check for new index fields in $index2
        foreach ( $index2->indexFields as $indexFieldName => $indexFieldDefinition )
        {
            if ( !isset( $index1->indexFields[$indexFieldName] ) )
            {
                return $index2;
            }
        }

        $testFields = array( 'sorting' );
        foreach ( $index1->indexFields as $indexFieldName => $indexFieldDefinition )
        {
            foreach ( $testFields as $testField )
            {
                if ( $indexFieldDefinition->$testField != $index2->indexFields[$indexFieldName]->$testField )
                {
                    return $index2;
                }
            }
        }
        return false;
    }
}
?>
