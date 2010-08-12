<?php
/**
 * File containing the ezcArchiveValueException class.
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
 * @package Archive
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception thrown when encountering a wrong archive value.
 *
 * @package Archive
 * @version //autogentag//
 */
class ezcArchiveValueException extends ezcArchiveException
{
    /**
     * Construct an archive exception.
     *
     * If $expectedValue is provided then it will be included in the exception
     * message thrown.
     *
     * @param mixed $value
     * @param mixed $expectedValue
     */
    public function __construct( $value, $expectedValue = null )
    {
        $type = gettype( $value );
        if ( in_array( $type, array( 'array', 'object', 'resource' ) ) )
        {
            $value = serialize( $value );
        }

        $msg = "The value '{$value}' is incorrect.";
        if ( $expectedValue )
        {
            $msg .= " Allowed values are: " . $expectedValue . '.';
        }
        parent::__construct( $msg );
    }
}
?>
