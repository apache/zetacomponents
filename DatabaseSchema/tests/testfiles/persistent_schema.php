<?php
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
