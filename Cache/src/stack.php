<?php
/**
 * File containing the ezcCacheStack class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Hierarchical caching class using multiple storages.
 *
 * An instance of this class can be used to achieve so called "hierarchical
 * caching". A cache stack consists of an arbitrary number of cache storages,
 * being sorted from top to bottom. Usually this order reflects the speed of
 * access for the caches: The fastest cache is at the top, the slowest at the
 * bottom.
 *
 * @todo More documentation, examples,...
 * 
 * @mainclass
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStack extends ezcCacheStorage
{
    /**
     * Creates a new cache stack.
     *
     * Usually you will want to use the {@link ezcCacheManager} to take care of
     * your caches. The $options ({@link ezcCacheStackOptions}) stored in the
     * manager and given here can contain a class reference to an
     * implementation of {@link ezcCacheStackConfigurator} that will be used to
     * initially configure the stack instance directly after construction.
     *
     * To perform manual configuration of the stack the {@link
     * ezcCacheStack::pushStorage()} and {@link ezcCacheStack::popStorage()}
     * methods can be used.
     *
     * The location can be a free form string that identifies the stack
     * uniquely in the {@link ezcCacheManager}. It is currently not used
     * internally in the cache.
     * 
     * @param string $location 
     * @param ezcCacheStackOptions $options 
     */
    public function __construct( $location, ezcCacheStackOptions $options = null )
    {
        if ( $options === null )
        {
            $options = new ezcCacheStackOptions();
        }

        $this->properties['location'] = $location;
        $this->properties['options']  = $options;

        if ( $options->configurator !== null )
        {
            // Configure this instance
            call_user_func(
                array( $options->configurator, 'configure' ),
                $this
            );
        }
    }

    /**
     * Stores data in the cache stack.
     *
     * This method will store the given data across the complete stack. It can
     * afterwards be restored using the {@link ezcCacheStack::restore()} method
     * and be deleted through the {@link ezcCacheStack::delete()} method.
     *
     * The data that can be stored in the cache depends on the configured
     * storages. Usually it is save to store arrays and scalars. However, some
     * caches support objects or do not even support arrays. You need to make
     * sure that the inner caches of the stack *all* support the data you want
     * to store!
     *
     * The $attributes array is optional and can be used to describe the stack
     * further.
     *
     * @param string $id 
     * @param mixed $data 
     * @param array $attributes 
     */
    public function store( $id, $data, $attributes = array() )
    {
        // @TODO: Implement.
    }

    /**
     * Restores an item from the stack.
     *
     * This method tries to restore an item from the cache stack and returns
     * the found data, if any. If no data is found, boolean false is returned.
     * Given the ID of an object will restore exactly the desired object. If
     * additional $attributes are given, this may speed up the restore process
     * for some caches. If only attributes are given, the $search parameter
     * makes sense, since it will instruct the inner cach storages to search
     * their content for the given attribute combination and will restore the
     * first item found. However, this process is much slower then restoring
     * with an ID and therefore is not recommended.
     * 
     * @param string $id 
     * @param array $attributes 
     * @param bool $search 
     * @return mixed The restored data or false on failure.
     */
    public function restore( $id, $attributes = array(), $search = false )
    {
        // @TODO: Implement.
    }

    /**
     * Deletes an item from the stack.
     *
     * This method deletes an item from the cache stack. The item will
     * afterwards no more be stored in any of the inner cache storages. Giving
     * the ID of the cache item will delete exactly 1 desired item. Giving an
     * attribute array, describing the desired item in more detail, can speed
     * up the deletion in some caches.
     *
     * Giving null as the ID and just an attribibute array, with the $search
     * attribute in addition, will delete *all* items that comply to the
     * attributes from all storages. This might be much slower than just
     * deleting a single item.
     *
     * Deleting items from a cache stack is not recommended at all. Instead,
     * items should expire on their own or be overwritten with more actual
     * data.
     *
     * The method returns an array containing all deleted item IDs.
     * 
     * @param string $id 
     * @param array $attributes 
     * @param bool $search 
     * @return array(string)
     */
    public function delete( $id = null, $attributes = array(), $search = false )
    {
        // @TODO: Implement.
    }

    /**
     * Counts how many items are stored, fulfilling certain criteria.
     *
     * This method counts how many data items fulfilling the given criteria are
     * stored overall. Note: The items of all contained storages are counted
     * independantly and summarized.
     * 
     * @param string $id 
     * @param array $attributes 
     * @return int
     */
    public function countDataItems( $id = null, $attributes = array() )
    {
        // @TODO: Implement.
    }

    /**
     * Returns the remaining lifetime for the given item ID.
     *
     * This method returns the lifetime in seconds for the item identified by $item
     * and optionally described by $attributes. Definining the $attributes
     * might lead to faster results with some caches.
     *
     * The first internal storage that is found for the data item is chosen to
     * detemine the lifetime. If no storage contains the item or the item is
     * outdated in the first found cache, 0 is returned.
     * 
     * @param string $id 
     * @param array $attributes 
     * @return int
     */
    public function getRemainingLifetime( $id, $attributes = array() )
    {
        // @TODO: Implement.
    }

    /**
     * Add a storage to the top of the stack.
     *
     * This method is used to add a new storage to the top of the cache. The
     * given ID should be unique over all caches and *must* at least be unique
     * for this cache stack. If the $location parameter is used properly, this
     * can deal perfectly as the ID here.
     *
     * The ID given here may not be changed during request, since it is used in
     * an essential way internally. If you need to change the ID, you are
     * required to {@link ezcCacheStack::reset()} the whole stack.
     * 
     * Caches once added to the stack can be removed using {@link
     * ezcCacheStack::popStorage()}. You can retrieve the storages contained in
     * the stack via {@link ezcCacheStack::getStackedCaches()}. However, it is
     * not recommended to manually {@link ezcCacheStackableStorage::store()},
     * {@link ezcCacheStackableStorage::restore()} or {@link
     * ezcCacheStackableStorage::delete()} items manually in these caches. This
     * may seriously harm consistency of the stack and lead to undefined and
     * unpredictable results!
     *
     * @param string $id 
     * @param ezcCacheStackStorageConfiguration $storageConf 
     * @return void
     */
    public function pushStorage( ezcCacheStackStorageConfiguration $storageConf )
    {
        // @TODO: Implement.
    }

    /**
     * Removes a storage from the top of the stack.
     *
     * This method can be used to remove the top most {@link
     * ezcCacheStackableStorage} from the stack. This is commonly done to
     * remove caches or to insert new ones into lower positions. In both cases,
     * it is recommended to {@link ezcCacheStack::reset()} the whole cache
     * afterwards to avoid any kind of inconsistency.
     *
     * @return ezcCacheStackStorageConfiguration
     */
    public function popStorage()
    {
        // @TODO: Implement.
    }

    /**
     * Returns all stacked storages.
     *
     * This method returns the whole stack of {@link ezcCacheStackableStorage}
     * as an array. This maybe useful to adjust options of the storages after
     * they have been added to the stack. However, it is not recommended to
     * perform any drastical changes to the configurations. Performing manual
     * stores, restores and deletes on the storages is *highly discouraged*,
     * since it may lead to irrepairable inconsistencies of the stack.
     * 
     * @return array(ezcCacheStackableStorage)
     */
    public function getStackedStorages()
    {
        // @TODO: Implement.
    }

    /**
     * Resets the complete stack.
     *
     * This method is used to reset the complete stack of storages. It will
     * reset all storages, using {@link ezcCacheStackableStorage::reset()}, and
     * therefore purge the complete content of the stack. In addition, it will
     * kill the complete meta data.
     *
     * The stack is in a consistent, but empty, state afterwards.
     * 
     * @return void
     */
    public function reset()
    {
        // @TODO: Implement.
    }

    protected function validateLocation()
    {
        // @TODO: Implement.
    }
}

?>
