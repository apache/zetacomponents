<?php
/**
 * File containing the ezcDBSchemaHandler class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Base class for all schema handlers.
 * The list of schema types supported by handler is returned by method getSupportedSchemaTypes().
 * Using this list, the handlers manager determines which handler to use for a given schema type.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

abstract class ezcDBSchemaHandler
{
    private $Params;

    /**
     * Constructs handler object, saving given parameters in the instance.
     */
    public function  __construct( $params )
    {
        $this->Params = $params;
    }

    /**
     * @returns array list of supported schema types.
     */
    abstract public function getSupportedSchemaTypes();

    /**
     * Load schema from the specified source
     *
     * @param    mixed  $src  Where to load schema from.
     * @returns  array        Loaded schema.
     */
    public function loadSchema( $src )
    {
        $this->runPostLoadHooks( $schema );
    }

    /**
     * Save given schema to the specified destination.
     *
     * @param   array  $schema  Schema to save.
     * @param   mixed  $dst     Destination to save to.
     * @returns bool            true if success, false otherwise.
     */
    public function saveSchema( $schema, $dst )
    {
        $this->runPreSaveHooks( $schema );
    }

    /**
     * Save given difference between schemas to the specified destination.
     *
     * @param   array $delta Difference to save.
     * @param   mixed $dst   Destination to save to.
     * @returns bool  true on success, false otherwise
     */
    abstract public function saveDelta ( $delta, $dst );

    /**
     * Run pre-save hooks, callbacks for them have been specified in constructor
     */
    protected function runPreSaveHooks( &$schema )
    {
        return $this->runHooks( 'pre-save-hooks', $schema );
    }

    /**
     * Run post-load hooks, callbacks for them have been specified in constructor
     */
    protected function runPostLoadHooks( &$schema )
    {
        return $this->runHooks( 'post-load-hooks', $schema );
    }

    /**
     * @returns bool false if no hooks found, true otherwise.
     */
    private function runHooks( $type, &$schema )
    {
        if ( !isset( $Params[$type] ) )
             return false;

        foreach ( $Params[$type] as $callback )
            $callback( $schema );

        return true;
    }
}

?>
