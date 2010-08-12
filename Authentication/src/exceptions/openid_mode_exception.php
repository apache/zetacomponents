<?php
/**
 * File containing the ezcAuthenticationOpenidModeNotSupportedException class.
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
 * Thrown when trying OpenID authentication with a mode which is not supported.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationOpenidModeNotSupportedException extends ezcAuthenticationOpenidException
{
    /**
     * Constructs a new ezcAuthenticationOpenidModeNotSupportedException with
     * OpenID mode $mode.
     *
     * @param string $mode OpenID mode which is not supported
     */
    public function __construct( $mode )
    {
        parent::__construct( "OpenID request not supported: 'openid_mode = {$mode}'." );
    }
}
?>
