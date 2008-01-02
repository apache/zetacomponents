<?php
/**
 * File containing the ezcCacheMemoryBackend class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * An abstract class defining the required methods for memory handlers.
 *
 * Implemented in:
 *  - {@link ezcCacheApcBackend}
 *  - {@link ezcCacheMemcacheBackend}
 *
 * @package Cache
 * @version //autogentag//
 */
abstract class ezcCacheMemoryBackend
{
    /**
     * Stores the data $var under the key $key.
     *
     * @param string $key
     * @param mixed $var
     * @param int $ttl
     * @return bool
     */
    abstract public function store( $key, $var, $ttl = 0 );

    /**
     * Fetches the data associated with key $key.
     *
     * @param string $key
     * @return mixed
     */
    abstract public function fetch( $key );

    /**
     * Deletes the data associated with key $key.
     *
     * @param string $key
     * @return bool
     */
    abstract public function delete( $key );
}
?>
