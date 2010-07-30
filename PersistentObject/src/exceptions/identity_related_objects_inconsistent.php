<?php
/**
 * File containing the ezcPersistentIdentityRelatedObjectsInconsistentException class.
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
 * Exception thrown if a set of related objects is inconsistent. 
 *
 * {@link ezcPersistentIdentityMap::setRelatedObjects()} and {@link
 * ezcPersistentIdentityMap::setRelatedObjectSet()}  will throw this exception,
 * if any of the objects in the set of related objects is not of the given
 * related class.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityRelatedObjectsInconsistentException extends ezcPersistentObjectException
{

    /**
     * Creates a new ezcPersistentIdentityRelatedObjectsInconsistentException.
     *
     * Creates a new ezcPersistentIdentityRelatedObjectsInconsistentException.
     * The source object is of $class with $id, the related objects are
     * expected to be of $expectedClass, but the $actualClass was found.
     *
     * @param string $class
     * @param mixed $id
     * @param string $expectedClass
     * @param string $actualClass
     */
    public function __construct( $class, $id, $expectedClass, $actualClass )
    {
        parent::__construct(
            sprintf(
                "Inconsistent relation set for object of class '%s' with ID '%s'. '%s' was expected, but '%s' was found.",
                $class,
                $id,
                $expectedClass,
                $actualClass
            )
        );
    }
}
?>
