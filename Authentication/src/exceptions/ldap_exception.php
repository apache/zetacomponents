<?php
/**
 * File containing the ezcAuthenticationLdapException class.
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
 * Thrown when an exceptional state occurs in the LDAP authentication.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationLdapException extends ezcAuthenticationException
{
    /**
     * Constructs a new ezcAuthenticationLdapException with error message
     * $message and error code $code.
     *
     * Code $code is received in decimal format and will be displayed in
     * hexadecimal format. See http://php.net/manual/en/function.ldap-errno.php
     * for all the error codes returned by ldap_errno().
     *
     * @param string $message Message to throw
     * @param mixed $code Error code returned by ldap_errno() function
     * @param mixed $ldapMessage Message thrown by the LDAP server
     */
    public function __construct( $message, $code = false, $ldapMessage = false )
    {
        $exMessage = $message;
        if ( $ldapMessage !== false )
        {
            $exMessage .= ': ' . $ldapMessage;
        }
        if ( $code !== false )
        {
            $exMessage .= ' (code: ' . $code . ')';
        }
        parent::__construct( $exMessage );
    }
}
?>
