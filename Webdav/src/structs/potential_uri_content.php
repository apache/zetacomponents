<?php
/**
 * File containing the ezcWebdavPotentialUriContent struct.
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
 * Struct representing a text that is potentially considered an URI.
 *
 * Some Webdav property values might either contain plain text or an URI,
 * covered in an <href> XML element. This struct is used to represent such
 * information. If the content of the property is an URI, the $isUri property
 * is set to true. Otherwise it is false. The $content property contains the
 * plain text content.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavPotentialUriContent extends ezcBaseStruct
{
    /**
     * Text content.
     * 
     * @var string
     */
    public $content;

    /**
     * If the text content is to be considered an URI. 
     * 
     * @var bool
     */
    public $isUri;

    /**
     * Creates a new potential URI content struct.
     * 
     * @param string $content 
     * @param bool $isUri 
     */
    public function __construct( $content = '', $isUri = false )
    {
        $this->content = $content;
        $this->isUri   = $isUri;
    }

    /**
     * Converts the object to a string.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }
}

?>
