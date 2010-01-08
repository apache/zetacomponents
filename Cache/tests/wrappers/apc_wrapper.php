<?php
/**
 * File containing the ezcCacheStorageApcWrapper class.
 *
 * @package Cache
 * @version //autogentag//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Access to the $registry and $apc fields. For testing purposes only.
 *
 * @package Cache
 * @version //autogentag//
 * @subpackage Tests
 */
class ezcCacheStorageApcWrapper extends ezcCacheStorageApcPlain
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
}
?>
