<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Get the one and only instance of the ezcDebug.
$debug = ezcDebug::getInstance();

// Write a log message with verbosity 1.
$debug->log( "Connecting with the Payment server", 1 );  

$debug->log( "Connected with the Payment server", 2, array( "source" => "shop", "category" => "payment" ) );  

// Get HTML output.
$output = $debug->generateOutput();

echo $output;
?>
