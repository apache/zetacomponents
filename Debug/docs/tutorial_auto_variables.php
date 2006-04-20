<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Same set up as the previous examples.
$log = ezcLog::getInstance();
$writer = new ezcLogWriterUnixFile( "/tmp/logs", "default.log" );
$log->getmapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer, true ) );

// ...

$username = "John Doe";
$service = "Paynet Terminal";

// ... 

// Add automatically the username to the log message, when the log message is either a SUCCESS_AUDIT or a FAILED_AUDIT.
$log->setSeverityAttributes( ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT, array( "username" => $username ) );

// Same can be done with the source of the log message.
$log->setSourceAttributes( array( "Payment" ), array( "service" => $service ) );

// Writing some log messages.
$log->log( "Authentication failed", ezcLog::FAILED_AUDIT, array( "source" => "security", "category" => "login/logoff" ) );

$log->source = "Payment"; 
$log->log( "Connecting with the server.", ezcLog::DEBUG, array( "category" => "external connections" ) );

$log->log( "Payed with creditcard.", ezcLog::SUCCESS_AUDIT, array( "category" => "shop" ) );


?>
