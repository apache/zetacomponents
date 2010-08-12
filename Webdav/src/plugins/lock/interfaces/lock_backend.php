<?php
/**
 * File containing the ezcWebdavLockBackend interface.
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
 * Interface to be implemented by backends which should be used with the lock plugin.
 *
 * The lock plugin interacts with the backend only be sending {@link
 * ezcWebdavRequest} requests, except for that it requires the backend to
 * implement this interface.
 *
 * The lock plugin will lock the backend as soon as it comes into action and
 * release the lock, when all processing is done. The reason for the lock is to
 * keep communication between the lock plugin and the backend atomic.
 * 
 * @package Webdav
 * @version //autogen//
 */
interface ezcWebdavLockBackend
{
    /**
     * Acquire a backend lock.
     *
     * This method must acquire an exclusive lock of the backend. If the
     * backend is already locked by a different request, the must must retry to
     * acquire the lock continously and wait between each retry $waitTime micro
     * seconds. If $timeout microseconds have passed since the method was
     * called, it must throw an exception of type {@link
     * ezcWebdavLockTimeoutException}.
     * 
     * @param int $waitTime Microseconds.
     * @param int $timeout Microseconds.
     * @return void
     */
    public function lock( $waitTime, $timeout );

    /**
     * Release the backend lock.
     *
     * This method is called to unlock the backend. The lock that was acquired
     * using {@link lock()} must be released, so that the backend can be locked
     * by another request.
     * 
     * @return void
     */
    public function unlock();
}

?>
