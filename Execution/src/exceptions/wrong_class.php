<?php
/**
 * @package Execution
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when the passed classname does not represent a class that
 * implements the ezcExecutionErrorHandler interface.
 * 
 * @package Execution
 * @version //autogen//
 */
class ezcExecutionWrongClassException extends ezcExecutionException
{
    /**
     * Constructs a new ezcExecutionWrongClassException.
     *
     * @param string $callbackClassName
     * @return void
     */
    function __construct( $callbackClassName )
    {
        parent::__construct( "The class '{$callbackClassName}' does not implement the 'ezcExecutionErrorHandler' interface." );
    }
}
?>
