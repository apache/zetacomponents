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
$def->table = "PO_persons";
$def->class = "RelationTestSecondPerson";

$def->idProperty                = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName    = 'id';
$def->idProperty->propertyName  = 'id';
$def->idProperty->generator     = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'PO_persons_id_seq' )
);

$def->properties['firstname']                 = new ezcPersistentObjectProperty;
$def->properties['firstname']->columnName     = 'firstname';
$def->properties['firstname']->propertyName   = 'firstname';
$def->properties['firstname']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['surname']                 = new ezcPersistentObjectProperty;
$def->properties['surname']->columnName     = 'surname';
$def->properties['surname']->propertyName   = 'surname';
$def->properties['surname']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['employer']                 = new ezcPersistentObjectProperty;
$def->properties['employer']->columnName     = 'employer';
$def->properties['employer']->propertyName   = 'employer';
$def->properties['employer']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->relations["RelationTestEmployer"]                = new ezcPersistentManyToOneRelation( "PO_persons", "PO_employers" );
$def->relations["RelationTestEmployer"]->columnMap     = array(
    new ezcPersistentSingleTableMap( "employer", "id" ),
);

$def->relations["RelationTestBirthday"]                = new ezcPersistentOneToOneRelation( "PO_persons", "PO_birthdays" );
$def->relations["RelationTestBirthday"]->cascade       = true;
$def->relations["RelationTestBirthday"]->columnMap     = array(
    new ezcPersistentSingleTableMap( "id", "person_id" ),
);

$def->relations["RelationTestAddress"]                = new ezcPersistentManyToManyRelation( "PO_persons", "PO_addresses", "PO_secondpersons_addresses" );
$def->relations["RelationTestAddress"]->columnMap     = array(
    new ezcPersistentDoubleTableMap( "firstname", "person_firstname", "address_id", "id" ),
    new ezcPersistentDoubleTableMap( "surname", "person_surname", "address_id", "id" ),
);

return $def;

?>
