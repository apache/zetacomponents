<?php
require 'tutorial_autoload.php';

// save a database schema to an XML file:
$schema->saveToFile( 'array', 'saved-schema.php' );

// create a database from a database schema:
$db = ezcDbFactory::create( 'mysql://user:password@host/database' );
$schema->saveToDb( $db );

// create SQL DDL for a specific database and echo it:
$db = ezcDbFactory::create( 'mysql://user:password@host/database' );
foreach ( $schema->convertToDDL( $db ) as $sqlStatement )
{
    echo $sqlStatement, "\n";
}

?>
