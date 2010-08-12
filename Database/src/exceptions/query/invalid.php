<?php
/**
 * File containing the ezcQueryException class.
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
 * @package Database
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Base class for exceptions related to the SQL abstraction.
 *
 * @package Database
 * @version //autogentag//
 */
class ezcQueryInvalidException extends ezcQueryException
{
    /**
     * Constructs a QueryInvalid exception with the type $type and the
     * additional information $message.
     *
     * $type should be used to specify the type of the query that failed.
     * Possible values are SELECT, INSERT, UPDATE and DELETE.
     *
     * Use $message to specify exactly what went wrong.
     *
     * @param string $type
     * @param string $message
     */
    public function __construct( $type, $message )
    {
        $info = "The '{$type}' query could not be built. {$message}";
        parent::__construct( $message );
    }
}
?>
