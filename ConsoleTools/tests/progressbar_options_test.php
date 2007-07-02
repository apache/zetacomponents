<?php
/**
 * ezcConsoleProgressbarOptionsTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleProgressbarOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleProgressbarOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleProgressbarOptionsTest" );
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

    public function testGetAccessSuccess()
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
        $this->assertEquals( '%.0f', $opt->actFormat );
        $this->assertEquals( '%.0f', $opt->maxFormat );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcConsoleProgressbarOptions();

        $exceptionThrown = false;
        try
        {
            echo $opt->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on get access of invalid property foo." );
    }

    public function testSetAccessSuccess()
    {
        $opt = new ezcConsoleProgressbarOptions();
        $opt->barChar = "*";
        $opt->emptyChar = "_";
        $opt->formatString = " %fraction%% %act% - %max% (%bar%)";
        $opt->fractionFormat = "%01.1f";
        $opt->progressChar = "]";
        $opt->redrawFrequency = 5;
        $opt->step = 5;
        $opt->width = 42;
        $opt->actFormat = '%.10f';
        $opt->maxFormat = '%.10f';

        $this->assertEquals( "*", $opt->barChar );
        $this->assertEquals( "_", $opt->emptyChar );
        $this->assertEquals( " %fraction%% %act% - %max% (%bar%)", $opt->formatString );
        $this->assertEquals( "%01.1f", $opt->fractionFormat );
        $this->assertEquals( "]", $opt->progressChar );
        $this->assertEquals( 5, $opt->redrawFrequency );
        $this->assertEquals( 5, $opt->step );
        $this->assertEquals( 42, $opt->width );
        $this->assertEquals( '%.10f', $opt->actFormat );
        $this->assertEquals( '%.10f', $opt->maxFormat );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcConsoleProgressbarOptions();

        $exceptionThrown = false;
        try
        {
            $opt->fractionFormat = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property fractionFormat." );

        $exceptionThrown = false;
        try
        {
            $opt->progressChar = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property progressChar." );

        $exceptionThrown = false;
        try
        {
            $opt->redrawFrequency = "foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property redrawFrequency." );

        $exceptionThrown = false;
        try
        {
            $opt->step = "foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property step." );

        $exceptionThrown = false;
        try
        {
            $opt->width = "foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property width." );

        $exceptionThrown = false;
        try
        {
            $opt->actFormat = 23;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property actFormat." );

        $exceptionThrown = false;
        try
        {
            $opt->maxFormat = 23;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property maxFormat." );

        $exceptionThrown = false;
        try
        {
            $opt->barChar = 23;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property barChar." );

        $exceptionThrown = false;
        try
        {
            $opt->emptyChar = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property emptyChar." );

        $exceptionThrown = false;
        try
        {
            $opt->formatString = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property formatString." );

        $exceptionThrown = false;
        try
        {
            $opt->foo = true;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on set access of invalid property foo." );
    }

    public function testIsset()
    {
        $opt = new ezcConsoleProgressbarOptions();
        $this->assertTrue( isset( $opt->barChar ) );
        $this->assertTrue( isset( $opt->emptyChar ) );
        $this->assertTrue( isset( $opt->formatString ) );
        $this->assertTrue( isset( $opt->fractionFormat ) );
        $this->assertTrue( isset( $opt->progressChar ) );
        $this->assertTrue( isset( $opt->redrawFrequency ) );
        $this->assertTrue( isset( $opt->step ) );
        $this->assertTrue( isset( $opt->width ) );
        $this->assertTrue( isset( $opt->actFormat ) );
        $this->assertTrue( isset( $opt->maxFormat ) );
        $this->assertFalse( isset( $opt->foo ) );
    }
}

?>
