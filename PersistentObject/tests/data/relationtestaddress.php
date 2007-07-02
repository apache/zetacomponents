<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "PO_addresses";
$def->class = "RelationTestAddress";

$def->idProperty                = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName    = 'id';
$def->idProperty->propertyName  = 'id';
$def->idProperty->generator     = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( "sequence" => "PO_addresses_id_seq" )
);

$def->properties['street']                 = new ezcPersistentObjectProperty;
$def->properties['street']->columnName     = 'street';
$def->properties['street']->propertyName   = 'street';
$def->properties['street']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['zip']                 = new ezcPersistentObjectProperty;
$def->properties['zip']->columnName     = 'zip';
$def->properties['zip']->propertyName   = 'zip';
$def->properties['zip']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['city']                 = new ezcPersistentObjectProperty;
$def->properties['city']->columnName     = 'city';
$def->properties['city']->propertyName   = 'city';
$def->properties['city']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['type']                 = new ezcPersistentObjectProperty;
$def->properties['type']->columnName     = 'type';
$def->properties['type']->propertyName   = 'type';
$def->properties['type']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->relations["RelationTestPerson"]                = new ezcPersistentManyToManyRelation( "PO_addresses", "PO_persons", "PO_persons_addresses" );
$def->relations["RelationTestPerson"]->columnMap     = array(
    new ezcPersistentDoubleTableMap( "id", "address_id", "person_id", "id" ),
);
$def->relations["RelationTestPerson"]->reverse       = true;

return $def;

?>
