<?php
/**
 * File containing the ezcDbSchemaHandlerPhpArray class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for files containing PHP arrays that represent DB schema.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaHandlerPhpArray extends ezcDbSchemaHandler
{
    public function __construct( $params )
    {
        parent::__construct( $params );
    }

    /**
     * This handler supports saving/loading schema
     * to/from XML files.
     */
    static public function getSupportedStorageTypes()
    {
        return array( 'php-file' );
    }

    /**
     * @return array List of schema features supported by the handler.
     */
    static public function getSupportedFeatures()
    {
        return array();
    }

    /**
     * @see ezcDbSchemaHandler::needsSchemaTransformation()
     */
    public function needsSchemaTransformation()
    {
        return false;
    }

    /**
     * Load schema from a .php file.
     *
     * @see ezcDbHandler::loadSchema()
     */
    public function loadSchema( $src, $storageType, $what )
    {
        /*
         * Check the parameters.
         */
        if ( !in_array( $storageType, $this->getSupportedStorageTypes() ) )
            throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_STORAGE_TYPE );

        if ( !self::checkWhat( $what ) )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::INVALID_ARGUMENT,
                'Unknown specification of what to load.' );
        }

        /*
         * Actually load schema and/or data.
         */
        $schema = null;
        if ( $storageType == 'php-file' )
        {
            if ( !file_exists( $src ) )
                throw new ezcDbSchemaException( ezcDbSchemaException::FILE_NOT_FOUND );

            require( $src ); // initializes $schema

            if ( !isset( $schema ) )
                throw new ezcDbSchemaException( ezcDbSchemaException::GENERIC_ERROR,
                                                'Loaded schema is empty.' );

            // Remove unwanted info from the result.
            $processSchema = in_array( $what, array( 'schema', 'both' ) );
            $processData   = in_array( $what, array( 'data',   'both' ) );
            if ( !$processSchema )
                unset( $schema['schema'] );
            if ( !$processData )
                unset( $schema['data'] );
        }

        /*
         * Run post-load hooks (if any).
         */
        $this->runPostLoadHooks( $schema, $storageType, $what );

        return $schema;
    }

    /**
     * Save schema to an .php file
     *
     * @see ezcDbHandler::saveSchema()
     */
    public function saveSchema( $schema, $dst, $storageType, $what )
    {
        if ( !in_array( $storageType, $this->getSupportedStorageTypes() ) )
            throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_STORAGE_TYPE );

        if ( !self::checkWhat( $what ) )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::INVALID_ARGUMENT,
                'Unknown specification of what to save.' );
        }

        $this->runPreSaveHooks( $schema, $storageType, $what );

        if ( $storageType == 'php-file' )
        {
            $fh = self::fopen( $dst, 'wb' );

            switch ( $what )
            {
                case 'none':
                    $dump = '';
                    break;

                case 'schema':
                    $schema1 = $schema;
                    unset( $schema1['data'] );
                    $dump = var_export( $schema1, true );
                    break;

                case 'data':
                    $schema1 = $schema;
                    unset( $schema1['schema'] );
                    $dump = var_export( $schema1, true );
                    break;

                case 'both':
                    $dump = var_export( $schema, true );
                    break;

                default:
                    throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMENT );
            }

            fwrite( $fh, "<?php\n\$schema = " );
            fwrite( $fh, $dump );
            fwrite( $fh, ";\n\n?>\n" );
            fclose( $fh );
        }
    }

    /**
     * Saves difference between schemas to file
     */
    public function saveDelta ( $delta, $dst, $storageType )
    {
    }
}

?>
