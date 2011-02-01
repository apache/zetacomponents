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
 * Holds the definition for PersistentTestObject
 * This definition is used by the code manager for
 * various tests in the system.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "PO_test";
$def->class = "PersistentTestObjectNoId";

$def->properties['varchar'] = new ezcPersistentObjectProperty;
$def->properties['varchar']->columnName = 'type_varchar';
$def->properties['varchar']->propertyName = 'varchar';
$def->properties['varchar']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['integer'] = new ezcPersistentObjectProperty;
$def->properties['integer']->columnName = 'type_integer';
$def->properties['integer']->propertyName = 'integer';
$def->properties['integer']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['decimal'] = new ezcPersistentObjectProperty;
$def->properties['decimal']->columnName = 'type_decimal';
$def->properties['decimal']->propertyName = 'decimal';
$def->properties['decimal']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_FLOAT;;

$def->properties['text'] = new ezcPersistentObjectProperty;
$def->properties['text']->columnName = 'type_text';
$def->properties['text']->propertyName = 'text';
$def->properties['text']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;;
return $def;

?>
