<style type="text/css">@import url("example_stylesheet.txt");</style>
<?php

require_once 'tutorial_autoload.php';

class TestFoo
{
    protected $someAttribute = 'I am an attribute';

    public function makeTest()
    {
        $bar = new TestBar( 'some param', 23 );
        $bar->informTest( array( true, 'foo' => 42.23 ), $this );
    }
}

class TestBar
{
    public $publicAttribute;
    
    private $privateAttribute;

    public function __construct( $param, $anotherParam )
    {
        $this->publicAttribute    = $param;
        $this->protectedAttribute = $anotherParam;
    }

    public function informTest( $arrayParam, $object )
    {
        // Issue log message with stacktrace
        ezcDebug::getInstance()->log(
            'informTest() called.',
            ezcLog::NOTICE,
            array(),
            true

        );
    }
}

// Example object structure.
$foo = new TestFoo();

// Genrates a stack trace internally.
$foo->makeTest();

// Print HTML output.
echo ezcDebug::getInstance()->generateOutput();

?>
