<?php
/**
 * @package Execution
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when an non-existend class was passed as callback handler.
 * 
 * @package Execution
 */
class ezcExecutionInvalidCallbackException extends ezcExecutionException
{
    function __construct( $callbackClassName )
    {
        parent::__construct( "Class '{$callbackClassName}' does not exist." );
    }
}
?>
