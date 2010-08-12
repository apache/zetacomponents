<?php
/**
 * File containing the ezcAuthenticationStatus class.
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
 * Holds the statuses returned from each authentication filter.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationStatus
{
    /**
     * Holds the statuses returned by the authentication filters.
     *
     * var array(string=>mixed)
     */
    private $statuses = array();

    /**
     * Adds a new status to the list of statuses.
     *
     * @param string $class The class name associated with the status
     * @param mixed|array(mixed) $status A status associated with the class name
     */
    public function append( $class, $status )
    {
        if ( is_array( $status ) )
        {
            $this->statuses = array_merge( $this->statuses, $status );
        }
        else
        {
            $this->statuses[] = array( $class => $status );
        }
    }

    /**
     * Returns the list of authentication statuses.
     *
     * The format of the returned array is array( class => code ).
     *
     * Example:
     * <code>
     * array(
     * 'ezcAuthenticationSession' => ezcAuthenticationSession::STATUS_EMPTY,
     * 'ezcAuthenticationDatabaseFilter' => ezcAuthenticationDatabaseFilter::STATUS_PASSWORD_INCORRECT
     *      );
     * </code>
     *
     * @return array(string=>mixed)
     */
    public function get()
    {
        return $this->statuses;
    }
}
?>
