<?php
/**
 * File containing the ezcPersistentRelationFindDefinition struct.
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
 * Struct class representing a relation find definition.
 *
 * This struct class is used in ezcPersistentSessionIdentityDecorator to define a tree
 * of relations to be fetched from the database in one go. This struct is used
 * with {@link ezcPersistentSessionIdentityDecorator::loadWithRelatedObjects()}.
 *
 * The $relatedClass referes to a class name that is related by the original
 * class to load. If this relation consists of a collection of named relations,
 * $relationName must be set in addition. The $furtherRelations property can be
 * used to define further relations that related to $relatedClass.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentRelationFindDefinition extends ezcBaseStruct
{
    /**
     * The related class that should be fetched.
     * 
     * @var string
     */
    public $relatedClass;

    /**
     * The name of the relation.
     *
     * Must only be not null, if relations to this class is a collection of
     * named relations.
     * 
     * @var string
     */
    public $relationName;

    /**
     * Deeper relation definitions.
     * 
     * @var array(ezcPersistentRelationFindDefinition)
     */
    public $furtherRelations = array();

    /**
     * Definition object for this $relatedClass. 
     *
     * This attribute may not be accessed by the user, but is used by {@link
     * ezcPersistentSessionIdentityDecorator} internally to transport information.
     * 
     * @var ezcPersistentObjectDefinition
     * @access private
     */
    public $definition;

    /**
     * Definition of the relation from its parent class. 
     *
     * This attribute may not be accessed by the user, but is used by {@link
     * ezcPersistentSessionIdentityDecorator} internally to transport information.
     * 
     * @var ezcPersistentRelation
     * @access private
     */
    public $relationDefinition;

    /**
     * Creates a new relation find definition.
     *
     * @param string $relatedClass
     * @param string $relationName
     * @param array(ezcPersistentRelationFindDefinition) $furtherRelations
     */
    public function __construct( $relatedClass, $relationName = null, array $furtherRelations = array() )
    {
        $this->relatedClass     = $relatedClass;
        $this->relationName     = $relationName;
        $this->furtherRelations = $furtherRelations;
    }
}

?>
