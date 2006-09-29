<?php
ezcTestRunner::addFileToFilter( __FILE__ );

$def = new ezcPersistentObjectDefinition();
$def->table = "PO_persons";
$def->class = "RelationTestPerson";

$def->idProperty                = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName    = 'id';
$def->idProperty->propertyName  = 'id';
$def->idProperty->generator     = new ezcPersistentGeneratorDefinition( 'ezcPersistentSequenceGenerator' );

$def->properties['firstname']                 = new ezcPersistentObjectProperty;
$def->properties['firstname']->columnName     = 'firstname';
$def->properties['firstname']->propertyName   = 'firstname';
$def->properties['firstname']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['surename']                 = new ezcPersistentObjectProperty;
$def->properties['surename']->columnName     = 'surename';
$def->properties['surename']->propertyName   = 'surename';
$def->properties['surename']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['employer']                 = new ezcPersistentObjectProperty;
$def->properties['employer']->columnName     = 'employer';
$def->properties['employer']->propertyName   = 'employer';
$def->properties['employer']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>
