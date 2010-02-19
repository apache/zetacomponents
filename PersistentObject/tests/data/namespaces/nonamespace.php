<?php

$def = new ezcPersistentObjectDefinition();
$def->table = 'no_namespace';
$def->class = 'NoNamespace';

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( 'sequence' => 'PO_person_id_seq' )
);

return $def;

?>
