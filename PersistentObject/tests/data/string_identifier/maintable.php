<?php
ezcTestRunner::addFileToFilter( __FILE__ );

/*
 * Holds the definition for Table
 * This definition is used by the keywords test.
 */
// build definition
$def = new ezcPersistentObjectDefinition();
$def->table = "main_table";
$def->class = "MainTable";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
$def->idProperty->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->idProperty->generator = new ezcPersistentGeneratorDefinition( 'ezcPersistentManualGenerator' );

$def->properties['data'] = new ezcPersistentObjectProperty;
$def->properties['data']->columnName = 'data';
$def->properties['data']->propertyName = 'data';
$def->properties['data']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
$def->properties['data']->defaultValue = 0;
$def->properties['data']->visibility = ezcPersistentObjectProperty::VISIBILITY_PRIVATE;
$def->properties['data']->isRequired = false;

$def->relations["Rel1"] = new ezcPersistentOneToManyRelation(
     "main_table",
     "rel"
);
$def->relations["Rel1"]->columnMap = array(
     new ezcPersistentSingleTableMap(
         "id",
         "fk"
     ),
 );

$def->relations["Rel2"] = new ezcPersistentManyToManyRelation(
     "main_table",
     "rel",
     "link"
);

$def->relations["Rel2"]->columnMap = array(
    new ezcPersistentDoubleTableMap( "id", "main_id", "rel_id", "id" ),
);

return $def;

?>
