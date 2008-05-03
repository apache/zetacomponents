<?php
/**
 * File containing the ezcCacheStackStorageUsedTwiceException.
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown if a storage is used twice in a stack.
 *
 * @see ezcCacheStack::pushStorage()
 * @package Cache
 * @version //autogen//
 */
class ezcCacheStackStorageUsedTwiceException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheStackStorageUsedTwiceException.
     * 
     * @param string $id The ID that is already in use.
     * @return void
     */
    function __construct( ezcCacheStackableStorage $storage )
    {
        parent::__construct(
            "The storage of type '"
            . get_class( $storage ) 
            . "' with location '"
            . $storage->location 
            . "' is already used in the stack."
        );
    }
}
?>
