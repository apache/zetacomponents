<link rel="stylesheet" type="text/css" href="example_stylesheet.css" />
<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Get the one and only instance of the ezcDebug.
$debug = ezcDebug::getInstance();

// Start the accumulator.
$debug->startTimer( "Program runtime", "Accumulators" );
$debug->switchTimer( "Start", "Program runtime" );

// Measure the time of writing "hello world".
// The name of the timer is: "Hello world" and it will be placed in the group: "output". 
$debug->startTimer ("Hello world", "output" );
echo "Hello world<br/>";
$debug->stopTimer( "Hello world" );

// Replace the "Start" timer for "Half the way".
$debug->switchTimer( "Half the way", "Start" );

// Measure the time of writing "cruel world".
$debug->startTimer( "Goodbye cruel world", "output" );
echo "Goodbye cruel world<br/>";
$debug->stopTimer( "Goodbye cruel world" );

// Stop the last timer.
$debug->switchTimer( "Stop", "Half the way" );
$debug->stopTimer( "Stop" );

// Get HTML output.
$output = $debug->generateOutput();

echo "<br/><br/>";
echo $output;
?>
