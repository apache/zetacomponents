<?php
/**
 * File containing the ezcAuthenticationOpenidStore class.
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
 * Abstract class which provides a base for store (backend) implementations to
 * be used in OpenID authentication.
 *
 * @package Authentication
 * @version //autogen//
 */
abstract class ezcAuthenticationOpenidStore
{
    /**
     * Options for OpenID stores.
     * 
     * @var ezcAuthenticationOpenidStoreOptions
     */
    protected $options;

    /**
     * Sets the options of this class to $options.
     *
     * @param ezcAuthenticationOpenidStoreOptions $options Options for this class
     */
    public function setOptions( ezcAuthenticationOpenidStoreOptions $options )
    {
        $this->options = $options;
    }

    /**
     * Returns the options of this class.
     *
     * @return ezcAuthenticationOpenidStoreOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Stores the nonce in the store.
     *
     * Returns true if the nonce was stored successfully, and false otherwise.
     *
     * @param string $nonce The nonce value to store
     * @return bool
     */
    abstract public function storeNonce( $nonce );

    /**
     * Checks if the nonce exists and afterwards deletes it.
     *
     * Returns true if the nonce can be used (exists and it is still valid), and
     * false otherwise.
     *
     * @param string $nonce The nonce value to check and delete
     * @return bool
     */
    abstract public function useNonce( $nonce );

    /**
     * Stores an association in the store linked to the OpenID provider URL.
     *
     * Returns true if the association was stored successfully, and false
     * otherwise.
     *
     * @param string $url The URL of the OpenID provider
     * @param ezcAuthenticationOpenidAssociation $association The association value to store
     * @return bool
     */
    abstract public function storeAssociation( $url, $association );

    /**
     * Returns the association linked to the OpenID provider URL.
     *
     * Returns null if the association could not be retrieved.
     *
     * @param string $url The URL of the OpenID provider
     * @return ezcAuthenticationOpenidAssociation
     */
    abstract public function getAssociation( $url );

    /**
     * Removes the association linked to the OpenID provider URL.
     *
     * Returns true if the association could be removed, and false otherwise.
     *
     * @param string $url The URL of the OpenID provider
     * @return bool
     */
    abstract public function removeAssociation( $url );
}
?>
