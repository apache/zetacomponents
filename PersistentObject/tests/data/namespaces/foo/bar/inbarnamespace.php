<?php

$def = new ezcPersistentObjectDefinition();
$def->table = 'in_bar_namespace';
$def->class = '\\foo\\Bar\\InBarNamespace';

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'PO_person_id_seq' )
);

return $def;

?>
