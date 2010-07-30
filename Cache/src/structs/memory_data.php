<?php
/**
 * File containing the ezcCacheStorageMemoryDataStruct class.
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
 * Defines a memory data storage structure.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageMemoryDataStruct extends ezcBaseStruct
{
    /**
     * Holds the actual data.
     *
     * @var mixed
     */
    public $data;

    /**
     * Holds the time the data was introduced in the cache.
     *
     * @var string
     */
    public $time;

    /**
     * Holds the location of the cache.
     *
     * @var string
     */
    public $location;

    /**
     * Constructs a new ezcCacheMemoryDataStruct.
     *
     * @param mixed $data
     * @param string $location
     */
    public function __construct( $data, $location )
    {
        $this->data = $data;
        $this->location = $location;
        $this->time = time();
    }
}
?>
