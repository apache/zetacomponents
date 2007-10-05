<?php
/**
 * File containing the ezcCacheStorageFileApcArrayWrapper class.
 *
 * @package Cache
 * @version //autogentag//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Access to the $registry and $backend fields. For testing purposes only.
 *
 * @package Cache
 * @version //autogentag//
 * @subpackage Tests
 */
class ezcCacheStorageFileApcArrayWrapper extends ezcCacheStorageFileApcArray
{
    /**
     * Sets the static field $registry with the provided value.
     *
     * @param array(string=>mixed) $registry
     */
    public function setRegistry( array $registry = array() )
    {
        $this->registry = $registry;
    }

    /**
     * Returns the static field $registry.
     *
     * @return array(string=>mixed)
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * Sets the backend with the provided value.
     *
     * @param ezcCacheApcBackend $backend
     */
    public function setBackend( $backend )
    {
        $this->backend = $backend;
    }

    /**
     * Fetch data from the cache.
     * This method does the fetching of the data itself (or false on failure).
     *
     * @param string $identifier The file to fetch data from
     * @param bool $useApc Use APC or the file system
     * @return mixed The fetched data or false on failure
     */
    public function fetchData( $identifier, $useApc = false )
    {
        return parent::fetchData( $identifier, $useApc );
    }

    /**
     * Returns the data because there is no need to prepare it.
     *
     * @param mixed $data Simple type or array
     * @param bool $useApc Use APC or not
     * @return mixed $data
     */
    public function prepareData( $data, $useApc = false )
    {
        return parent::prepareData( $data, $useApc );
    }

    /**
     * Calculates the lifetime remaining for a cache object.
     *
     * @param string $filename The file to calculate the remaining lifetime for
     * @param bool $useApc Use APC or not
     * @return int The remaining lifetime in seconds (0 if no time remaining)
     */
    public function calcLifetime( $filename, $useApc = false )
    {
        return parent::calcLifetime( $filename, $useApc );
    }
}
?>
