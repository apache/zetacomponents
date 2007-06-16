<?php
// Set up database connection.
$db = ezcDbFactory::create( 'mysql://test@localhost/test' );

// Set up database-based workflow executer.
$execution = new ezcWorkflowDatabaseExecution( $db, $id );

// Resume workflow execution.
$execution->resume(
  array( 'choice' => true )
);
?>
