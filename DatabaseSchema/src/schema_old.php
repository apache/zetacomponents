<?php
/**
 * File containing the ezcDbSchema class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcDbSchema is the main class for schema operations.
 *
 * ezcDbSchema represents the schema itself and has the
 * ability to load/save schema from/to files, databases or other
 * sources/destinations, depending on available schema handlers.
 *
 * @todo what is a database schema
 * @todo what are the available built in types
 *
 * The following example shows you how you can load a database schema
 * from the php format and store it into the XML format.
 * <code>
 *  $schema = new ezcDbSchema();
 *  $schema->load( 'file.php', 'php-file' );
 *  $schema->save( 'file.xml', 'xml-file' );
 * </code>
 *
 * @todo Example, fetch from mysql store to disk.
 * @todo Example, create SQL diff between file on disk and database. Apply patch.
 *
 * A more complex example:
 * @todo This example is cryptic to me. What does it explain?
 * <code>
 *  class MyAppSchema extends ezcDbSchema { ... }
 *
 *  $schema1 = new MyAppSchema;
 *  $schema2 = new MyAppSchema;
 *
 *  $schema1->load( 'file1.xml', 'xml-file' );
 *  $schema2->load( $db, 'oracle-db' );
 *
 *  $diff = $schema1->compare( $schema2 );
 *  $schema1->saveDelta( $diff, 'delta.sql', 'mysql-file' );
 *
 *  $schema2->save( 'schema2.sql', 'oracle-file' );
 * </code>
 *
 * @package DatabaseSchema
 */

class ezcDbSchema
{
    /**
     * Schema array.
     * @todo add a thorough explanation of the schema format here.
     * @var array
     */
    private $Schema;

    /**
     * Handles different formats for external schema storage.
     *
     * $var ezcDbHandlerManager
     */
    private $HandlerManager;

    /**
     * User-specified schema transformation function name.
     *
     * This function is called when the schema needs to be transformed
     * (e.g. from mysql to pgsql).
     * After the function finishes its execution, some standard transformations
     * are performed (if needed).
     *
     * @var string
     */
    private $TransformationHook;


    /**
     * User specified schema scanning function name.
     *
     * @var string
     */
    private $FeaturesDetectionHook;

    /**
     * Constructs schema objects, initializing it with specified parameters.
     *
     * There could be two types of information in the parameters:
     * - user-specified hook for transforming schema before saving or comparing.
     * - user-specified hook for detecting "schema features".
     * - user-specified schema handlers.
     *
     * Exampple:
     *
     * <code>
     * class MyClass
     * {
     *     public function detectFeatures( array &$schema ) { ... }
     *     public function transformSchema( array &$schema, array $targetSchema ) { ... }
     *     ...
     * }
     *
     * $schema = new ezcDbSchema(
     *     array( 'transformation-hook' => 'MyClass::transformSchema',
     *            'features-detection-hook' => 'MyClass::detectFeatures',
     *            'user-handlers'   => array( 'MyOracleSchemaHandler', 'MyDB2SchemaHandler' ) )
     * );
     * </code>
     *
     * @param array $params Misc parameters
     */
    public function __construct( $params = array() )
    {
        $this->TransformationHook = '';
        $this->FeaturesDetectionHook = '';

        if ( isset( $params['transformation-hook'] ) )
        {
            $this->TransformationHook = $params['transformation-hook'];
            unset( $params['transformation-hook'] );
        }

        if ( isset( $params['features-detection-hook'] ) )
        {
            $this->FeaturesDetectionHook = $params['features-detection-hook'];
            unset( $params['features-detection-hook'] );
        }

        $this->HandlerManager = new ezcDbSchemaHandlerManager( $params );
        $this->Schema         = array();
    }

    /**
     * Loads schema from the given source.
     *
     * Load() will use get the appropriate handler according to the specified type.
     * The handler will be used to read the source and fill the schema of this object.
     *
     * @param  mixed  $src         Source to load schema from.
     * @param  string $storageType Schema storage type.
     * @param  string $what        What to load. Possible values:
     *                             'none', 'schema', 'data', 'both'.
     *                             Default value is 'schema'.
     * @return bool               true on success, false otherwise.
     */
    public function load( $src, $storageType, $what = 'schema' )
    {
        $schema = $this->HandlerManager->loadSchema( $src, $storageType, $what );

        if ( isset( $schema['schema'] ) )
        {
            $this->Schema['schema'] = $schema['schema'];
            $this->detectFeatures();
        }

        if ( isset( $schema['data'] ) )
            $this->Schema['data'] = $schema['data'];
    }

    /**
     * Determine which features the schema uses.
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
     * - field_precision                 : Precision is specified for some
     *                                     (usually numeric) fields
     * - field_default_is_sequence_value : Some tables in the schema contain
     *                                     fields for which default value is
     *                                     determined by a sequence.
     * @return void
     */
    protected function detectFeatures()
    {
        $schema   =& $this->Schema['schema'];
        $info     =& $schema['_info'];
        $features =& $info['features'];

        if ( $info['dbms_type'] == 'mysql' )
        {
            foreach ( $schema['tables'] as $tableName => $tableSchema )
            {
                foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
                {
                    if ( isset( $fieldSchema['options']['auto_increment'] ) )
                    {
                        $features['auto_increment'] = true;
                    }

                    if ( isset( $fieldSchema['precision'] ) )
                    {
                        $features['field_precision'] = true;
                    }
                }

                foreach ( $tableSchema['indexes'] as $indexName => $indexSchema )
                {
                    if ( isset( $indexSchema['options']['limitations'] ) )
                    {
                        $features['limited_index_field_length'] = true;
                    }
                }
            }
        }
        elseif ( $info['dbms_type'] == 'pgsql' )
        {
            // detect fields for which default value is determined by a sequence
            $features =& $schema['_info']['features'];
            foreach ( $schema['tables'] as $tableName => $tableSchema )
            {
                foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
                {
                    if ( isset( $fieldSchema['precision'] ) )
                    {
                        $features['field_precision'] = true;
                    }

                    if ( isset( $fieldSchema['options']['default_nextval'] ) )
                    {
                        $features['field_default_is_sequence_value'] = true;
                    }
                }
            }

            if ( isset( $schema['sequences'] ) && is_array( $schema['sequences'] ) && count( $schema['sequences'] ) > 0 )
                        $features['sequences'] = true;
            if ( isset( $schema['triggers'] ) && is_array( $schema['triggers'] ) && count( $schema['triggers'] ) > 0 )
                        $features['triggers'] = true;
        }

        // Run custom features detection hook (if specified by user).
        if ( $this->FeaturesDetectionHook )
        {
            eval( "{$this->FeaturesDetectionHook}( \$this->Schema );" );
        }
    }

    /**
     * Saves this schema to the given destination.
     *
     * @param   mixed  $dst         Destination to save schema to.
     * @param   string $storageType Schema storage type.
     * @param   string $what        What to save. Possible values:
     *                              'none', 'schema', 'data', 'both'.
     *                              Default value is 'schema'.
     * @return bool                true on success, false otherwise.
     */
    public function save( $dst, $storageType, $what = 'schema' )
    {
        $targetHandler = $this->HandlerManager->getHandler( $storageType );

        if ( !$targetHandler->needsSchemaTransformation() )
            $schema = $this->Schema;
        else
        {
            // run schema transformations
            $targetSchemaInfo = array(
                'schema' => array(
                    '_info'  => array(
                        'dbms_type' => $targetHandler instanceof ezcDbSchemaHandlerSql ?
                                       $targetHandler->getDbmsName() : false,
                        'dbms_ver'  => false,
                        'app'       => false,
                        'features'  => $targetHandler->getSupportedFeatures()
                    ),
                )
            );

            $schema = $this->transform( $targetSchemaInfo );
        }

        // actually save it
        $this->HandlerManager->saveSchema( $schema, $dst, $storageType, $what );
    }

    /**
     * Return schema in one of internal formats without saving it to a file or database.
     *
     * For example, you might want to get schema as XML string, or DOM tree,
     * or as a set of SQL queries, or as PHP array.
     *
     * @see getSupportedInternalFormats()

     * @param   string $internalFormat Format you want to get schema in.
     * @param   string $what           What to get. Possible values:
     *                                 'none', 'schema', 'data', 'both'.
     *                                 Default value is 'schema'.
     * @return mixed                  Schema in the specified format, false on error.
     *
     */
    public function get( $internalFormat = 'php-array', $what = 'schema' )
    {
        if ( $internalFormat != 'php-array' )
            return $this->HandlerManager->getSchema( $this->Schema, $internalFormat, $what );

        // php-array is requested
        $schema = $this->Schema;

        // remove unwanted info from the result.
        if ( !in_array( $what, array( 'schema', 'both' ) ) )
            unset( $schema['schema'] );
        if ( !in_array( $what, array( 'data', 'both' ) ) )
            unset( $schema['data'] );

        return $schema;

    }

    /**
     * Manually set schema.
     *
     * @param array $schema Schema to set.
     * @return void
     */
    public function set( array $schema )
    {
        $this->Schema = $schema;
    }

    /**
     * Saves difference between schemas in the specified format.
     * @param array  $delta       Difference to save.
     * @param mixed  $dst         Destination to save to.
     * @param string $storageType Schema storage type.
     * @return void
     */
    public function saveDelta( $delta, $dst, $storageType )
    {
        $this->HandlerManager->saveDelta( $delta, $dst, $storageType );
    }

    /**
     * Compares the schema with another schema.
     *
     * @return array Array containing delta (differencies).
     */
    public function compare( ezcDbSchema $otherSchema )
    {
        $schema2 = $otherSchema->get( 'php-array', 'schema' );

        if ( !isset( $this->Schema['schema'] ) || !isset( $schema2['schema'] ) )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::GENERIC_ERROR,
                'Tried to compare a schema with no schema loaded.' );
        }

        $transformedOtherSchema = $otherSchema->transform( $this->Schema );

        return ezcDbSchemaComparator::compareSchemas(
            $this->Schema['schema'],
            $transformedOtherSchema['schema']
        );
    }

    /**
     * Transform schema.
     *
     * Transforms the schema accordingly to the given parameters.
     * The original schema remains untouched.
     * The resulting schema array is returned.
     *
     * @return array Resulting schema after transformation.
     */
    protected function transform( array $targetSchema )
    {
        $schema = $this->Schema; // make a copy

        // Run custom transformation hook.
        if ( $this->TransformationHook )
        {
            eval( "{$this->TransformationHook}( \$schema, \$targetSchema );" );
        }

        // Run standard transformations.
        ezcDbSchemaTransformations::run( $schema, $targetSchema );
        $schema['schema']['_info']['dbms_type'] = $targetSchema['schema']['_info']['dbms_type'];

        return $schema;
    }

    /**
     * Returns list of storage types supported by all known handlers.
     */
    public function getSupportedStorageTypes()
    {
        return $this->HandlerManager->getSupportedStorageTypes();
    }

    /**
     * Return list of supported internal schema formats.
     *
     * @see get()
     */
    public function getSupportedInternalFormats()
    {
        $formats = $this->HandlerManager->getSupportedInternalFormats();
        array_unshift( $formats, 'php-array' );
        return $formats;
    }

    /**
     * Bulk data transfer.
     *
     * Transfers data from the given source to the given destination.
     * The full data is never loaded to memory, it is transferred by small chunks.
     */
    public function transferData( $src, $srcStorageType, $dst, $dstStorageType )
    {
        $srcHandler = $this->HandlerManager->getHandler( $srcStorageType );
        $dstHandler = $this->HandlerManager->getHandler( $dstStorageType );

        if ( ! $srcHandler instanceof ezcDbSchemaHandlerDataTransfer ||
             ! $dstHandler instanceof ezcDbSchemaHandlerDataTransfer )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::GENERIC_ERROR,
                "Bulk data transfers between storages of type ".
                "'$srcStorageType and '$dstStorageType' " .
                "are not supported." );
        }

        $dstHandler->openTransferDestination( $dst, $dstStorageType );
        $srcHandler->transfer( $src, $srcStorageType, $dstHandler );
        $dstHandler->closeTransferDestination();
    }

    /**
     * Resets this schema to the initial empty state.
     */
    public function reset()
    {
        $this->Schema = array();
    }
}

?>
