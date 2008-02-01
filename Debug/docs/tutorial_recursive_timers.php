<style type="text/css">@import url("example_stylesheet.txt");</style>
<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Get the one and only instance of the ezcDebug.
$debug = ezcDebug::getInstance();

// Start the accumulator.
$debug->startTimer( "Script runtime", "Accumulators" );

// Store the name of the accumulator.
$accumulatorName = "start";
$debug->switchTimer( $accumulatorName, "Script runtime" );

// Time the loop.
$debug->startTimer ( "Five times Hello world", "output" );
for( $i = 0; $i < 5; $i++ )
{
    // Time the "Hello world" only.
    $debug->startTimer ( "Hello world", "output" );
    echo "Hello world<br/>";
    $debug->stopTimer( "Hello world" );

    // Store the accumulator.
    $debug->switchTimer( "After: hello world", $accumulatorName );
    $accumulatorName = "After: hello world"; 
}
$debug->stopTimer( "Five times Hello world" );

// Stop the accumulator
$debug->switchTimer( "stop", $accumulatorName );
$debug->stopTimer( "stop" );

// Get HTML output.
$output = $debug->generateOutput();

echo "<br/><br/>";
echo $output;

?>
