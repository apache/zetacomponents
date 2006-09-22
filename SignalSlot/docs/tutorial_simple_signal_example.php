<?php
function hello()
{
    echo "Hello world\n";
}

$signals = new ezcSignalCollection();
$signals->connect( "sayHello", "hello" );
$signals->emit( "sayHello" );
?>
