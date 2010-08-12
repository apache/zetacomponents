<?php
/**
 * File containing the ezcPersistentIdentifierGenerationException class
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
 * @package PersistentObject
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Exception thrown when generating an ID for a persistent object failed.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentifierGenerationException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentIdentifierGenerationException for the class
     * $class with the optional message $msg.
     *
     * @param string $class
     * @param string $msg
     * @return void
     */
    public function __construct( $class, $msg = null )
    {
        $info = "Could not create an identifier for the object of type '$class'.";
        if ( $info != null )
        {
            $info .= " $msg";
        }
        parent::__construct( $info );
    }
}
?>
