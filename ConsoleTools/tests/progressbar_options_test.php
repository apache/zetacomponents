<?php
/**
 * ezcConsoleToolsProgressbarOptionsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleProgressbarOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsProgressbarOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcConsoleToolsProgressbarOptionsTest" );
	}
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleProgressbarOptions(
            array( 
                "barChar" => "+",
                "emptyChar" => "-",
                "formatString" => "%act% / %max% [%bar%] %fraction%%",
                "fractionFormat" => "%01.2f",
                "progressChar" => ">",
                "redrawFrequency" => 1,
                "step" => 1,
                "width" => 78,
                "actFormat" => "%.0f",
                "maxFormat" => "%.0f",
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleProgressbarOptions(),
            'Default values incorrect for ezcConsoleProgressbarOptions.'
        );
    }

    public function testNewAccess()
    {
        $opt = new ezcConsoleProgressbarOptions();
        $this->assertEquals( "+", $opt->barChar );
        $this->assertEquals( "-", $opt->emptyChar );
        $this->assertEquals( "%act% / %max% [%bar%] %fraction%%", $opt->formatString );
        $this->assertEquals( "%01.2f", $opt->fractionFormat );
        $this->assertEquals( ">", $opt->progressChar );
        $this->assertEquals( 1, $opt->redrawFrequency );
        $this->assertEquals( 1, $opt->step );
        $this->assertEquals( 78, $opt->width );
        $this->assertEquals( "%.0f", $opt->actFormat );
        $this->assertEquals( "%.0f", $opt->maxFormat );

        $this->assertEquals( $opt["barChar"], "+" );
        $this->assertEquals( $opt["emptyChar"], "-" );
        $this->assertEquals( $opt["formatString"], "%act% / %max% [%bar%] %fraction%%" );
        $this->assertEquals( $opt["fractionFormat"], "%01.2f" );
        $this->assertEquals( $opt["progressChar"], ">" );
        $this->assertEquals( $opt["redrawFrequency"], 1 );
        $this->assertEquals( $opt["step"], 1 );
        $this->assertEquals( $opt["width"], 78 );
        $this->assertEquals( $opt["actFormat"], "%.0f" );
        $this->assertEquals( $opt["maxFormat"], "%.0f" );
    }

}

?>
