<?php
/**
 * File containing the ezcCacheStorageApcWrapper class.
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
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
