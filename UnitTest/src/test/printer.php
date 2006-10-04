<?php
require_once 'PHPUnit/TextUI/ResultPrinter.php';

ezcTestRunner::addFileToFilter( __FILE__ );

class ezcTestPrinter extends PHPUnit_TextUI_ResultPrinter
{
    public function __construct( $verbose = false )
    {
        parent::__construct( null, $verbose );
    }

    /**
     * Overrides ResultPrinter::nextColumn method to get rid of to automatic 
     * newline inserts.
     */
    protected function nextColumn() 
    {
    }

    /** 
     * Write everything except the:  .. by Sebastian Bergmann.\n\n strings.
     */
    public function write( $string )
    {
        if ( strlen( $string ) < 23 || strcmp( "by Sebastian Bergmann.\n\n", substr( $string, -24 ) ) != 0 )
        {
            print( $string );
        }
    }
}
?>
