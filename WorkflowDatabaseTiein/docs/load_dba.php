<?php
$db = ezcDbInstance::get(); // replace if you get your database instance differently

$schema = ezcDbSchema::createFromFile( 'array', 'workflow.dba' );
$schema->writeToDb( $db );
?>
