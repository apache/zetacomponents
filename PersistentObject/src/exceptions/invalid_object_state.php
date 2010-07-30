<?php
/**
 * File containing the ezcPersistentInvalidObjectStateException class.
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception thrown if the result of $object->getState() is invalid.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentInvalidObjectStateException extends ezcPersistentObjectException
{
    /**
     * Creates a new exception.
     *
     * Creates a new ezcPersistentInvalidObjectStateException for the given
     * $object with the given $reason.
     * 
     * @param object $object 
     * @param string $reason 
     */
    public function __construct( $object, $reason = null )
    {
        parent::__construct(
            'The state returned by an object of class ' . get_class( $object ) . ' was invalid.'
                . ( $reason !== null ? " (Reason: $reason)" : '' )
        );
    }
}

?>
