<?php
/**
 * File containing the ezcPersistentSessionNotFoundException class.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * This exceptions is used when a database handler could not be found.
 *
 * @version //autogen//
 * @package PersistentObject
 */
class ezcPersistentSessionNotFoundException extends ezcPersistentObjectException
{
    /**
     * Constructs a new exception.
     *
     * $name specifies the name of the name of the handler to use.
     * $known is a list of the known database handlers.
     *
     * @param string $name
     * @param array $known
     */
    public function __construct( $name, array $known = array() )
    {
        if ( $name == '' || $name == null )
        {
            $name = 'no name provided';
        }
        $message = "Could not find the persistent session: {$name}.";

        if ( count( $known ) > 0 )
        {
            $knownMessage = ' The known sessions are: ' . implode( ', ', $known ) . '.';
            $message .= $knownMessage;
        }
        parent::__construct( $message );
    }
}
?>
