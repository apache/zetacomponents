<?php
/**
 * File containing the ezcPersistentDefinitionNotFoundException class.
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
 * General exception class for the PersistentObject package.
 *
 * All exceptions in the persistent object package are derived from this exception.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentDefinitionNotFoundException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentDefinitionNotFoundException for the class $class
     * with the additional error information $message.
     *
     * @param string $class
     * @param string $message
     * @return void
     */
    public function __construct( $class, $message = null )
    {
        $info = "Could not fetch the persistent object definition for the class '$class'.";
        if ( $message !== null )
        {
            $info .= " {$message}";
        }
        parent::__construct( $info );
    }
}
?>
