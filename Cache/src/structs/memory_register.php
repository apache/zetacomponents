<?php
/**
 * File containing the ezcCacheStorageMemoryRegisterStruct class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Defines an APC Register structure.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageMemoryRegisterStruct extends ezcBaseStruct
{
    /**
     * Holds the ID of an entry in the registry.
     *
     * @var string
     */
    public $id;

    /**
     * Holds the attributes of an entry in the registry.
     *
     * @var array(mixed)
     */
    public $attributes;

    /**
     * Holds the identifier of an entry in the registry.
     *
     * @var string
     */
    public $identifier;

    /**
     * Holds the location of the cache.
     *
     * @var string
     */
    public $location;

    /**
     * Constructs a new ezcCacheStorageMemoryRegisterStruct.
     *
     * @param string $id
     * @param array(mixed) $attributes
     * @param string $identifier
     * @param mixed $location
     */
    public function __construct( $id, $attributes, $identifier , $location )
    {
        $this->id = $id;
        $this->attributes = $attributes;
        $this->identifier = $identifier;
        $this->location = $location;
    }
}
?>
