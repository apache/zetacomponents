<?php
/**
 * File containing the ezcCacheMemoryVarStruct class.
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
 * Defines a memory var structure.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheMemoryVarStruct extends ezcBaseStruct
{
	/**
     * Holds the cache key.
     *
	 * @var string
	 */
	public $key;

	/**
     * Holds the data associated with the key.
     *
	 * @var mixed
	 */
	public $var;

	/**
     * Holds the TTL value of the cache.
     *
	 * @var int
	 */
	public $ttl;

    /**
     * Constructs a new ezcCacheMemoryVarStruct object.
     *
	 * @param string $key
	 * @param mixed $var
	 * @param int $ttl
     */
    public function __construct( $key, $var, $ttl )
    {
		$this->key = $key;
		$this->var = $var;
		$this->ttl = $ttl;
    }
}
?>
