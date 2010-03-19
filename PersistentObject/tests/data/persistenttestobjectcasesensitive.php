<?php
/*
 * Holds the definition for PersistentTestObject
 * This definition is used by the code manager for
 * various tests in the system.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "PO_test";
$def->class = "PersistentTestObjectCasesensitive";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'ID';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'PO_test_ID_seq' )
);

$def->properties['varChar'] = new ezcPersistentObjectProperty;
$def->properties['varChar']->columnName = 'Type_VarCHAR';
$def->properties['varChar']->propertyName = 'varChar';
$def->properties['varChar']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['integer'] = new ezcPersistentObjectProperty;
$def->properties['integer']->columnName = 'tYPe_inTEGer';
$def->properties['integer']->propertyName = 'integer';
$def->properties['integer']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['DECIMAL'] = new ezcPersistentObjectProperty;
$def->properties['DECIMAL']->columnName = 'type_decimal';
$def->properties['DECIMAL']->propertyName = 'DECIMAL';
$def->properties['DECIMAL']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_FLOAT;;

$def->properties['text'] = new ezcPersistentObjectProperty;
$def->properties['text']->columnName = 'TYPE_TEXT';
$def->properties['text']->propertyName = 'text';
$def->properties['text']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;;
return $def;

?>
