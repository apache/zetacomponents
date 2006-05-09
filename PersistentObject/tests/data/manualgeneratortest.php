<?php
/*
 * Holds the definition for PersistentTestObject
 * This definition is used by the code manager for
 * various tests in the system.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "PO_test";
$def->class = "ManualGeneratorTest";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->idProperty->generator = new ezcPersistentGeneratorDefinition( 'ezcPersistentManualGenerator' );

$def->properties['varchar'] = new ezcPersistentObjectProperty;
$def->properties['varchar']->columnName = 'type_varchar';
$def->properties['varchar']->propertyName = 'varchar';
$def->properties['varchar']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
$def->properties['varchar']->defaultValue = '';
$def->properties['varchar']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['varchar']->isRequired = false;

$def->properties['integer'] = new ezcPersistentObjectProperty;
$def->properties['integer']->columnName = 'type_integer';
$def->properties['integer']->propertyName = 'integer';
$def->properties['integer']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
$def->properties['integer']->defaultValue = 0;
$def->properties['integer']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['integer']->isRequired = false;

$def->properties['decimal'] = new ezcPersistentObjectProperty;
$def->properties['decimal']->columnName = 'type_decimal';
$def->properties['decimal']->propertyName = 'decimal';
$def->properties['decimal']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_FLOAT;;
$def->properties['decimal']->defaultValue = 0;
$def->properties['decimal']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['decimal']->isRequired = false;

$def->properties['text'] = new ezcPersistentObjectProperty;
$def->properties['text']->columnName = 'type_text';
$def->properties['text']->propertyName = 'text';
$def->properties['text']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;;
$def->properties['text']->defaultValue = '';
$def->properties['text']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['text']->isRequired = false;
return $def;

?>
