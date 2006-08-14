<?php
require_once 'PHPUnit/Framework/TestSuite.php';

class ezcTestSuite extends PHPUnit_Framework_TestSuite
{
    protected static $depth = 0;

    public function __construct( $theClass = '', $name = '' )
    {
        // Remove this file name from the assertion trace.
        // (Displayed when a test fails)
        PHPUnit_Util_Filter::addFileToFilter( __FILE__ );
 
        parent::__construct( $theClass, $name );
    }


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
