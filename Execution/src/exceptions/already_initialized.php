<?php
/**
 * @package Execution
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when the Execution framework was already initialized.
 * 
 * @package Execution
 */
class ezcExecutionAlreadyInitializedException extends ezcExecutionException
{
    function __construct()
    {
        parent::__construct( "The Execution mechanism is already initalized." );
    }
}
?>
