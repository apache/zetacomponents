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
 * Holds the definition for Table
 * This definition is used by the keywords test.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "main_table";
$def->class = "MainTable";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
$def->idProperty->generator = new ezcPersistentGeneratorDefinition( 'ezcPersistentManualGenerator' );

$def->properties['data'] = new ezcPersistentObjectProperty;
$def->properties['data']->columnName = 'data';
$def->properties['data']->propertyName = 'data';
$def->properties['data']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->relations["Rel1"] = new ezcPersistentOneToManyRelation(
     "main_table",
     "rel"
);
$def->relations["Rel1"]->columnMap = array(
     new ezcPersistentSingleTableMap(
         "id",
         "fk"
     ),
 );

$def->relations["Rel2"] = new ezcPersistentManyToManyRelation(
     "main_table",
     "rel",
     "link"
);

$def->relations["Rel2"]->columnMap = array(
    new ezcPersistentDoubleTableMap( "id", "main_id", "rel_id", "id" ),
);

return $def;

?>
