<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "ce_bad_word";
$def->class = "CeBadWord";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'badword_id';
$def->idProperty->propertyName = 'badwordId';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'ce_bad_word_badword_id_seq' )
);


$def->properties['badwordId'] = new ezcPersistentObjectProperty;
$def->properties['badwordId']->columnName = 'badword_id';
$def->properties['badwordId']->propertyName = 'badwordId';
$def->properties['badwordId']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['substitution'] = new ezcPersistentObjectProperty;
$def->properties['substitution']->columnName = 'substitution';
$def->properties['substitution']->propertyName = 'substitution';
$def->properties['substitution']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['word'] = new ezcPersistentObjectProperty;
$def->properties['word']->columnName = 'word';
$def->properties['word']->propertyName = 'word';
$def->properties['word']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
