<?php
require_once 'PHPUnit/TextUI/ResultPrinter.php';

class ezcTestPrinter extends PHPUnit_TextUI_ResultPrinter
{
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
