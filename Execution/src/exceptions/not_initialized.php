<?php
/**
 * @package Execution
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when the Execution framework was not initialized when cleanExit()
 * was called.
 * 
 * @package Execution
 * @version //autogen//
 */
class ezcExecutionNotInitializedException extends ezcExecutionException
{
    /**
     * Constructs a new ezcExecutionNotInitializedException.
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct( "The Execution mechanism was not initialized." );
    }
}
?>
