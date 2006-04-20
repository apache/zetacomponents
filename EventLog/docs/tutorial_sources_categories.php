<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Same set up as the previous example.
$log = ezcLog::getInstance();
$writer = new ezcLogUnixFileWriter( "/tmp/logs", "default.log" );
$log->getmapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer, true ) );

// Set the source and category.
$log->source = "Payment module";
$log->category = "Template";

$log->log( "Could not find cache file: </var/cache/payment1234.cache>.", ezcLog::WARNING );

// ...

// Write a SQL error. The category is set to SQL for this message only. 
$log->log( "Cannot execute query: <SELECT * FROM Orders WHERE ID = '123'>.", ezcLog::ERROR, array( "category" => "SQL" ) );

// ...

// Write a debug message that includes the current filename and line number.
// The category is left out.
$log->log( "Starting shutdown process.", ezcLog::DEBUG, array( "category" => "", "file" => __FILE__, "line" => __LINE__ ) );

?>
