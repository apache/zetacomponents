<?php
/**
 * File containing the ezcPersistentIdentityMissingException class.
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
 * Exception thrown if an identity is expected to be recorded, but is not found.
 *
 * {@link ezcPersistentIdentityMap::addRelatedObject()} will throw this
 * exception, if the identity of the source or of the related object does not
 * exist. In addition {@link ezcPersistentIdentityMap::removeRelatedObject()}
 * if its source object identity is not found.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityMissingException extends ezcPersistentObjectException
{

    /**
     * Creates a new ezcPersistentIdentityMissingException.
     *
     * Creates a new ezcPersistentIdentityMissingException for the object of
     * $class with ID $id.
     *
     * @param string $class
     * @param mixed $id
     * @param string $relatedClass
     * @param string $relationName
     */
    public function __construct( $class, $id )
    {
        parent::__construct(
            "The identity of the object of class '{$class}' with ID '{$id}' was expected to exists, but not found in the identity map."
        );
    }
}
?>
