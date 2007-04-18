<?php
/**
 * File containing the ezcConsoleNoValidDialogResultException.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if {@see ezcConsoleDialog::getResult()} is called before a valid
 * result was received.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleNoValidDialogResultException extends ezcConsoleException
{
    
    public function __construct()
    {
        parent::__construct( "The dialog did not receive a valid result, yet." );
    }

}
?>
