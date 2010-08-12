<?php
/**
 * File containing the ezcWebdavUnlockRequest class.
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
 * Abstract representation of a UNLOCK request.
 *
 * An instance of this class represents the WebDAV UNLOCK request.
 *
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavUnlockRequest extends ezcWebdavRequest
{
    /**
     * Validates the headers set in this request.
     *
     * This method validates that all required headers are available and that
     * all feasible headers for this request have valid values.
     *
     * @return void
     *
     * @throws ezcWebdavMissingHeaderException
     *         if a required header is missing.
     * @throws ezcWebdavInvalidHeaderException
     *         if a header is present, but its content does not validate.
     */
    public function validateHeaders()
    {
        if ( !isset( $this->headers['Lock-Token'] ) )
        {
            throw new ezcWebdavMissingHeaderException( 'Lock-Token' );
        }

        // Validate common HTTP/WebDAV headers
        parent::validateHeaders();
    }
}

?>
