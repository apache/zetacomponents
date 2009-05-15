<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "liveuser_translations";
$def->class = "testLiveuserTranslations";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'translation_id';
$def->idProperty->propertyName = 'translationId';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'liveuser_translations_translation_id_seq' )
);


$def->properties['description'] = new ezcPersistentObjectProperty;
$def->properties['description']->columnName = 'description';
$def->properties['description']->propertyName = 'description';
$def->properties['description']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['languageId'] = new ezcPersistentObjectProperty;
$def->properties['languageId']->columnName = 'language_id';
$def->properties['languageId']->propertyName = 'languageId';
$def->properties['languageId']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['name'] = new ezcPersistentObjectProperty;
$def->properties['name']->columnName = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['sectionId'] = new ezcPersistentObjectProperty;
$def->properties['sectionId']->columnName = 'section_id';
$def->properties['sectionId']->propertyName = 'sectionId';
$def->properties['sectionId']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['sectionType'] = new ezcPersistentObjectProperty;
$def->properties['sectionType']->columnName = 'section_type';
$def->properties['sectionType']->propertyName = 'sectionType';
$def->properties['sectionType']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['translationId'] = new ezcPersistentObjectProperty;
$def->properties['translationId']->columnName = 'translation_id';
$def->properties['translationId']->propertyName = 'translationId';
$def->properties['translationId']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>
