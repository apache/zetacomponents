<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Open database connection.
$db = ezcDbFactory::create( "mysql://root@localhost/logs" );

// Create the database writer.
// Attach to the database handler. And write log entries to the table: "default".
$writer = new ezcLogDatabaseWriter( $db, "general" );

$log = ezcLog::getInstance();

// Write everything to the database.
$log->getmapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer, true ) );

// Write a message
$log->log( "Cannot load Payment module", ezcLog::ERROR, array( "source" => "shop", "category" => "modules" ) );

?>
