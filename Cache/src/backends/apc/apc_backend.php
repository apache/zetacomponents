<?php
/**
 * File containing the ezcCacheApcBackend class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * This backend stores data in an APC cache.
 *
 * @deprecated This class will be deprecated in the next major version of the
 *             Cache component. Please do not use it directly, but use {@link
 *             ezcCacheStorageApc} instead.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheApcBackend extends ezcCacheMemoryBackend
{
    /**
     * Constructs a new ezcCacheApcBackend object.
     *
     * @throws ezcBaseExtensionNotFoundException
     *         If the PHP apc extension is not installed.
     */
    public function __construct()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'apc' ) )
        {
            throw new ezcBaseExtensionNotFoundException( 'apc', null, "PHP does not have APC support." );
        }
    }

    /**
     * Stores the data $var under the key $key. Returns true or false depending
     * on the success of the operation.
     *
     * @param string $key
     * @param mixed $var
     * @param int $ttl
     * @return bool
     */
    public function store( $key, $var, $ttl = 0 )
    {
        $data = new ezcCacheMemoryVarStruct( $key, $var, $ttl );
        return apc_store( $key, $data, $ttl );
    }

    /**
     * Fetches the data associated with key $key.
     *
     * @param mixed $key
     * @return mixed
     */
    public function fetch( $key )
    {
        $data = apc_fetch( $key );
        return ( is_object( $data ) ) ? $data->var : false;
    }

    /**
     * Deletes the data associated with key $key. Returns true or false depending
     * on the success of the operation.
     *
     * @param string $key
     * @return bool
     */
    public function delete( $key )
    {
        return apc_delete( $key );
    }
}
?>
