<?php
/**
 * File containing the ezcWebdavLockAdministrationException class.
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
 */
/**
 * Exception thrown if an error occurs in the administrator class.
 *
 * The {@link ezcWebdavLockAdministrator} class takes a special role in the
 * lock plugin, since it does not operate in the server, but allows you to
 * administrate the locks in your backend. If any kind of error occurs during
 * an administrative process, this exception is thrown.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavLockAdministrationException extends ezcWebdavException
{
    /**
     * Creates a new excption.
     *
     * $message explains the error. $error contains the response created by the
     * backend, if this was the reason for the exception.
     * 
     * @param mixed $message 
     * @param ezcWebdavErrorResponse $error 
     */
    public function __construct( $message, ezcWebdavErrorResponse $error = null )
    {
        parent::__construct(
            $message . ( $error !== null ? ' (' . (string) $error . ')' : '' )
        );
    }
}

?>
