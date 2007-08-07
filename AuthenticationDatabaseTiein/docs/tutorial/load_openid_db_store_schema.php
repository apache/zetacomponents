<?php
require_once 'tutorial_autoload.php';

$db = ezcDbInstance::get(); // replace if you get your database instance differently

$schema = ezcDbSchema::createFromFile( 'array', 'openid_db_store_schema.dba' );
$schema->writeToDb( $db );
?>
