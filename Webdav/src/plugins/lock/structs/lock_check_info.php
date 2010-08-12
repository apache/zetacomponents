<?php
/**
 * File containing the ezcWebdavLockCheckInfo struct class.
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
 * Struct containing information on lock checking for a request.
 *
 * An array of such structs is given to {@link
 * ezcWebdavLockPlugin::checkViolations()}. It contains all information
 * necessary to check violations on locks.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockCheckInfo extends ezcBaseStruct
{
    /**
     * Path to check
     * 
     * @var string
     */
    public $path;

    /**
     * Depth to check in the $path. 
     * 
     * @var ezcWebdavRequest::DEPTH_*
     */
    public $depth;

    /**
     * If header item fitting to that path 
     * 
     * @var ezcWebdavLockIfHeaderTaggedList|ezcWebdavLockIfHeaderNoTagList
     */
    public $ifHeader;

    /**
     * Authorization header content. 
     * 
     * @var ezcWebdavAuthBasic|ezcWebdavAuthDigest|null
     */
    public $authHeader;

    /**
     * Access type for auth checks. 
     * 
     * @var ezcWebdavAuthorizer::ACCESS
     */
    public $access;

    /**
     * Request generator to notify for this $path. 
     * 
     * @var ezcWebdavLockCheckObserver
     */
    public $requestGenerator;

    /**
     * If a lock-null resource may occur while checking. 
     * 
     * @var bool
     */
    public $allowSharedLocks;

    /**
     * Creates a new lock info struct.
     *
     * Creates a new struct that indicates how lock conditions should be checked.
     *
     * @param string $path
     * @param int $depth
     * @param ezcWebdavIfHeaderList $ifHeader
     * @param ezcWebdavAuth $authHeader
     * @param int $access
     * @param ezcWebdavLockCheckObserver $requestGenerator
     * @param bool $allowSharedLocks
     */
    public function __construct(
        $path                                        = '',
        $depth                                       = ezcWebdavRequest::DEPTH_INFINITY,
        $ifHeader                                    = null,
        $authHeader                                  = null,
        $access                                      = ezcWebdavAuthorizer::ACCESS_WRITE,
        ezcWebdavLockCheckObserver $requestGenerator = null,
        $allowSharedLocks                            = false
    )
    {
        $this->path             = $path;
        $this->depth            = $depth;
        $this->ifHeader         = $ifHeader;
        $this->authHeader       = $authHeader;
        $this->access           = $access;
        $this->requestGenerator = $requestGenerator;
        $this->allowSharedLocks = $allowSharedLocks;
    }
}

?>
