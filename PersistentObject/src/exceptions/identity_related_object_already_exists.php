<?php
/**
 * File containing the ezcPersistentIdentityRelatedObjectAlreadyExistsException class.
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
 * Exception thrown if a related objects is added twice to a set of related objects.
 *
 * {@link ezcPersistentIdentityMap::addRelatedObject()} throws this exception,
 * if the same related object is added twice.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityRelatedObjectAlreadyExistsException extends ezcPersistentObjectException
{

    /**
     * Creates a new ezcPersistentIdentityRelatedObjectAlreadyExistsException.
     *
     * Creates a new ezcPersistentIdentityRelatedObjectAlreadyExistsException
     * for the object of $class with ID $id and the related objects of class
     * $relatedClass, with optional set name $relationName.
     *
     * @param string $class
     * @param mixed $id
     * @param string $relatedClass
     * @param mixed $relatedId
     * @param string $relationName
     */
    public function __construct( $class, $id, $relatedClass, $relatedId, $relationName = null )
    {
        parent::__construct(
            sprintf(
                "The object of class '%s' with ID '%s' is already related to the object of class '%s' with ID '%s'%s.",
                $relatedClass,
                $relatedId,
                $class,
                $id,
                ( $relationName !== null ? " over the relation '$relationName'" : '' )
            )
        );
    }
}
?>
