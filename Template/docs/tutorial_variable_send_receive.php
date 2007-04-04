<?php
require_once 'tutorial_autoload.php';

$t = new ezcTemplate();

$t->send->a = 2;
$t->send->b = 3;

// Process it. 
$t->process( "tutorial_variable_send_receive.ezt" );

// Retrieve the $answer variable from the template. 
echo "Answer: " . $t->receive->answer . "\n";

// Show the output.
echo $t->output;
?>
