<?php
ezcTestRunner::addFileToFilter( __FILE__ );

$def = new ezcPersistentObjectDefinition();
$def->idProperty = new ezcPersistentObjectIdProperty;
return $def;
?>
