<?php
require 'tutorial_autoload.php';

// create the two ezcDbSchema objects:
$xmlSchema = ezcDbSchema::createFromFile( 'xml', 'wanted-schema.xml' );
$db = ezcDbFactory::create( 'mysql://user:password@host/database' );
$dbSchema = ezcDbSchema::createFromDb( $db );

// compare the schemas:
$diffSchema = ezcDbSchemaComparator::compareSchemas( $dbSchema, $xmlSchema );

// return an array containing the differences as SQL DDL to upgrade $dbSchema
// to $xmlSchema:
$sqlArray = $diffSchema->convertToDDL( $db );

// write the differences to a file:
$diffSchema->writeToFile( 'array', 'differences.php' );

// apply the differences to the database:
$diffSchema->applyToDB( $db );

?>
