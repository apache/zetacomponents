<?php
/*
 * Holds the definition for MultiRelationTestPerson
 * This definition is used by the code manager for
 * various tests in the system.
 */

$def = new ezcPersistentObjectDefinition();
$def->table = "PO_database_type_test";
$def->class = "DatabaseTypeTestObject";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'PO_database_type_test_id_seq' )
);
$def->idProperty->databaseType = PDO::PARAM_INT;

$def->properties['bool'] = new ezcPersistentObjectProperty;
$def->properties['bool']->columnName = 'bool';
$def->properties['bool']->propertyName = 'bool';
$def->properties['bool']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_BOOL;
$def->properties['bool']->databaseType = PDO::PARAM_BOOL;

$def->properties['int'] = new ezcPersistentObjectProperty;
$def->properties['int']->columnName = 'int';
$def->properties['int']->propertyName = 'int';
$def->properties['int']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
$def->properties['int']->databaseType = PDO::PARAM_INT;

$def->properties['str'] = new ezcPersistentObjectProperty;
$def->properties['str']->columnName = 'str';
$def->properties['str']->propertyName = 'str';
$def->properties['str']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
$def->properties['str']->databaseType = PDO::PARAM_STR;

$def->properties['lob'] = new ezcPersistentObjectProperty;
$def->properties['lob']->columnName = 'lob';
$def->properties['lob']->propertyName = 'lob';
$def->properties['lob']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
$def->properties['lob']->databaseType = PDO::PARAM_LOB;

return $def;

?>
