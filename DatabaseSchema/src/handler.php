<?php
/**
 * File containing the ezcDbSchemaHandler class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Base class for all schema handlers.
 * The list of storage types supported by handler is returned by method getSupportedStorageTypes().
 * Using this list, the handler manager determines which handler to use for a given schema type.
 * The same goes for getSupportedInternalFormats().
 *
 * @package DatabaseSchema
 */

abstract class ezcDbSchemaHandler
{
    protected $Params;

    /**
     * Constructs handler object, saving given parameters in the instance.
     */
    public function  __construct( $params )
    {
        $this->Params = $params;
    }

    /**
     * @return array list of supported storage types.
     */
    //abstract static public function getSupportedStorageTypes();

    /**
     * @return array List of schema features supported by the handler.
     */
    //abstract static public function getSupportedFeatures();

    /**
     * Check if schema transformation is required before saving it
     * with the handler.
     *
     * @return bool true if tranasformation is required, false otherwise.
     */
    public function needsSchemaTransformation()
    {
        return true;
    }

    /**
     * Load schema from the specified source
     *
     * @param    mixed  $src         Where to load schema from.
     * @param    string $storageType Schema storage type
     * @param    string $what        What to load. Possible values:
     *                               'none', 'schema', 'data', 'both'.
     *                               Default value is 'schema'.
     * @return  array               Loaded schema.
     */
    public function loadSchema( $src, $storageType, $what )
    {
    }

    /**
     * Save given schema to the specified destination.
     *
     * @param   array  $schema      Schema to save.
     * @param   mixed  $dst         Destination to save to.
     * @param   string $storageType Schema storage type.
     * @param   string $what        What to save. Possible values:
     *                              'none', 'schema', 'data', 'both'.
     *                              Default value is 'schema'.
     * @return bool                true if success, false otherwise.
     */
    public function saveSchema( $schema, $dst, $storageType, $what )
    {
        return true;
    }

    /**
     * Save given difference between schemas to the specified destination.
     *
     * @param   array  $delta        Difference to save.
     * @param   mixed  $dst          Destination to save to.
     * @param   string $storageType  Storage type to use when saving the difference.
     * @return bool                 true on success, false otherwise.
     */
    abstract public function saveDelta ( $delta, $dst, $storageType );

    /**
     * Returns the list of internal formats supported by the handler.
     *
     * @return array(string) List of internal formats supported by the handler.
     *
     * @see getSchema()
     * @see ezcDbSchema::get()
     */
    static public function getSupportedInternalFormats()
    {
        return array();
    }

    /**
     * Return schema in one of internal formats without saving it to a file or database.
     *
     * For example, you might want to get schema as XML string, or DOM tree,
     * or as a set of SQL queries.
     *
     * @param   array  $schema         Schema to return in the specified format.
     * @param   string $internalFormat Format you want to get schema in.
     * @param   string $what           What to get. Possible values:
     *                                'none', 'schema', 'data', 'both'.
     *                                 Default value is 'schema'.
     * @return mixed                  Schema in the specified format, false on error.
     *
     * @see getSupportedInternalFormats()
     * @see ezcDbSchema::get()
     */
    public function getSchema( $schema, $internalFormat, $what )
    {
        return false;
    }

    /**
     * Run pre-save hooks, callbacks for them have been specified in constructor
     */
    protected function runPreSaveHooks( &$schema, $storageType, $what )
    {
        return $this->runHooks( 'pre-save-hooks', $schema, $storageType, $what );
    }

    /**
     * Run post-load hooks, callbacks for them have been specified in constructor
     */
    protected function runPostLoadHooks( &$schema, $storageType, $what )
    {
        return $this->runHooks( 'post-load-hooks', $schema, $storageType, $what );
    }

    /**
     * Run hooks of the specified type.
     *
     * @param   array $schema The schema to run hooks on.
     * @return bool          false if no hooks found, true otherwise.
     */
    protected function runHooks( $type, &$schema, $storageType, $what )
    {
        if ( !isset( $this->Params[$type] ) )
             return false;

        foreach ( $this->Params[$type] as $callback )
        {
            $parts = preg_split( '/::/', $callback );

            if ( count( $parts ) > 1 ) // call static class method
                call_user_func( array( $parts[0], $parts[1] ), $schema, $storageType, $what );
            else // call usual function
                $callback( $schema, $storageType, $what );
        }

        return true;
    }

    /**
     * Check if the specification of which database part (schema and/or data)
     * to process is correct.
     *
     * @return bool true if $what contains a correct value, false otherwise.
     */
    protected static final function checkWhat( $what )
    {
        return in_array( $what, array( 'none', 'schema', 'data', 'both' ) );
    }

    /**
     * Check if schema should be processed by the caller.
     *
     * @return bool true if yes, false otherwise.
     */
    protected static final function processSchema( $what )
    {
        return in_array( $what, array( 'schema', 'both' ) );
    }

    /**
     * Check if data should be processed by the caller.
     *
     * @return bool true if yes, false otherwise.
     */
    protected static final function processData( $what )
    {
        return in_array( $what, array( 'data', 'both' ) );
    }

    /**
     * Exception-enabled wrapper for standard fopen()
     *
     * @param string $fileName Name of the file to open.
     * @param string $mode     Mode (identical to standard fopen()).
     * @throws ezcDbSchemaException::GENERIC_ERROR if an error occurs.
     * @return file handle in case of no errors.
     */
    protected static function fopen( $fileName, $mode )
    {
        $savedTrackErrorsFlag = ini_get( 'track_errors' );
        ini_set( 'track_errors', 1 );

        if ( ( $handle = @fopen( $fileName, 'wb' ) ) === false )
            throw new ezcDbSchemaException(
                ezcDbSchemaException::GENERIC_ERROR,
                "cannot write to $fileName: $php_errormsg" );

        ini_set( 'track_errors', $savedTrackErrorsFlag );

        return $handle;
    }

}

?>
