<?php
/**
 * ezcConsoleToolsOutputTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleProgressbar class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsProgressbarTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleToolsProgressbarTest" );
	}
    
    public function testProgress1()
    {
        $this->commonProgressbarTest( __FUNCTION__, 42, 13, array () );
    }
    
    public function testProgress2()
    {
        $this->commonProgressbarTest( __FUNCTION__, 20, 32, array () );
    }
    
    public function testProgress3()
    {
        $this->commonProgressbarTest( __FUNCTION__, 42, 13, array ( 'barChar' => '#', 'emptyChar' => '*' ) );
    }
    
    public function testProgress4()
    {
        $this->commonProgressbarTest( __FUNCTION__, 55, 19, array ( 'progressChar' => '&' ) );
    }
    
    public function testProgress5()
    {
        $this->commonProgressbarTest( __FUNCTION__, 42, 13, array ( 'progressChar' => '&', 'width' => 55 ) );
    }
    
    public function testProgress6()
    {
        $this->commonProgressbarTest( __FUNCTION__, 22, 3, array ( 'barChar' => '#', 'emptyChar' => '*', 'progressChar' => '&', 'width' => 81 ) );
    }
    
    public function testProgress7()
    {
        $this->commonProgressbarTest( __FUNCTION__, 42, 7, array ( 'barChar' => '1234', 'emptyChar' => '9876' ) );
    }
    
    public function testProgress8()
    {
        $this->commonProgressbarTest( __FUNCTION__, 42, 7, array ( 'barChar' => '123', 'emptyChar' => '987', 'progressChar' => '---' ) );
    }
    
    public function testProgress9()
    {
        $out = new ezcConsoleOutput();
  
        $formatString = ''
            . $out->formatText( 'Actual progress', 'success' )
            . ': <'
            . $out->formatText( '%bar%', 'failure' )
            . '> '
            . $out->formatText( '%fraction%', 'success' );
        
        $this->commonProgressbarTest( 
            __FUNCTION__, 
            1073, 
            123, 
            array( 
                'barChar' => '123', 
                'emptyChar' => '987', 
                'progressChar' => '---', 
                'width' => 97, 
                'formatString' => $formatString,
                'fractionFormat' => '%o'
            ) 
       );
    }
    
    public function testProgress10()
    {
        $this->commonProgressbarTest( __FUNCTION__, 100, 1, array ( 'redrawFrequency' => 10 ) );
    }
    
    public function testProgress11()
    {
        $this->commonProgressbarTest( __FUNCTION__, 100, 2.5, array ( 'actFormat' => '%01.2f', 'maxFormat' => '%01.2f' ) );
    }
    
    public function testProgress12()
    {
        $this->commonProgressbarTest( __FUNCTION__, 100, 2.5, array ( 'actFormat' => '%01.2f', 'maxFormat' => '%01.8f' ) );
    }
    
    public function testProgress13()
    {
        $this->commonProgressbarTest( __FUNCTION__, 100, 2.5, array ( 'actFormat' => '%01.8f', 'maxFormat' => '%01.2f' ) );
    }
    
    private function commonProgressbarTest( $refFile, $max, $step, $options )
    {
        $out = new ezcConsoleOutput();
        $bar = new ezcConsoleProgressbar( $out, $max, $options );
        if ( $step != 1 )
        {
            $bar->options->step = $step;
        }
        $res = array();
        for ( $i = 0; $i < $max; $i+= $step) 
        {
            ob_start();
            $bar->advance();
//            sleep( 1 );
            $resTmp = ob_get_contents();
            if (trim($resTmp) !== '')
            {
                $res[] = $resTmp;
            }
            ob_end_clean();
        }
        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/data/' . $refFile . '.dat' ),
            implode( "\n", $res ),
            'Table not correctly generated for ' . $refFile . '.'
        );
        // Use the following line to regenerate test reference files
        // file_put_contents( dirname( __FILE__ ) . '/data/' . $refFile . '.dat', implode( "\n", $res ) );
    }
}
?>
