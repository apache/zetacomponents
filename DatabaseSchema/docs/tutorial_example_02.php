<?php
require 'tutorial_autoload.php';

// save a database schema to an XML file:
$schema->writeToFile( 'xml', 'saved-schema.xml' );

// create a database from a database schema:
$db = ezcDbFactory::create( 'mysql://user:password@host/database' );
$schema->writeToDb( $db );

// create SQL DDL for a specific database and echo it:
$db = ezcDbFactory::create( 'mysql://user:password@host/database' );
foreach ( $schema->convertToDDL( $db ) as $sqlStatement )
{
    echo $sqlStatement, "\n";
}

?>
