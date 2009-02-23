<?php
/**
 * ezcConsoleOutputOptionsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutputOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleOutputOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleOutputOptionsTest" );
	}

    /**
     * testConstructor
     * 
     * @access public
     */
    public function testConstructor()
    {
        $fake = new ezcConsoleOutputOptions( 1, 0, true );
        $this->assertEquals( 
            $fake,
            new ezcConsoleOutputOptions(),
            'Default values incorrect for ezcConsoleOutputOptions.'
        );
    }
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleOutputOptions(
            array( 
                "verbosityLevel" => 1,
                "autobreak" => 0,
                "useFormats" => true,
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleOutputOptions(),
            'Default values incorrect for ezcConsoleOutputOptions.'
        );
    }

    public function testCompatibility()
    {
        $old = new ezcConsoleOutputOptions( 5, 80 );
        $new = new ezcConsoleOutputOptions(
            array( 
                "verbosityLevel"    => 5,
                "autobreak"         => 80,
            )
        );
        $this->assertEquals( $old, $new, "Old construction method did not produce same result as old one." );
    }

    public function testNewAccess()
    {
        $opt = new ezcConsoleOutputOptions();
        $this->assertEquals( $opt->verbosityLevel, 1 );
        $this->assertEquals( $opt->autobreak, 0 );
        $this->assertEquals( $opt->useFormats, true );
        $this->assertEquals( $opt["verbosityLevel"], 1 );
        $this->assertEquals( $opt["autobreak"], 0 );
        $this->assertEquals( $opt["useFormats"], true );
    }

    public function testGetAccessSuccess()
    {
        $opt = new ezcConsoleOutputOptions();
        $this->assertEquals( 1, $opt->verbosityLevel );
        $this->assertEquals( 0, $opt->autobreak );
        $this->assertEquals( true, $opt->useFormats );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcConsoleOutputOptions();

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
        $opt = new ezcConsoleOutputOptions();
        $opt->verbosityLevel = 10;
        $opt->autobreak = 80;
        $opt->useFormats = false;

        $this->assertEquals( 10, $opt->verbosityLevel );
        $this->assertEquals( 80, $opt->autobreak );
        $this->assertEquals( false, $opt->useFormats );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcConsoleOutputOptions();

        $exceptionThrown = false;
        try
        {
            $opt->verbosityLevel = -1;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property verbosityLevel." );

        $exceptionThrown = false;
        try
        {
            $opt->autobreak = -1;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property autobreak." );

        $exceptionThrown = false;
        try
        {
            $opt->useFormats = "foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property useFormats." );

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
        $opt = new ezcConsoleOutputOptions();
        $this->assertTrue( isset( $opt->verbosityLevel ) );
        $this->assertTrue( isset( $opt->autobreak ) );
        $this->assertTrue( isset( $opt->useFormats ) );
        $this->assertFalse( isset( $opt->foo ) );
    }

}

?>
