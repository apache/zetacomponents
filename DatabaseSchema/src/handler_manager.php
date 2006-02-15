<?php
/**
 * File containing the ezcDbSchemaHandlerManager class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Deals with schema handlers for a ezcDbSchema object.
 *
 * Determines which handlers to use for the specified storage type or internal format.
 * Creates handlers on demand.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaHandlerManager
{
    /**
     * Parameters common for all the handlers.
     * Currently only user-specified schema transformation hooks are saved here.
     */
    private $HandlerParams = array();

    /**
     * Set of standard handlers.
     * This array may be appended with user-specified handlers in the constructor.
     */
    private $Handlers = array( 'ezcDbSchemaHandlerXml',
                               'ezcDbSchemaHandlerPhpArray',
                               'ezcDbSchemaHandlerMysql',
                               'ezcDbSchemaHandlerPgsql',
                               'ezcDbSchemaHandlerOracle',
                             );

    /**
     * Constructs handlers manager instance, handling specified parameters.
     */
    public function __construct( $handlerParams = array() )
    {
        $this->HandlerParams = $handlerParams;
        if ( $this->HandlerParams )
        {
            if ( isset( $this->HandlerParams['user-handlers'] ) )
            {
                $this->Handlers = array_merge( $this->HandlerParams['user-handlers'], $this->Handlers );
                unset( $this->HandlerParams['user-handlers'] );
            }
        }
    }

    /**
     * Load schema, using appropriate handler for the specified storage type.
     *
     * @param mixed  $src         Where to load schema from.
     * @param string $storageType Schema type: determines which handler to use.
     * @param string $what        What to load. Possible values:
     *                            'none', 'schema', 'data', 'both'.
     *                            Default value is 'schema'.
     * @return      mixed        Loaded schema on success, false otherwise.
     */
    public function loadSchema( $src, $storageType, $what )
    {
        return $this->getHandler( $storageType )->loadSchema( $src, $storageType, $what );
    }

    /**
     * Save given schema.
     *
     * @param array  $schema      Schema to save.
     * @param mixed  $dst         Where to save to.
     * @param string $storageType Format to use when saving.
     * @param string $what        What to save. Possible values:
     *                            'none', 'schema', 'data', 'both'.
     *                            Default value is 'schema'.
     * @return      bool         true on success, false otherwise.
     */
    public function saveSchema( $schema, $dst, $storageType, $what )
    {
        return $this->getHandler( $storageType )->saveSchema( $schema, $dst, $storageType, $what );
    }

    /**
     * Return schema in one of internal formats without saving it to a file or database.
     *
     * For example, you might want to get schema as XML string, or DOM tree,
     * or as a set of SQL queries.
     *
     * @param   array  $schema         Schema to return in the specified format.
     * @param   string $internalFormat Format you want to get schema in.
     * @param   string $what           What to load. Possible values:
     *                                 'none', 'schema', 'data', 'both'.
     *                                 Default value is 'schema'.
     * @return mixed                  Schema in the specified format, false on error.
     *
     * @see ezcDbSchema::get()
     */
    public function getSchema( $schema, $internalFormat, $what )
    {
        return $this->getHandlerByInternalFormat( $internalFormat )->getSchema( $schema, $internalFormat, $what );
    }

    /**
     * Save given difference between schemas in the specified format.
     *
     * @param   array  $delta       The difference.
     * @param   mixed  $dst         Where to save to.
     * @param   string $storageType Schema storage type.
     * @return bool                true on success, false otherwise
     */
    public function saveDelta( $delta, $dst, $storageType )
    {
        return $this->getHandler( $storageType )->saveDelta( $delta, $dst, $storageType );
    }

    /**
     * Returns instance of the appropriate handler for the specified storage type.
     *
     * @param   string $storageType Storage type that determines the handler to load.
     * @return ezcDbSchemaHandler  The appropriate handler.
     * @throws ezcDbSchemaException::UNKNOWN_STORAGE_TYPE if an appropriate handler
     *         cannot be found.
     */
    public function getHandler( $storageType )
    {
        foreach ( $this->Handlers as $handlerClass )
        {
            $types = call_user_func( array( $handlerClass, 'getSupportedStorageTypes' ) );
            if ( in_array( $storageType, $types ) )
            {
                $appropriateHandler = new $handlerClass( $this->HandlerParams );
                return $appropriateHandler;
            }

        }

        throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_STORAGE_TYPE );
    }

    /**
     * Returns instance of the appropriate handler for the specified internal format.
     *
     * @param   string $internalFormat Internal schema format that determines
     *                                 the handler to load.
     * @return ezcDbSchemaHandler     The appropriate handler.
     * @throws ezcDbSchemaException::UNKNOWN_INTERNAL_FORMAT if an appropriate handler
     *          cannot be found.
     */
    private function getHandlerByInternalFormat( $internalFormat )
    {
        foreach ( $this->Handlers as $handlerClass )
        {
            $supportedFormats = call_user_func( array( $handlerClass, 'getSupportedInternalFormats' ) );
            if ( in_array( $internalFormat, $supportedFormats ) )
            {
                $appropriateHandler = new $handlerClass( $this->HandlerParams );
                return $appropriateHandler;
            }
        }

        throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_INTERNAL_FORMAT );
    }

    /**
     * Returns list of schema types supported by all known handlers.
     *
     * Goes through the list of known handlers and gathers information
     * of which schema types do they support.
     */
    public function getSupportedStorageTypes()
    {
        $supportedSchemaTypes = array();

        foreach ( $this->Handlers as $handlerClass )
        {
            $types = call_user_func( array( $handlerClass, 'getSupportedStorageTypes' ) );
            $supportedSchemaTypes = array_merge( $supportedSchemaTypes, $types );
        }

        return $supportedSchemaTypes;
    }

    /**
     * Return list of supported internal schema formats.
     *
     * Goes through the list of known handlers and gathers information
     * of which internal formats do they support.
     *
     * @see getSchema()
     * @see ezcDbSchema::get()
     */
    public function getSupportedInternalFormats()
    {
        $supportedInternalFormats = array();

        foreach ( $this->Handlers as $handlerClass )
        {
            $types = call_user_func( array( $handlerClass, 'getSupportedInternalFormats' ) );
            $supportedInternalFormats = array_merge( $supportedInternalFormats, $types );
        }

        return $supportedInternalFormats;
    }
}

?>
