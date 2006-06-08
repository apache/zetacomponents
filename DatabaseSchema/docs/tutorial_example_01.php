<?php
require 'tutorial_autoload.php';

// create a database schema from an XML file:
$xmlSchema = ezcDbSchema::createFromFile( 'xml', 'wanted-schema.xml' );

// create a database schema from a database connection:
$db = ezcDbFactory::create( 'mysql://user:password@host/database' );
$dbSchema = ezcDbSchema::createFromDb( $db );

?>
