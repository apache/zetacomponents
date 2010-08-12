<?php
/**
 * File containing the ezcWebdavLockAccessDeniedException class.
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 *
 * @access private
 */
/**
 * Exception thrown if access was denied during lock violation checks.
 *
 * This exception is thrown while extracting the properties needed to check
 * lock violations. It is not bubbled up the server, but handled in {@link
 * ezcWebdavLockTools::checkViolations()}.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockAccessDeniedException extends ezcWebdavException
{
    /**
     * Creates a new lock access denied exception.
     *
     * Access was denied to $node, while checking lock conditions.
     * 
     * @param ezcWebdavResource|ezcWebdavCollection $node 
     */
    public function __construct( $node )
    {
        parent::__construct(
            "Access denied to '{$node->path}'."
        );
    }
}

?>
