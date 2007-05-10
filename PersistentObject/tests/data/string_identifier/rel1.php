<?php
ezcTestRunner::addFileToFilter( __FILE__ );

/*
 * Holds the definition for the class Where
 * This definition is used by the keywords test.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "rel";
$def->class = "Rel1";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
$def->idProperty->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->idProperty->generator = new ezcPersistentGeneratorDefinition( 'ezcPersistentManualGenerator' );

$def->properties['fk'] = new ezcPersistentObjectProperty;
$def->properties['fk']->columnName = 'fk';
$def->properties['fk']->propertyName = 'fk';
$def->properties['fk']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
$def->properties['fk']->defaultValue = 0;
$def->properties['fk']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['fk']->isRequired = false;

return $def;

?>
