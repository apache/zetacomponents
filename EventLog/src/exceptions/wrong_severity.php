<?php
/**
 * File containing the ezcLogWrongSeverityException class.
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
 * @package EventLog
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * The ezcLogWrongSeverityException will be thrown when an {@link ezcLogWrongSeverity} or
 * a subclass encounters an exceptional state.
 *
 * This exception is a container, containing any kind of exception.
 *
 * @apichange Remove the wrapping of exceptions.
 * @package EventLog
 * @version //autogen//
 */
class ezcLogWrongSeverityException extends ezcBaseException
{
    /**
     * Constructs a new ezcLogWrongSeverityException for severity $severity
     *
     * @param string $severity
     */
    public function __construct( $severity )
    {
        parent::__construct( "There is no severity named '{$severity}'." );
    }
}
?>
