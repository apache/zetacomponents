<?php
require_once 'PHPUnit/Framework/TestSuite.php';

ezcTestRunner::addFileToFilter( __FILE__ );

class ezcTestSuite extends PHPUnit_Framework_TestSuite
{
    protected static $depth = 0;

    public function run( PHPUnit_Framework_TestResult $result = NULL )
    {
        print ( "\n" );
        ezcTestSuite::$depth++;

        $name = $this->getName() == "" ? "[No name given]" : $this->getName(); 

        $padding = str_repeat( "  ", ezcTestSuite::$depth  - 1 );
        print ( $padding . str_pad(  $name . ": " , 40, " ", STR_PAD_RIGHT ) );

        parent::run( $result );

        ezcTestSuite::$depth--;
    }
}
?>
