<?php
/**
 * File containing the ezcWebdavMissingTransportConfigurationException class.
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
 * Exception thrown if no transport configuration could be found to satisfy a configuration.
 *
 * This exception is thrown by {@link ezcWebdavServerConfigurationManager} if it could
 * not find an {@link ezcWebdavServerConfiguration} that provides a regex to
 * match the given $userAgent.
 *
 * This can only occur if the configuration for the basic RFC compliant {@link
 * ezcWebdavTransport} has been removed, since this one ussually does a
 * catch-all on all clients that have no special extended transport.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavMissingTransportConfigurationException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $userAgent and sets the exception
     * message from it.
     * 
     * @param string $userAgent Name of the User-Agent header that lead to the exception.
     * @return void
     */
    public function __construct( $userAgent )
    {
        parent::__construct( "There could be no ezcWebdavServerConfiguration be found to satisfy the User-Agent '$userAgent'. Seems like the basic RFC transport has also been removed." );
    }
}

?>
