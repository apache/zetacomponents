<?php
ezcTestRunner::addFileToFilter( __FILE__ );

$def = new ezcPersistentObjectDefinition();
$def->table = "PO_birthdays";
$def->class = "RelationTestBirthday";

$def->idProperty                = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName    = 'person_id';
$def->idProperty->propertyName  = 'person';
$def->idProperty->generator     = new ezcPersistentGeneratorDefinition( 'ezcPersistentManualGenerator' );

$def->properties['birthday']                 = new ezcPersistentObjectProperty;
$def->properties['birthday']->columnName     = 'birthday';
$def->properties['birthday']->propertyName   = 'birthday';
$def->properties['birthday']->propertyType   = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->relations["RelationTestPerson"]                = new ezcPersistentOneToOneRelation( "PO_birthdays", "PO_persons" );
$def->relations["RelationTestPerson"]->reverse       = true;
$def->relations["RelationTestPerson"]->columnMap     = array(
    new ezcPersistentSingleTableMap( "person_id", "id" ),
);

return $def;

?>
