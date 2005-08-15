<?php
/**
 * File containing the ezcCacheStorage class.
 *
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * This is the abstract base class for all cache storages. It provides
 * the interface to be implemented by a cache backend as well as some
 * convenience methods every of these have in common. It is not recommended
 * to use a cache object directly, but to utilize the {@link ezcCacheManager}.
 * 
 * <code>
 * // Store and restore
 * $cache = new eczCacheStoragePlain('/var/cache/content/');
 * if (!($data = $cache->restore('21738_content_news'))) {
 *      // <generate data here...>
 *      $cache->store('21738_content_news', $data);
 * }
 * </code>
 *
 * <code>
 * // Purge
 * $cache = new eczCacheStoragePlain('/var/cache/content/');
 * foreach ($cache->find('*content*') as $id) {
 *      $cache->delete($id);
 * }
 * // Expire all data after 6 hours
 * $cache->expire(60*60*6);
 * // Expire all news after 30 minutes
 * $cache->expire(60*30, '*news*');
 * </code>
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
abstract class ezcCacheStorage {

    /**
     * Creates a new cache storage in the given location.
     * Creates a new cache storage for a given location. The 
     * location must be a file systems path to a valid, 
     * read/writeable directory where cache data is stored.
     *
     * @param string $location Path to the cache directory
     * @param array(string) $options Options
     */
    public function __construct( $location, $options = null ) {
        
    }

    /**
     * Store specific data to the cache storage.
     * This methode stores the given cache data into the cache 
     * assigning the ID given to it. The cache data given can
     * either be a string or an array. Certain cach storages
     * might even only accept a string and then concatinate
     * to a string or only an array and will create an array of
     * your string.
     *
     * @param mixed $data The data to store
     * @return string The ID of the newly cached data
     */
    abstract public function store( $id, $data );

    /**
     * Restore data from the cache.
     * Restores the data associated with the given cache and
     * returns it. Please see {@link ezcCacheStorage::store()}
     * for more detailed information of cachable datatypes.
     *
     * @param string $id The cache ID to restore data from
     * @return mixed The cached data.
     */
    abstract public function restore( $id );

   /**
    * Delete data from the cache.
    * Purges the cached data for a given ID.
    *
    * @param string $id The ID of the data to purge
    * @return void
    */
   abstract public function delete( $id );

   /**
    * Expires data.
    * Expires the data in a cache given on the time they have been saved.
    * All cache data which is older that time()-$ttl will be purged. To 
    * clear the cache completly, simple provide 0 as $ttl. You can additionally
    * provide a search string for your expiration that follows the same
    * rules as provided by the {@link eczCacheStorage::search()} method.
    *
    * @param int $ttl Time to live in seconds.
    * @return array(string) List of purged IDs.
    */
   abstract public function expire( $ttl, $search = null );

   /**
    * Search for cache data.
    * This method returns an array of cache ID's that fit a certain
    * search condition. Search conditions are made up of a string 
    * that contains file system globbing wildcards ('*' and 
    * '?'). The result of this method is an array of cache data
    * ID's that match the criteria given.
    *
    * @param string $search The search string.
    * @return array(int => string) Search results.
    */
   abstract public function search( $search );
}
