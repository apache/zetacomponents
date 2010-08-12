<?php
/**
 * File containing the ezcConfigurationException class
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
 * @package Configuration
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception that is thrown if no configuration object has been set to operate
 * on. The operation cannot continue with this object.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationNoConfigObjectException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationNoConfigObjectException.
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct( 'There is no config object to save.' );
    }
}
?>
