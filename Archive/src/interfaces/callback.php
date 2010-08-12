<?php
/**
 * File containing the ezcArchiveCallback class
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
 * @package Archive
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Class containing a basic implementation of the callback class to be called
 * through extract.
 *
 * @package Archive
 * @version //autogen//
 */
abstract class ezcArchiveCallback
{
    /**
     * Callback that's called for every file creation.
     *
     * The callback implementation is allowed to modify the $permissions,
     * $userId and $groupId. The latter two however might not have any
     * effect depending on which user and group the code runs at.
     *
     * @param string $fileName
     * @param int    $permissions
     * @param string $userId
     * @param string $groupId
     */
    function createFileCallback( $fileName, &$permissions, &$userId, &$groupId )
    {
    }

    /**
     * Callback that's called for every directory creation.
     *
     * The callback implementation is allowed to modify the $permissions,
     * $userId and $groupId. The latter two however might not have any
     * effect depending on which user and group the code runs at. You also need
     * to be aware that subsequent files might be put into this directory, and
     * bad things might happen when they can not be created there due to
     * operating system level restrictions.
     *
     * @param string $dirName
     * @param int    $permissions
     * @param string $userId
     * @param string $groupId
     */
    function createDirectoryCallback( $dirName, &$permissions, &$userId, &$groupId )
    {
    }
}
?>
