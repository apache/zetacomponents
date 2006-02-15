<?php
/**
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Implementation of some basic schema transformations.
 *
 * This is only an example how the thing may look.
 * The most transformations are meant to be implemented by user,
 * and invoked with the appropriate hooks.
 *
 * @package DatabaseSchema
 *
 * The following features are recognized for MySQL:
 * - auto_increment             : Schema contains fields declared
 *                                as AUTO_INCREMENT
 * - field_precision            : Precision is specified for some
 *                                (usually numeric) fields
 * - limited_index_field_length : There are indexes having constraint on
 *                                maximum indexed string length.
 *
 * The following features are recognized for PostgreSQL:
 * - sequences                       : Schema contains sequences(s).
 * - triggers                        : Schema contains trigger(s).
 * - field_default_is_sequence_value : Some tables in the schema contain
 *                                     fields for which default value is
 *                                     determined by a sequence.
 */
class ezcDbSchemaTransformations
{
    /**
     * Schema transformation rules.
     *
     * @return array List of schema transformation rules.
     *
     */
    private static function getRules()
    {
        /*
         * We don't do any real transformations here.
         * Only dropping of features is implemented, for schemas to be at least
         * comparable (=containing equal set of features).
         *
         * Array element format: <feature-name> => <drop-feature-method-name>
         */
        return array(
            'drop' => array(
                'auto_increment' => 'dropAutoIncrement',
                'field_default_is_sequence_value' => 'dropDefaultValueSequence',
                'sequences' => 'dropSequences',
                'limited_index_field_length' => 'dropIndexLimitations',
            ),
        );
    }

    /**
     * Run schema transformations..
     *
     */
    public function run( array &$schema, array $targetSchema )
    {
        $srcFeatures = $schema['schema']['_info']['features'];
        $dstFeatures = $targetSchema['schema']['_info']['features'];
        $rules = self::getRules();

        foreach ( $srcFeatures as $feature => $fValue )
        {
            // Check if the rule must be transformed at all.
            if ( in_array( $feature, $dstFeatures ) )
            {
                continue; // do nothing: no transformation is required for this feature
            }

            // Check if there is a way to remove this feature.
            elseif ( isset( $rules['drop'][$feature] ) )
            {
                $methodName = $rules['drop'][$feature];
                eval( "self::{$methodName}( \$schema );" );
            }
            else
            {
                // We don't know how to drop this feature.
                // Should we show a warning or raise an exception here?
            }
        }
    }

    /**
     * Removes mysql auto_increment feature from the schema.
     */
    private static function dropAutoIncrement( &$schema )
    {
        foreach ( $schema['schema']['tables'] as $tableName => $tableSchema )
        {
            foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
            {
                if ( isset( $fieldSchema['options']['auto_increment'] ) )
                {
                    $origFieldSchemaRef =& $schema['schema']['tables'][$tableName]['fields'][$fieldName];
                    unset( $origFieldSchemaRef['options']['auto_increment'] );
                    if ( count( $origFieldSchemaRef['options'] ) == 0 )
                        unset( $origFieldSchemaRef['options'] );
                }
            }
        }

        unset( $schema['schema']['_info']['features']['auto_increment'] );
    }

    /**
     * Removes mysql limitation on maximum indexed field length.
     */
    private static function dropIndexLimitations( &$schema )
    {
        foreach ( $schema['schema']['tables'] as $tableName => $tableSchema )
        {
            if ( isset( $indexSchema['options']['limitations'] ) )
            {
                unset( $schema['tables'][$tableName]['indexes'][$indexName]['options']['limitations'] );
            }
        }

        unset( $schema['schema']['_info']['features']['limited_index_field_length'] );
    }

    /**
     * Drops pgsql-specific DEFAULT values from table fields, referring to sequences.
     */
    private static function dropDefaultValueSequence( &$schema )
    {
        foreach ( $schema['schema']['tables'] as $tableName => $tableSchema )
        {
            foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
            {
                $default = $fieldSchema['default'];

                if ( is_array( $default ) && count( $default ) && $default[0] == 'sequence' )
                {
                    $origFieldSchemaRef =& $schema['schema']['tables'][$tableName]['fields'][$fieldName];
                    $origFieldSchemaRef['default'] = false;
                    unset( $origFieldSchemaRef['not_null'] );
                }
            }
        }

        unset( $schema['schema']['_info']['features']['field_default_is_sequence_value'] );
    }

    /**
     * Drops all sequences from the schema.
     */
    private static function dropSequences( &$schema )
    {
        unset( $schema['schema']['sequences'] );
        unset( $schema['schema']['_info']['features']['sequences'] );
    }
}

?>
