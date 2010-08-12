<?php
/**
 * File containing the ezcWebdavResource struct.
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
 * Struct class representing a non-collection resource.
 *
 * This struct is used to represent non-collection resources, in contrast to
 * {@link ezcWebdavCollection}, which represents collection resources.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavResource extends ezcBaseStruct
{
    /**
     * Path to resource
     * 
     * @var string
     */
    public $path;

    /**
     * Resource contents
     * 
     * @var string
     */
    public $content;

    /**
     * Live properties of resource.
     * 
     * @var ezcWebdavPropertyStorage
     */
    public $liveProperties;

    /**
     * Creates a new non-collection resource struct.
     * 
     * A new non-collection resource struct is crenated, representing the
     * resource referenced by $path, with the given $liveProperties and
     * $content.
     *
     * @param string $path 
     * @param ezcWebdavPropertyStorage $liveProperties 
     * @param string $content 
     * @return void
     */
    public function __construct( $path, ezcWebdavPropertyStorage $liveProperties = null, $content = null )
    {
        $this->path           = $path;
        $this->liveProperties = $liveProperties;
        $this->content        = $content;
    }
}

?>
