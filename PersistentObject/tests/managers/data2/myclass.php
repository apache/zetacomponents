<?php
ezcTestRunner::addFileToFilter( __FILE__ );

$def = new ezcPersistentObjectDefinition();
$def->class = 'MyClass';
return $def;
?>
