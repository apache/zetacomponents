<?php
/**
 * ezcConsoleStatusbarOptionsTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleStatusbarOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleStatusbarOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleStatusbarOptionsTest" );
	}
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleStatusbarOptions(
            array( 
                "successChar" => "+",
                "failureChar" => "-",
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleStatusbarOptions(),
            'Default values incorrect for ezcConsoleStatusbarOptions.'
        );
    }

    public function testNewAccess()
    {
        $opt = new ezcConsoleStatusbarOptions();
        $this->assertEquals( "+", $opt->successChar );
        $this->assertEquals( "-", $opt->failureChar );

        $this->assertEquals( $opt["successChar"], "+" );
        $this->assertEquals( $opt["failureChar"], "-" );
    }

    public function testGetAccessSuccess()
    {
        $opt = new ezcConsoleStatusbarOptions();
        $this->assertEquals( "+", $opt->successChar );
        $this->assertEquals( "-", $opt->failureChar );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcConsoleStatusbarOptions();

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
        $opt = new ezcConsoleStatusbarOptions();
        $opt->successChar = "1";
        $opt->failureChar = "0";

        $this->assertEquals( "1", $opt->successChar );
        $this->assertEquals( "0", $opt->failureChar );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcConsoleStatusbarOptions();

        $exceptionThrown = false;
        try
        {
            $opt->successChar = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property successChar." );

        $exceptionThrown = false;
        try
        {
            $opt->failureChar = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "Exception not thrown on invalid value for property failureChar." );

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
        $opt = new ezcConsoleStatusbarOptions();
        $this->assertTrue( isset( $opt->successChar ) );
        $this->assertTrue( isset( $opt->failureChar ) );
        $this->assertFalse( isset( $opt->foo ) );
    }
}

?>
