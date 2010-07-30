<?php
/**
 * File containing the ezcCacheStackableStorage class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Interface for stackable storage classes.
 * 
 * This interface must be implemented by storages that can be combined into a
 * {@link ezcCacheStack}.
 *
 * @package Cache
 * @version //autogentag//
 */
interface ezcCacheStackableStorage
{
    /**
     * Purge outdated data from the storage. 
     * 
     * This method purges outdated data from the cache. If $limit is given, a
     * maximum of $limit items is purged. Otherwise all outdated items are
     * purged. The method returns an array containing the IDs of all cache
     * items that have been purged.
     *
     * @param int $limit 
     * @return array(string)
     */
    public function purge( $limit = null );


    /**
     * Delete data from the cache.
     *
     * This method is already defined in {@link ezcCacheStorage::delete()}.
     * However, the basic definition does not define a return value. If this
     * interface is implemented, the method must return an array of item IDs
     * that have been deleted from the storage.
     *
     * @param string $id
     * @param array(string=>string)
     * @param bool $search
     *
     * @return array(string)
     */
    // @TODO: Does not work since this method is already declared abstract in
    // ezcCacheStorage. "Fatal error: Can't inherit abstract function..." in
    // 5.2.6RC3-dev
    // public function delete( $id = null, $attributes = array(), $search = false );

    /**
     * Reset the complete storage.
     *
     * This method resets the complete cache storage. All content (including
     * content stored with the {@link ezcCacheStackMetaDataStorage} interfacer) must
     * be deleted and the cache storage must appear as if it has just newly
     * been created.
     * 
     * @return void
     */
    public function reset();
}

?>
