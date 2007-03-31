<?php
ezcTestRunner::addFileToFilter( __FILE__ );

/*
 * Holds the definition for the class Where
 * This definition is used by the keywords test.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "where";
$def->class = "Where";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'like';
$def->idProperty->propertyName = 'like';
$def->idProperty->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->idProperty->generator = new ezcPersistentGeneratorDefinition( 'ezcPersistentSequenceGenerator',
                                                                    array( 'sequence' => 'where_like_seq' ) );

$def->properties['update'] = new ezcPersistentObjectProperty;
$def->properties['update']->columnName = 'update';
$def->properties['update']->propertyName = 'update';
$def->properties['update']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
$def->properties['update']->defaultValue = 0;
$def->properties['update']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['update']->isRequired = false;

return $def;

?>
