<?php
/**
 * File containing the ezcConsoleInvalidOptionNameException.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An option excludes the usage of arguments, but there were arguments submitted.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleInvalidOptionNameException extends ezcConsoleException
{
    function __construct( $name )
    {
        parent::__construct( "The option name <{$name}> is invalid." );
    }
}

?>
