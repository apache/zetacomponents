<?php
/**
 * File containing test code for the DatabaseSchema component.
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
 * @package DatabaseSchema
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

return array (
  'ce_bad_word' => 
  ezcDbSchemaTable::__set_state(array(
     'fields' => 
    array (
      'badword_id' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'integer',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'substitution' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'text',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'word' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'text',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
    ),
     'indexes' => 
    array (
    ),
  )),
  'ce_message_category_rel' => 
  ezcDbSchemaTable::__set_state(array(
     'fields' => 
    array (
      'category_id' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'integer',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'is_shadow' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'boolean',
         'length' => 0,
         'notNull' => false,
         'default' => false,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'message_id' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'integer',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
    ),
     'indexes' => 
    array (
    ),
  )),
  'debugger' => 
  ezcDbSchemaTable::__set_state(array(
     'fields' => 
    array (
      'session_id' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'text',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
    ),
     'indexes' => 
    array (
    ),
  )),
  'liveuser_translations' => 
  ezcDbSchemaTable::__set_state(array(
     'fields' => 
    array (
      'description' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'text',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'language_id' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'text',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'name' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'text',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'section_id' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'integer',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'section_type' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'integer',
         'length' => 0,
         'notNull' => false,
         'default' => NULL,
         'autoIncrement' => false,
         'unsigned' => false,
      )),
      'translation_id' => 
      ezcDbSchemaField::__set_state(array(
         'type' => 'integer',
         'length' => 0,
         'notNull' => true,
         'default' => '0',
         'autoIncrement' => true,
         'unsigned' => false,
      )),
    ),
     'indexes' => 
    array (
      0 => 
      ezcDbSchemaIndex::__set_state(array(
         'indexFields' => 
        array (
          'translation_id' => 
          ezcDbSchemaIndexField::__set_state(array(
             'sorting' => NULL,
          )),
        ),
         'primary' => true,
         'unique' => false,
      )),
    ),
  )),
);

?>
