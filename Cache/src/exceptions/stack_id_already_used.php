<?php
/**
 * File containing the ezcCacheStackIdAlreadyUsedException.
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown if an ID is already in use in a stack.
 *
 * @see ezcCacheStack::pushStorage()
 * @package Cache
 * @version //autogen//
 */
class ezcCacheStackIdAlreadyUsedException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheStackIdAlreadyUsedException.
     * 
     * @param string $id The ID that is already in use.
     * @return void
     */
    function __construct( $id )
    {
        parent::__construct(
            "The ID '$id' is already used in the stack."
        );
    }
}
?>
