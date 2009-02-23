<?php
/**
 * @package Execution
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when the Execution framework was already initialized.
 * 
 * @package Execution
 * @version //autogen//
 */
class ezcExecutionAlreadyInitializedException extends ezcExecutionException
{
    /**
     * Constructs a new ezcExecutionAlreadyInitializedException.
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct( "The Execution mechanism is already initialized." );
    }
}
?>
