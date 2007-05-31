<?php

require_once 'tutorial_autoload.php';

$db = ezcDbFactory::create( 'sqlite://:memory:' );
ezcDbInstance::set( $db );

// Create test table
$db->exec( 'CREATE TABLE browser_hits ( id INT, browser VARCHAR(255), hits INT )' );

// Insert some data
$db->exec( "INSERT INTO browser_hits VALUES ( NULL, 'Firefox', 2567 )" );
$db->exec( "INSERT INTO browser_hits VALUES ( NULL, 'Opera', 543 )" );
$db->exec( "INSERT INTO browser_hits VALUES ( NULL, 'Safari', 23 )" );
$db->exec( "INSERT INTO browser_hits VALUES ( NULL, 'Konquror', 812 )" );
$db->exec( "INSERT INTO browser_hits VALUES ( NULL, 'Lynx', 431 )" );
$db->exec( "INSERT INTO browser_hits VALUES ( NULL, 'wget', 912 )" );

?>
