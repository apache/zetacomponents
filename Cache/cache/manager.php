<?php
/**
 * File containing the ezcCacheManager class.
 *
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Class to manage multiple ezcCacheStorage objects at once. Implements
 * singletons for caches which access a certain location and supports more
 * comfortable acces to them. The usage of this class is not mandatory, but
 * recommended.
 *
 * <code>
 * // Storing and restoring
 * $manager = new CacheManager();
 * $manager->getCache('/var/cache/content/', 'plain');
 * if (!($content = $manager->restore('mydata', '/var/cache/content/'))) {
 *      // <create content here...>
 *      $contentId = $manager->store(
 *          'mydata', 
 *          '/var/cache/content/', 
 *          array('content', 'news')
 *      );
 * }
 * </code>
 * 
 * <code>
 * // Purge all news
 * $manager->getCache('/var/cache/content/', 'plain');
 * $manager->expire(0, array('news'), '/var/cache/content/');
 * 
 * // Expire the content after 2 days
 * $manager->expire(60*60*24*2, array('content'), '/var/cache/content/');
 * </code>
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcCacheManager {
    
    private static $instance;

    private static $caches;
   
    /**
     * Creates a new cache manager.
     * Private. Use getInstance() instead.
     */
    private function __construct( ) {
        
    }
    
    /**
     * Returns single instance of ezcCacheManager.
     * Implementation of the singleton pattern to asure that there
     * is only 1 ezcCacheManager for an application.
     *
     * @return ezcCacheManager The cache manager instance.
     */
    public static function getInstance( ) {
        
    }

    /**
     * Returns a unique ezcCacheStorage object.
     * This method is used to receive a ezcCacheStorage object. If the 
     * specific object does not exist, yet, it will be created. Otherwise,
     * the existing version will be used. Note, that in a specific location
     * there may only be 1 cache!
     *
     * @param string $location The cache location.
     * @param string $type The type of cache.
     * @returns ezcCacheStorage The cache requested.
     */
    public function getCache( $location, $type ) {
        
    }

    /**
     * Expire caches on basis of different criteria.
     * This method allows you to expire caches on basis of different criteria,
     * which can be combined. One basis is the attributes set for cache data, 
     * the other is based on the location. You can purge all data specified by 
     * your criteria with simple setting the $ttl value to 0.
     *
     * @param int $ttl The time to live value after which the expiration works.
     * @param array(int => string) Attributes to identify cache data.
     * @param array(int => string) Locations to consider (default is all!)
     * @return array(int => string) Array with all ID's hat have been pruged.
     */
    public function expire( $ttl, $attributes = null, $locations = null ) {
        
    }

    /**
     * Store data inside a cache.
     * Stores data in the cache addressed by the given location. This is a 
     * convenience method if you don't want to deal with caches directly.
     *
     * @param mixed $data The data to cache.
     * @param string $location The location to store the data.
     * @param array(int => string) Attributes to identify data.
     * @returns string The ID of the cached data.
     */
    function store( $data, $location, $attributes = null ) {
        
    }

    /**
     * Restore data from a cache.
     * Restores data from the cache addressed by the given location. This is a 
     * convenience method if you don't want to deal with caches directly.
     * 
     * @param string $id The ID of your cache data.
     * @param string $location The location of the data.
     * @return mixed The restored data.
     */
    public function restore( $id, $location ) {

    }
    
    /**
     * Returns a unique ID based on the provided attributes.
     * This method is utilized to generate a unique ID for your
     * cache data, based on your attributes. You can specify as 
     * many attributes as you like, as long as they follow certain 
     * rules:
     * <ul>
     * <li>An attribute may only contain the characters [a-z0-9]+</li>
     * <li>Attributes will be converted to lowercase, so don't use uppercase</li>
     * <li>Length of all attributes together may not exceed 150 characters</li>
     * </ul>
     * 
     * An attribute array looks like this:
     * array(
     *      'mymodule',
     *      'mycontent',
     *      'myotherattribute',
     * );
     *
     * Attributes allow you to manipulate cache data based on specific criteria, 
     * like e.g. purging all data that contains the 'mymodule' attribute or
     * purging all data that have the attributes 'a' and 'b'.
     * 
     * @param array (int => string) Attributes.
     * @return string The generated ID.
     */
    public function generateId( $attributes = array() ) {

    }
}
