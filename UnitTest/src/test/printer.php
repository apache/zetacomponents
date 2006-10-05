<?php
require_once 'PHPUnit/TextUI/ResultPrinter.php';

ezcTestRunner::addFileToFilter( __FILE__ );

class ezcTestPrinter extends PHPUnit_TextUI_ResultPrinter
{
    public function __construct( $verbose = false )
    {
        parent::__construct( null, $verbose );
    }

    protected function writeProgress($progress)
    {
        $this->write($progress);
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    /** 
     * Write everything except the:  .. by Sebastian Bergmann.\n\n strings.
     */
    public function write( $string )
    {
        if ( strlen( $string ) < 23 || strcmp( "by Sebastian Bergmann.\n\n", substr( $string, -24 ) ) != 0 )
        {
            parent::write( $string );
        }
    }
}
?>
