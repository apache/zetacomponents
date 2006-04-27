<?php
require_once 'tutorial_autoload.php';

$t = new ezcTemplate();

// Send the variable: $quote to the template. 
$t->send->quote = "I am not a number, I am a free man.";

// Process it. 
$t->process( "send_receive.ezt" );

// Retrieve the $number variable from the template. 
echo "You are number " . $t->receive->number . "\n";

// Show the output.
echo $t->output;
?>
