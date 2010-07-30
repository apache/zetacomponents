<?php
/**
 * File containing the ezcPersistentRelationOperationNotSupportedException class
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
 * Exception thrown, if the given relation class ćould not be found.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentRelationOperationNotSupportedException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentRelationOperationNotSupportedException for
     * the $class which does not support the $operation in respect to
     * $relatedClass. Optionally a $reason can be given.
     *
     * @param string $class
     * @param string $relatedClass
     * @param string $operation
     * @param string $reason
     * @return void
     */
    public function __construct( $class, $relatedClass, $operation, $reason = null )
    {
        parent::__construct(
            "The relation between '{$class}' and '{$relatedClass}' does not support the operation '{$operation}'." .
                ( $reason !== null ? " Reason: '{$reason}'." : "" )
        );
    }
}
?>
