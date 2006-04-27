<?php
require_once 'Base/src/base.php';

// Autoload the ezcomponent classes.
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

// Use the default configuration. 
$t = new ezcTemplate();

// Compiles the template and returns the result.
// It searches for the hello_world template in the current directory.
echo $t->process( "hello_world.ezt" );
?>
