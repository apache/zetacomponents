<?php
/**
 * File containing the ezcCacheStorageApc class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * This class is a common base class for all APC based storage classes.
 * To implement an APC based cache storage, you simply have to derive
 * from this class and implement the {@link ezcCacheStorageApc::fetchData()}
 * and {@link ezcCacheStorageApc::prepareData()} methods.
 *
 * For example code of using a cache storage, see {@link ezcCacheManager}.
 *
 * The Cache package already contains these implementations of this class:
 *  - {@link ezcCacheStorageApcPlain}
 *  - {@link ezcCacheStorageFileApcArray}
 *
 * @package Cache
 * @version //autogentag//
 */
abstract class ezcCacheStorageApc extends ezcCacheStorageMemory
{
    /**
     * The backend name.
     */
    const BACKEND_NAME = "Apc";

    /**
     * The registry name.
     */
    const REGISTRY_NAME = 'ezcCacheStorageApc_Registry';

    /**
     * Creates a new cache storage in the given location.
     *
     * Options can contain the 'ttl' (Time-To-Live). This is per default set
     * to 1 day.
     *
     * For details about the options see {@link ezcCacheStorageApcOptions}.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If you tried to set a non-existent option value.
     *
     * @param string $location Path to the cache location
     * @param array(string=>string) $options Options for the cache
     */
    public function __construct( $location = null, array $options = array() )
    {
        parent::__construct( $location, array() );

        // Overwrite parent set options with new ezcCacheStorageApcOptions
        $this->properties['options'] = new ezcCacheStorageApcOptions( $options );

        $this->backend = new ezcCacheApcBackend();
        $this->registryName = self::REGISTRY_NAME;
        $this->backendName = self::BACKEND_NAME;
    }

    /**
     * Fetches data from the cache.
     *
     * @param string $identifier The APC identifier to fetch data from
     * @return mixed The fetched data or false on failure
     */
    abstract protected function fetchData( $identifier );

    /**
     * Prepares the data for storing.
     *
     * @throws ezcCacheInvalidDataException
     *         If the data submitted can not be handled by this storage (object,
     *         resource).
     *
     * @param mixed $data Simple type or array
     * @return mixed Prepared data
     */
    abstract protected function prepareData( $data );
}
?>
