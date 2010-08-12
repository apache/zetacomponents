<?php
/**
 * File containing the ezcWebdavCollection struct.
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
 */
/**
 * Struct representing collection resources.
 *
 * This struct is used to represent collection resources, in contrast to {@link
 * ezcWebdavResource}, which represents non-collection resources.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavCollection extends ezcBaseStruct
{
    /**
     * Path to resource.
     * 
     * @var string
     */
    public $path;

    /**
     * Array with children of resource.
     * 
     * @var array(int=>ezcWebdavCollection|ezcWebdavResource)
     *
     * @apichange This property will be renamed to $children in the next major
     *            release.
     */
    public $childs;

    /**
     * Live properties of resource.
     * 
     * @var ezcWebdavPropertyStorage
     */
    public $liveProperties;

    /**
     * Creates a new collection struct.
     *
     * A new collection struct is created, representing the collection
     * referenced by $path, with the given $liveProperties and $children
     * ($childs) elements.
     * 
     * @param string $path 
     * @param ezcWebdavPropertyStorage $liveProperties 
     * @param array $children
     * @return void
     */
    public function __construct( $path, ezcWebdavPropertyStorage $liveProperties = null, array $children = array() )
    {
        $this->path = $path;
        $this->liveProperties = $liveProperties;
        $this->childs = $children;
    }
}

?>
