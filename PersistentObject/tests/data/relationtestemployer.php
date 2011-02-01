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

$def = new ezcPersistentObjectDefinition();
$def->table = "PO_employers";
$def->class = "RelationTestEmployer";

$def->idProperty                = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName    = 'id';
$def->idProperty->propertyName  = 'id';
$def->idProperty->generator     = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( "PO_employers_id_seq" )
);

$def->properties['name']                 = new ezcPersistentObjectProperty;
$def->properties['name']->columnName     = 'name';
$def->properties['name']->propertyName   = 'name';
$def->properties['name']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->relations["RelationTestPerson"]                = new ezcPersistentOneToManyRelation( "employers", "persons" );
$def->relations["RelationTestPerson"]->columnMap     = array(
    new ezcPersistentSingleTableMap( "id", "employer" ),
);
$def->relations["RelationTestPerson"]->cascade      = true;

return $def;

?>
