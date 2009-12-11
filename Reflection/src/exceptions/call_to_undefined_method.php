<?php
/**
 * File containing the ezcReflectionCallToUndefinedMethodException class
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown if an invalid class is passed as callback class for
 * delayed object configuration.
 *
 * @package Reflection
 * @version //autogen//
 */
class ezcReflectionCallToUndefinedMethodException extends ezcBaseException
{
    /**
     * Constructs a new ezcReflectionCallToUndefinedMethodException.
     *
     * @param string $class
     * @param string $method
     * @return void
     */
    function __construct( $class, $method )
    {
        // TODO maybe get stacktrace and report file and line of the invocation
        parent::__construct( "Call to undefined method '{$class}::{$method}'." );
    }
}
