<?php
/**
 * File containing the ezcDbSchema class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Schema handling API.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

class ezcDbSchema
{
    /**
     * Schema array.
     */
    private $Schema;

    /**
     * Handles different formats for external schema storage.
     */
    private $HandlerManager;


    /**
     * Constructs schema objects, initializing it with specified parameters.
     *
     * @param array $handlerParams Handler parameters
     *
     * There could be two types of information in the parameters:
     * - user-specified hooks for transforming schema before saving or after loading.
     * - user-specified handlers.
     *
     * Exampple:
     *
     * <code>
     * array( 'post-load-hooks' => array( 'MyClass::detectAutoIncrements'   ),
     *        'pre-save-hooks'  => array( 'MyClass::expandLongTablesNames'  ),
     *        'user-handlers'   => array( 'MyOracleSchemaHandler', 'MyDB2SchemaHandler' ) )
     * </code>
     */
    public function __construct( $handlerParams = array() )
    {
        $this->HandlerManager = new ezcDbSchemaHandlersManager( $handlerParams );
    }

    /**
     * Loads schema from the given source.
     * @param  mixed  $src        Source to load schema from.
     * @param  string $schemaType Type of schema.
     * @returns array             Loaded schema.
     */
    public function load( $src, $schemaType )
    {
        $this->Schema = $this->HandlerManager->loadSchema( $src, $schemaType );
    }

    /**
     * Saves schema to the given destination.
     * @param   mixed  $dst         Destination to save schema to.
     * @param   string $schemaType  Type of schema.
     * @returns bool                true on success, false otherwise.
     */
    public function save( $dst, $schemaType )
    {
        $this->HandlerManager->saveSchema( $this->Schema, $dst, $schemaType );
    }

    /**
     * Saves difference between schemas in the specified format.
     * @param array  $delta       Difference to save.
     * @param mixed  $dst         Destination to save to.
     * @param string $schemaType  Schema type: specifies format to use when saving.
     */
    public function saveDelta( $delta, $dst, $schemaType )
    {
        $this->HandlerManager->saveDelta( $delta, $dst, $schemaType );
    }

    /**
     * Compares the schema with another schema.
     * @returns array Array containing delta (differencies).
     */
    public function compare( ezcDbSchema $otherSchema )
    {
        // to be implemented
    }

}

?>
