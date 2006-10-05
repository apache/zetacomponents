<?php
/**
 * ezcConsoleToolsTableOptionsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleTableOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsTableOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleToolsTableOptionsTest" );
	}

    /**
     * testConstructor
     * 
     * @access public
     */
    public function testConstructor()
    {
        $fake = new ezcConsoleTableOptions( 
            "auto",
            ezcConsoleTable::WRAP_AUTO,
            ezcConsoleTable::ALIGN_LEFT,
            " ",
            ezcConsoleTable::WIDTH_MAX,
            "-",
            "|",
            "+",
            "default",
            "default"
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleTableOptions(),
            'Default values incorrect for ezcConsoleTableOptions.'
        );
    }
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleTableOptions( 
            array(
                "colWidth" => "auto",
                "colWrap" => ezcConsoleTable::WRAP_AUTO,
                "defaultAlign" => ezcConsoleTable::ALIGN_LEFT,
                "colPadding" => " ",
                "widthType" => ezcConsoleTable::WIDTH_MAX,
                "lineVertical" => "-",
                "lineHorizontal" => "|",
                "corner" => "+",
                "defaultFormat" => "default",
                "defaultBorderFormat" => "default"
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleTableOptions(),
            'Default values incorrect for ezcConsoleTableOptions.'
        );
    }

    public function testCompatibility()
    {
        $old = new ezcConsoleTableOptions( 
            array( 10, 20, 10 ),
            ezcConsoleTable::WRAP_CUT,
            ezcConsoleTable::ALIGN_CENTER,
            "-",
            ezcConsoleTable::WIDTH_FIXED,
            "_",
            "I",
            "x",
            "red",
            "blue"
        );
        $new = new ezcConsoleTableOptions( 
            array(
                "colWidth" => array( 10, 20, 10 ),
                "colWrap" => ezcConsoleTable::WRAP_CUT,
                "defaultAlign" => ezcConsoleTable::ALIGN_CENTER,
                "colPadding" => "-",
                "widthType" => ezcConsoleTable::WIDTH_FIXED,
                "lineVertical" => "_",
                "lineHorizontal" => "I",
                "corner" => "x",
                "defaultFormat" => "red",
                "defaultBorderFormat" => "blue"
            )
        );
        $this->assertEquals( $old, $new, "Old construction method did not produce same result as old one." );
    }

    public function testAccess()
    {
        $opt = new ezcConsoleTableOptions();

        $this->assertEquals( $opt->colWidth, "auto" );
        $this->assertEquals( $opt->colWrap, ezcConsoleTable::WRAP_AUTO );
        $this->assertEquals( $opt->defaultAlign, ezcConsoleTable::ALIGN_LEFT );
        $this->assertEquals( $opt->colPadding, " " );
        $this->assertEquals( $opt->widthType, ezcConsoleTable::WIDTH_MAX );
        $this->assertEquals( $opt->lineVertical, "-" );
        $this->assertEquals( $opt->lineHorizontal, "|" );
        $this->assertEquals( $opt->corner, "+" );
        $this->assertEquals( $opt->defaultFormat, "default" );
        $this->assertEquals( $opt->defaultBorderFormat, "default" );

        $this->assertEquals( $opt["colWidth"], "auto" );
        $this->assertEquals( $opt["colWrap"], ezcConsoleTable::WRAP_AUTO );
        $this->assertEquals( $opt["defaultAlign"], ezcConsoleTable::ALIGN_LEFT );
        $this->assertEquals( $opt["colPadding"], " " );
        $this->assertEquals( $opt["widthType"], ezcConsoleTable::WIDTH_MAX );
        $this->assertEquals( $opt["lineVertical"], "-" );
        $this->assertEquals( $opt["lineHorizontal"], "|" );
        $this->assertEquals( $opt["corner"], "+" );
        $this->assertEquals( $opt["defaultFormat"], "default" );
        $this->assertEquals( $opt["defaultBorderFormat"], "default" );
    }

    public function testConstructorFirstParameter()
    {
        $colWidthArray = new ezcConsoleTableOptions(
            array( 1, 2, 3 )
        );

        $optionsArray = new ezcConsoleTableOptions(
            array(
                "colWidth" => array( 1, 2, 3 ),
            )
        );

        $this->assertEquals( $colWidthArray, $optionsArray, "Did not detect options array correctly." );
    }

    public function testTableConstructorCompatibility()
    {
        $out = new ezcConsoleOutput();
        $old = new ezcConsoleTable(
            $out,
            100,
            new ezcConsoleTableOptions(
                array( 1, 2, 3 )
            )
        );
        $new = new ezcConsoleTable(
            $out,
            100,
            array(
                "colWidth" => array( 1, 2, 3 ),
            )
        );
        $this->assertEquals( $old, $new, "Constructor calls did not produce same table objects." );
    }

}

?>
