<?php
/**
 * File containing the ezcAuthenticationOpenidConnectionException class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Thrown when a host cannot be reached in the OpenID authentication.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationOpenidConnectionException extends ezcAuthenticationOpenidException
{
    /**
     * Constructs a new ezcAuthenticationOpenidConnectionException for the
     * URL $url.
     *
     * @param string $url URL which failed to connect
     * @param string $type An "Accept" header type, like "application/xrds+xml"
     */
    public function __construct( $url, $type = null )
    {
        $message = "Could not connect to {$url}";
        if ( $type !== null )
        {
            $message = $message . ". Type '{$type}' not supported.";
        }

        parent::__construct( $message );
    }
}
?>
