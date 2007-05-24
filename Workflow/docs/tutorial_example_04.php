<?php
// Set up database connection.
$db = ezcDbFactory::create( 'mysql://test@localhost/test' );

// Set up workflow definition storage (database).
$definition = new ezcWorkflowDatabaseDefinition( $db );

// Save workflow definition to database.
$definition->save( $workflow );
?>
