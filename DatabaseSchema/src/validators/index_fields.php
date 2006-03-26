<?php
/**
 * File containing the ezcDbSchemaIndexFieldsValidator class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcDbSchemaIndexFieldsValidator 
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaIndexFieldsValidator
{
    static public function validate( ezcDbSchema $schema )
    {
        $errors = array();

        /* For each table we first retrieve all the field names, and then check
         * per index whether the fields it references exist */
        foreach ( $schema->getSchema() as $tableName => $table )
        {
            $fields = array_keys( $table->fields );

            foreach ( $table->indexes as $indexName => $index )
            {
                foreach ( $index->indexFields as $indexFieldName => $dummy )
                {
                    if ( !in_array( $indexFieldName, $fields ) )
                    {
                        $errors[] = "Index <$tableName:$indexName> references unknown field name <$tableName:$indexFieldName>.";
                    }
                }
            }
        }

        return $errors;
    }
}
