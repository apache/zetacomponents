<?php
/**
 * File containing the ezcDbSchemaTypesValidator class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcDbSchemaTypesValidator validates field definition types.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaTypesValidator
{
    static public function validate( ezcDbSchema $schema )
    {
        $errors = array();

        /* For each table we check all field's types. */
        foreach ( $schema->getSchema() as $tableName => $table )
        {
            foreach ( $table->fields as $fieldName => $field )
            {
                if ( !in_array( $field->type, ezcDbSchema::$supportedTypes ) )
                {
                    $errors[] = "Field <$tableName:$fieldName> uses the unsupported type <{$field->type}>.";
                }
            }
        }

        return $errors;
    }
}
