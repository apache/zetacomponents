<?php
/**
 * File containing the ezcPersistentRelatedObjectNotFoundException class
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
 * Exception thrown, if the given relation class could not be found.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentRelatedObjectNotFoundException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentRelatedObjectNotFoundException for the object $object
     * which does not have a relation for $relatedClass.
     *
     * @param object $object
     * @param string $relatedClass
     * @return void
     */
    public function __construct( $object, $relatedClass )
    {
        parent::__construct( "No related object found with class '{$relatedClass}' for object of class '" . get_class( $object ) . "'." );
    }
}
?>
