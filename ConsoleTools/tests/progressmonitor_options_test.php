<?php
/**
 * ezcConsoleProgressMonitorOptionsTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleProgressMonitorOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleProgressMonitorOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleProgressMonitorOptionsTest" );
	}
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleProgressMonitorOptions(
            array( 
                "formatString" => "%8.1f%% %s %s",
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleProgressMonitorOptions(),
            'Default values incorrect for ezcConsoleProgressMonitorOptions.'
        );
    }

    public function testNewAccess()
    {
        $opt = new ezcConsoleProgressMonitorOptions();

        $this->assertEquals( $opt["formatString"], "%8.1f%% %s %s" );
    }

    public function testGetAccessSuccess()
    {
        $opt = new ezcConsoleProgressMonitorOptions();
        $this->assertEquals( "%8.1f%% %s %s", $opt->formatString );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcConsoleProgressMonitorOptions();

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
        $opt = new ezcConsoleProgressMonitorOptions();
        $opt->formatString = "foo %s";

        $this->assertEquals( "foo %s", $opt->formatString );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcConsoleProgressMonitorOptions();

        $exceptionThrown = false;
        try
        {
            $opt->formatString = "";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property formatString." );

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
        $opt = new ezcConsoleProgressMonitorOptions();
        $this->assertTrue( isset( $opt->formatString ) );
        $this->assertFalse( isset( $opt->foo ) );
    }
}

?>
