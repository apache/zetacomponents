<?php
/**
 * File containing the ezcDbSchemaHandlersManager class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Deals with schema handlers for a ezcDbSchema object.
 * Determines which handlers to use for specified schema type.
 * Creates handlers on demand.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcDbSchemaHandlersManager
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
    private $Handlers = array( 'ezcXMLDBSchemaHandler',
                               'ezcPHPArrayDBSchemaHandler',
                               'ezcMySQLDBSchemaHandler',
                               'ezcPgSQLDBSchemaHandler' );

    /**
     * Constructs handlers manager instance, handling specified parameters.
     */
    public function __construct( $handlerParams = array() )
    {
        $this->HandlerParams = $handlerParams;
        if ( isset( $this->HandlerParams ) )
        {
            $this->Handlers = array_merge( $this->Handlers, $this->HandlerParams['user-handlers'] );
            unset( $this->HandlerParams['user-handlers'] );
        }
    }

    /**
     * Load schema, using appropriate handler for the specified schema type.
     *
     * @param mixed  $src        Where to load schema from.
     * @param string $schemaType Schema type: determines which handler to use.
     * @returns      mixed       loaded schema on success, false otherwise.
     */
    public function loadSchema( $src, $schemaType )
    {
        return $this->getHandler( $schemaType )->loadSchema( $src );
    }

    /**
     * Save given schema.
     *
     * @param array  $schema     Schema to save.
     * @param mixed  $dst        Where to save to.
     * @param string $schemaType Format to use when saving.
     * @returns      bool        true on success, false otherwise.
     */
    public function saveSchema( $schema, $dst, $schemaType )
    {
        return $this->getHandler( $schemaType )->saveSchema( $schema, $dst );
    }

    /**
     * Save given difference between schemas in the specified format.
     *
     * @param   array  $delta      The difference.
     * @param   mixed  $dst        Where to save to.
     * @param   string $schemaType Format to use when saving.
     * @returns bool               true on success, false otherwise
     */
    public function saveDelta( $delta, $dst, $schemaType )
    {
        return $this->getHandler( $schemaType )->saveDelta( $delta, $dst );
    }

    /**
     * \privatesection
     */

    /**
     * Returns instance of the appropriate handler for schema of type $schemaType.
     * @returns ezcDbSchemaHandler  The appropriate handler.
     */
    private function & getHandler( $schemaType )
    {
        // FIXME: replace this with a real implementation
        return new ezcPHPArrayDBSchemaHandler( $this->HandlerParams );
    }
}

?>
