<?php
/**
 * File containing the ezcCacheMemcacheException class.
 *
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown when encountering an error in the Memcache backend.
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheMemcacheException extends ezcBaseException
{
    /**
     * Creates a new ezcCacheMemcacheException.
     * 
     * @param mixed $message The message to throw
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
