<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "debugger";
$def->class = "Debugger";



$def->properties['sessionId'] = new ezcPersistentObjectProperty;
$def->properties['sessionId']->columnName = 'session_id';
$def->properties['sessionId']->propertyName = 'sessionId';
$def->properties['sessionId']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
