<?php
ezcTestRunner::addFileToFilter( __FILE__ );

$def = new ezcPersistentObjectDefinition();
$def->class = 'MyClass';
$def->idProperty = new ezcPersistentObjectIdProperty;
return $def;
?>
