<?php
/**
 * File containing the ezcPersistentRelationNotFoundException class
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
 * Exception thrown, if a desired relation between 2 classes was not found.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentRelationNotFoundException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentRelationNotFoundException for the class $class
     * which does not have a relation for $relatedClass.
     *
     * @param string $class
     * @param string $relatedClass
     * @param string $relationName
     * @return void
     */
    public function __construct( $class, $relatedClass, $relationName = null )
    {
        parent::__construct(
            "Class '{$class}' does not have a relation to '{$relatedClass}'"
                . ( $relationName !== null ? " with name '$relationName'." : '.' )
        );
    }
}
?>
