<?php
ezcTestRunner::addFileToFilter( __FILE__ );

$def = new ezcPersistentObjectDefinition();
$def->table = "PO_persons";
$def->class = "RelationTestPerson";

$def->idProperty                = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName    = 'id';
$def->idProperty->propertyName  = 'id';
$def->idProperty->generator     = new ezcPersistentGeneratorDefinition( 'ezcPersistentSequenceGenerator' );

$def->properties['firstname']                 = new ezcPersistentObjectProperty;
$def->properties['firstname']->columnName     = 'firstname';
$def->properties['firstname']->propertyName   = 'firstname';
$def->properties['firstname']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['surename']                 = new ezcPersistentObjectProperty;
$def->properties['surename']->columnName     = 'surename';
$def->properties['surename']->propertyName   = 'surename';
$def->properties['surename']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['employer']                 = new ezcPersistentObjectProperty;
$def->properties['employer']->columnName     = 'employer';
$def->properties['employer']->propertyName   = 'employer';
$def->properties['employer']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->relations["RelationTestEmployer"]                = new ezcPersistentManyToOneRelation( "PO_persons", "PO_employers" );
$def->relations["RelationTestEmployer"]->reverse       = true;
$def->relations["RelationTestEmployer"]->columnMap     = array(
    new ezcPersistentSingleTableMap( "employer", "id" ),
);

$def->relations["RelationTestBirthday"]                = new ezcPersistentOneToOneRelation( "PO_persons", "PO_birthdays" );
$def->relations["RelationTestBirthday"]->columnMap     = array(
    new ezcPersistentSingleTableMap( "id", "person_id" ),
);

$def->relations["RelationTestAddress"]                = new ezcPersistentManyToManyRelation( "PO_persons", "PO_addresses", "PO_persons_addresses" );
$def->relations["RelationTestAddress"]->columnMap     = array(
    new ezcPersistentDoubleTableMap( "id", "person_id", "address_id", "id" ),
);

return $def;

?>
