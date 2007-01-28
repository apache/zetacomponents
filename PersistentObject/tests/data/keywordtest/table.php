<?php
ezcTestRunner::addFileToFilter( __FILE__ );

/*
 * Holds the definition for PersistentTestObject
 * This definition is used by the code manager for
 * various tests in the system.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "table";
$def->class = "Table";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'from';
$def->idProperty->propertyName = 'from';
$def->idProperty->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->idProperty->generator = new ezcPersistentGeneratorDefinition( 'ezcPersistentSequenceGenerator',
                                                                    array( 'sequence' => 'PO_test_seq' ) );

$def->properties['select'] = new ezcPersistentObjectProperty;
$def->properties['select']->columnName = 'select';
$def->properties['select']->propertyName = 'select';
$def->properties['select']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
$def->properties['select']->defaultValue = 0;
$def->properties['select']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['select']->isRequired = false;

return $def;

?>
