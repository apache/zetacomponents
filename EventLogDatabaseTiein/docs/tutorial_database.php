<?php
require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Get the database instance
$db = ezcDbInstance::get();

// Get the log instance
$log = ezcLog::getInstance();

// Create a database writer attached to the database handler and the table "log"
$writer = new ezcLogDatabaseWriter( $db, "log" );

// Specify that log messages will be written to the database
$log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer, true ) );

// Write a log entry ( message, severity, source, category )
$log->log( "File '/images/spacer.gif' does not exist.", ezcLog::WARNING, array( "source" => "Application", "category" => "Design" ) );

// Write a log entry ( message, severity, source, category, file, line )
$log->log( "File '/images/spacer.gif' does not exist.", ezcLog::WARNING, array( "source" => "Application", "category" => "Design" ), array( "file" => "/index.php", "line" => 123 ) );

?>
