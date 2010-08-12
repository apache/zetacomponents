<?php
/**
 * File containing the ezcWebdavLockAuthorizer interface.
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
 * Interface to be implemented by authorization classes for the lock plugin.
 *
 * The lock plugin requires an authorization and authentication object to be
 * used in the server, which implements this interface.
 * 
 * @package Webdav
 * @version //autogen//
 */
interface ezcWebdavLockAuthorizer extends ezcWebdavAuthorizer
{
    /**
     * Assign a $lockToken to a given $user.
     *
     * The authorization backend needs to save an arbitrary number of lock
     * tokens per user. A lock token is a of maximum length 255
     * containing:
     *
     * <ul>
     *  <li>characters</li>
     *  <li>numbers</li>
     *  <li>dashes (-)</li>
     * </ul>
     * 
     * @param string $user 
     * @param string $lockToken 
     * @return void
     */
    public function assignLock( $user, $lockToken );

    /**
     * Returns if the given $lockToken is owned by the given $user.
     *
     * Returns true, if the $lockToken is owned by $user, false otherwise.
     * 
     * @param string $user 
     * @param string $lockToken 
     * @return bool
     */
    public function ownsLock( $user, $lockToken );
    
    /**
     * Removes the assignement of $lockToken from $user.
     *
     * After a $lockToken has been released from the $user, the {@link
     * ownsLock()} method must return false for the given combination. It might
     * happen, that a lock is to be released, which already has been removed.
     * This case must be ignored by the method.
     * 
     * @param string $user 
     * @param string $lockToken 
     */
    public function releaseLock( $user, $lockToken );
}

?>
