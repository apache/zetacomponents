<?php
/**
 * File containing the ezcWebdavLockCheckPathCollector class.
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
 * @package Webdav
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 *
 * @access private
 */
/**
 * Collects paths found during lock checking.
 *
 * This lock check observer class collects the paths found during lock
 * violation checks.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockCheckPathCollector implements ezcWebdavLockCheckObserver
{
    /**
     * Collected paths.
     *
     * @var array(string)
     */
    protected $paths = array();

    /**
     * Collects properties from the given $response.
     *
     * This method collects the found (status 200) properties from the given
     * propfind response. Properties for a certain path can be accessed
     * afterwards through {@link getProperties()}.
     * 
     * @param ezcWebdavPropFindResponse $response 
     * @return void
     */
    public function notify( ezcWebdavPropFindResponse $response )
    {
        $this->paths[] = $response->node->path;
    }

    /**
     * Returns collected properties for $path.
     * 
     * @param string $path 
     * @return ezcWebdavBasicPropertyStorare
     */
    public function getPaths()
    {
        return $this->paths;
    }
}

?>
