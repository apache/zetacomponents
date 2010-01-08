<?php
/**
 * File containing the ezcConsoleOptionAlreadyRegisteredException.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The option name you tried to register is already in use.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleOptionAlreadyRegisteredException extends ezcConsoleException
{
    /**
     * Creates a new exception object. 
     * 
     * @param string $name Name of the affected option.
     * @return void
     */
    public function __construct( $name )
    {
        parent::__construct( "An option with the name '{$name}' is already registered." );
    }
}

?>
