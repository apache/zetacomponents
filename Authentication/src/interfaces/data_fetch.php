<?php
/**
 * File containing the ezcAuthenticationDataFetch interface.
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
 * Interface defining functionality for fetching extra data during the
 * authentication process.
 *
 * Authentication filters which support fetching additional data during
 * the authentication process can implement this interface.
 *
 * @package Authentication
 * @version //autogen//
 */
interface ezcAuthenticationDataFetch
{
    /**
     * Registers which extra data to fetch during the authentication process.
     *
     * The input $data should be an array of attributes to request, for example:
     * <code>
     * array( 'name', 'company', 'mobile' );
     * </code>
     *
     * The extra data that is possible to return depends on the authentication
     * filter. Please read the description of each filter to find out what extra
     * data is possible to fetch.
     *
     * @param array(string) $data A list of attributes to fetch during authentication
     */
    public function registerFetchData( array $data = array() );

    /**
     * Returns the extra data fetched during the authentication process.
     *
     * The return is something like this:
     * <code>
     * array( 'name' = > array( 'Dr. No' ),
     *        'company' => array( 'SPECTRE' ),
     *        'mobile' => array( '555-7732873' )
     *      );
     * </code>
     *
     * The extra data that is possible to return depends on the authentication
     * filter. Please read the description of each filter to find out what extra
     * data is possible to fetch.
     *
     * @return array(string=>mixed)
     */
    public function fetchData();
}
?>
