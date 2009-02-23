<?php
/**
 * Base option exception for the ConsoleTools package.
 * Exception that indicates an argument processing failure.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * General exception container for the ConsoleTools component referring to argument handling.
 * This base container allows you to catch all exceptions which are related to 
 * errors produced by invalid user submitted arguments {@link ezcConsoleInput::process()}.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
abstract class ezcConsoleArgumentException extends ezcConsoleException
{
}

?>
