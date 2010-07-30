<?php
/**
 * File containing the ezcPersistentCacheManager class.
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
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Caches fetched definitions so they don't have to be read from the original source
 * for each use.
 *
 * The cache is typically used to wrap around another ezcPersistentDefinitionManager
 * of your choice.
 *
 * @version //autogen//
 * @package PersistentObject
 */
class ezcPersistentCacheManager extends ezcPersistentDefinitionManager
{
    /**
     * Holds the manager that fetches definitions.
     *
     * @var ezcPersistentDefinitionManager
     */
    private $manager;

    /**
     * Holds the persistent object definitions that are currently cached.
     *
     * @var array($className=>ezcPersistentObjectDefinition)
     */
    private $cache = array();

    /**
     * Constructs a new definition cache.
     *
     * @param ezcPersistentDefinitionManager $manager
     */
    public function __construct( ezcPersistentDefinitionManager $manager )
    {
        $this->manager = $manager;
    }

    /**
     * Returns the definition of the persistent object with the class $class.
     *
     * If a definition has been requested already the definition will be served from
     * the cache.
     *
     * @throws ezcPersistentDefinitionNotFoundException if no such definition can be found.
     * @param string $class
     * @return ezcPersistentObjectDefinition
     */
    public function fetchDefinition( $class )
    {
        if ( isset( $this->cache[$class] ) )
        {
            return $this->cache[$class];
        }

        $def = $this->manager->fetchDefinition( $class );

        // cache it
        $this->cache[$class] = $def;
        return $def;
    }
}
?>
