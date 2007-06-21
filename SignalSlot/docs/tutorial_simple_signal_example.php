<?php
require_once 'tutorial_autoload.php';

function hello()
{
    echo "Hello world\n";
}

$signals = new ezcSignalCollection();
$signals->connect( "sayHello", "hello" );
$signals->emit( "sayHello" );
?>
