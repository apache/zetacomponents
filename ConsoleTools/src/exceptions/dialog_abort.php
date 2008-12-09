<?php
/**
 * File containing the ezcConsoleDialogAbortException.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Occurs if the user sends <CTRL>-D to a dialog instead of a valid answer.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleDialogAbortException extends ezcConsoleException
{
    /**
     * Creates a new exception object. 
     * 
     * @param string $name Name of the already existing option.
     * @return void
     */
    public function __construct()
    {
        parent::__construct( "User send EOF." );
    }
}
?>
