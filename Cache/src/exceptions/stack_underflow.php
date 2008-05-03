<?php
/**
 * File containing the ezcCacheStackUnderflowException
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if popStorage() is called on an empty stack.
 * 
 * @see ezcCacheStack::popStorage()
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheStackUnderflowException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheStackUnderflowException.
     * 
     * @param mixed $actualType    Type of data received.
     * @param array $expectedTypes Expected data types.
     * @return void
     */
    function __construct()
    {
        parent::__construct( "No storages in stack." );
    }
}
?>
