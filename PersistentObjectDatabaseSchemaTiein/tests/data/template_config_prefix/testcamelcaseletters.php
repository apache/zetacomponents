<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "CamelCaseLetters";
$def->class = "testCamelCaseLetters";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'CamelCaseLetters_id_seq' )
);


$def->properties['id'] = new ezcPersistentObjectProperty;
$def->properties['id']->columnName = 'id';
$def->properties['id']->propertyName = 'id';
$def->properties['id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['word'] = new ezcPersistentObjectProperty;
$def->properties['word']->columnName = 'word';
$def->properties['word']->propertyName = 'word';
$def->properties['word']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
