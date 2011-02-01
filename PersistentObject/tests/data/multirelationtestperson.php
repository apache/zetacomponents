<?php
/**
 * File containing test code for the PersistentObject component.
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

/*
 * Holds the definition for MultiRelationTestPerson
 * This definition is used by the code manager for
 * various tests in the system.
 */

$def = new ezcPersistentObjectDefinition();
$def->table = "PO_person";
$def->class = "MultiRelationTestPerson";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'PO_person_id_seq' )
);

$def->properties['name'] = new ezcPersistentObjectProperty;
$def->properties['name']->columnName = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['mother'] = new ezcPersistentObjectProperty;
$def->properties['mother']->columnName = 'mother';
$def->properties['mother']->propertyName = 'mother';
$def->properties['mother']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['father'] = new ezcPersistentObjectProperty;
$def->properties['father']->columnName = 'father';
$def->properties['father']->propertyName = 'father';
$def->properties['father']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$relations = new ezcPersistentRelationCollection();

// Mother relation

$relations['mothers_children'] = new ezcPersistentOneToManyRelation(
    'PO_person',
    'PO_person'
);
$relations['mothers_children']->columnMap = array(
    new ezcPersistentSingleTableMap( 'id', 'mother' )
);
$relations['mothers_children']->cascade = true;

$relations['mother'] = new ezcPersistentManyToOneRelation(
    'PO_person',
    'PO_person'
);
$relations['mother']->columnMap = array(
    new ezcPersistentSingleTableMap( 'mother', 'id' )
);

// Father relation

$relations['fathers_children'] = new ezcPersistentOneToManyRelation(
    'PO_person',
    'PO_person'
);
$relations['fathers_children']->columnMap = array(
    new ezcPersistentSingleTableMap( 'id', 'father' )
);

$relations['father'] = new ezcPersistentManyToOneRelation(
    'PO_person',
    'PO_person'
);
$relations['father']->columnMap = array(
    new ezcPersistentSingleTableMap( 'father', 'id' )
);

// Sibling relation

$relations['siblings'] = new ezcPersistentManyToManyRelation(
    "PO_person",
    "PO_person",
    "PO_sibling"
);
$relations['siblings']->columnMap = array(
    new ezcPersistentDoubleTableMap( "id", "person", "sibling", "id" ),
);

$def->relations['MultiRelationTestPerson'] = $relations;

return $def;

?>
