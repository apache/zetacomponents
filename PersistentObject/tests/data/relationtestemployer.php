<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "PO_employers";
$def->class = "RelationTestEmployer";

$def->idProperty                = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName    = 'id';
$def->idProperty->propertyName  = 'id';
$def->idProperty->generator     = new ezcPersistentGeneratorDefinition(
    'ezcPersistentSequenceGenerator',
    array( "PO_employers_id_seq" )
);

$def->properties['name']                 = new ezcPersistentObjectProperty;
$def->properties['name']->columnName     = 'name';
$def->properties['name']->propertyName   = 'name';
$def->properties['name']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->relations["RelationTestPerson"]                = new ezcPersistentOneToManyRelation( "employers", "persons" );
$def->relations["RelationTestPerson"]->columnMap     = array(
    new ezcPersistentSingleTableMap( "id", "employer" ),
);
$def->relations["RelationTestPerson"]->cascade      = true;

return $def;

?>
