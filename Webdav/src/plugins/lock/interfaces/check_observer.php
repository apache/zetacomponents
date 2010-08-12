<?php
/**
 * File containing the ezcWebdavLockCheckObserver interface.
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
 * Interface that needs to be implemented by observers to lock checks.
 *
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
interface ezcWebdavLockCheckObserver
{
    /**
     * Notify about a response.
     *
     * Notifies the observer that a the given $response was checked. The
     * observer should not immediatelly perform any action on this event, but
     * just prepare actions that can be issued by the user at a later time
     * using a dedicated method. This is necessary since a later check might
     * still fail and the prepared actions must not be performed at all.
     * 
     * @param ezcWebdavPropFindResponse $response 
     */
    public function notify( ezcWebdavPropFindResponse $response );
}

?>
