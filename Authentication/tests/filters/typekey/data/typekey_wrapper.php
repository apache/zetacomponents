<?php
/**
 * File containing the ezcAuthenticationTypekeyWrapper class.
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
 * @subpackage Tests
 */

/**
 * Class which exposes the protected methods from the TypeKey filter.
 *
 * For testing purposes only.
 *
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 * @access private
 */
class ezcAuthenticationTypekeyWrapper extends ezcAuthenticationTypekeyFilter
{
    /**
     * Checks the information returned by the TypeKey server.
     *
     * @param string $msg Plain text signature which needs to be verified
     * @param string $r First part of the signature retrieved from TypeKey
     * @param string $s Second part of the signature retrieved from TypeKey
     * @param array(string=>string) $keys Public keys retrieved from TypeKey
     * @return bool
     */
    protected function checkSignature( $msg, $r, $s, $keys )
    {
        return parent::checkSignature( $msg, $r, $s, $keys );
    }

    /**
     * Fetches the public keys from the specified file or URL $file.
     *
     * The file must be composed of space-separated values for p, g, q, and
     * pub_key, like this:
     *   p=<value> g=<value> q=<value> pub_key=<value>
     *
     * The format of the returned array is:
     * <code>
     *   array( 'p' => p_val, 'g' => g_val, 'q' => q_val, 'pub_key' => pub_key_val )
     * </code>
     *
     * @throws ezcAuthenticationTypekeyException
     *         if the keys from the TypeKey public keys file could not be fetched
     * @return array(string=>string)
     */
    public function fetchPublicKeys( $file )
    {
        return parent::fetchPublicKeys( $file );
    }
}
?>
