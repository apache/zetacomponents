<?php
require_once 'tutorial_autoload.php';

class HelloClass
{
    public static function hello()
    {
        echo "Hello world\n";
    }
}

$signals = new ezcSignalCollection();
$signals->connect( "sayHello", array( "HelloClass", "hello" ) );
$signals->emit( "sayHello" );
?>
