<?php

require_once 'tutorial_autoload.php';

// Get the one and only instance of the ezcLog.
$log = ezcLog::getInstance();

// Get an instance to the default log mapper.
$mapper = $log->getMapper();

// Create a new Unix file writer, that writes to the file: "default.log".
$writer = new ezcLogUnixFileWriter( "/tmp/logs", "default.log" );

// Create a filter that accepts every message (default behavior).
$filter = new ezcLogFilter;

// Combine the filter with the writer in a filter rule. 
$rule = new ezcLogFilterRule( $filter, $writer, true );

// And finally assign the rule to the mapper.
$mapper->appendRule( $rule ); 

// Write a message to the log. 
$log->log( "Could not connect with the payment server.", ezcLog::WARNING );

?>
