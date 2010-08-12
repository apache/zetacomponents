<?php
/**
 * File containing the ezcWebdavLockIfHeaderCondition struct class.
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
 * Struct class representing an single condition element in an If header.
 *
 * The If header consists of different list types {@link
 * ezcWebdavIfHeaderList}, which contain items that represent condition sets. A
 * condition is represented by an instance of this class. Conditions are either
 * lock tokens or ETags.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockIfHeaderCondition
{
    /**
     * Content of the condition. 
     * 
     * @var string
     */
    public $content;

    /**
     * If this condition is negated. 
     * 
     * @var bool
     */
    public $negated = false;

    /**
     * Creates a new If header condition.
     * 
     * @param string $content 
     * @param bool $negated 
     */
    public function __construct( $content, $negated = false )
    {
        $this->content = $content;
        $this->negated = $negated;
    }

    /**
     * Returns the string representation of this condition.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }
}

?>
