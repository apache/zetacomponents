<?php
// Set up database connection.
$db = ezcDbFactory::create( 'mysql://test@localhost/test' );

// Set up database-based workflow executer.
$execution = new ezcWorkflowDatabaseExecution( $db, $id );

// Cancel workflow execution.
$execution->cancel();
?>
