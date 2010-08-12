<?php
/**
 * File containing the ezcDebugOperationNotPermittedException class.
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
 * @package Debug
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception thrown if an operation is not permitted.
 *
 * Changing of {@link ezcDebugStacktraceIterator} contents via ArrayAccess is
 * not permitted. If tried, this exception is throwen.
 * 
 * @package Debug
 * @version //autogen//
 */
class ezcDebugOperationNotPermittedException extends ezcDebugException
{
    /**
     * Creates an new ezcDebugOperationNotPermittedException.
     *
     * Creates a new ezcDebugOperationNotPermittedException for the given
     * $operation.
     * 
     * @param string $operation 
     */
    public function __construct( $operation )
    {
        parent::__construct(
            "The operation '$operation' is not permitted."
        );
    }
}

?>
