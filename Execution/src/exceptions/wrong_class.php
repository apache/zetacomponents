<?php
/**
 * @package Execution
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when the passed classname does not represent a class that
 * implements the ezcExecutionErrorHandler interface.
 * 
 * @package Execution
 */
class ezcExecutionWrongClassException extends ezcExecutionException
{
    function __construct( $callbackClassName )
    {
        parent::__construct( "The class '{$callbackClassName}' does not implement the 'ezcExecutionErrorHandler' interface." );
    }
}
?>
