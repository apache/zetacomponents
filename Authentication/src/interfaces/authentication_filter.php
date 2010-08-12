<?php
/**
 * File containing the ezcAuthenticationFilter class.
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
 * Base class for all authentication filters.
 *
 * The classes which extend this class must implement the run() method.
 *
 * This class contains the STATUS_OK constant (with value 0) which is returned
 * by the run() method in case of success. Subclasses must define their own
 * constants to be returned in case of insuccess.
 *
 * This class adds support for options for subclasses, by providing the protected
 * property $options, and the public methods setOptions() and getOptions().
 *
 * @package Authentication
 * @version //autogen//
 */
abstract class ezcAuthenticationFilter
{
    /**
     * Successful authentication.
     */
    const STATUS_OK = 0;

    /**
     * Options for authentication filters.
     * 
     * @var ezcAuthenticationFilterOptions
     */
    protected $options;

    /**
     * Sets the options of this class to $options.
     *
     * @param ezcAuthenticationFilterOptions $options Options for this class
     */
    public function setOptions( ezcAuthenticationFilterOptions $options )
    {
        $this->options = $options;
    }

    /**
     * Returns the options of this class.
     *
     * @return ezcAuthenticationFilterOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Runs the filter and returns a status code when finished.
     *
     * @param ezcAuthenticationCredentials $credentials Authentication credentials
     * @return int
     */
    abstract public function run( $credentials );
}
?>
