<?php
/**
 * ezcConsoleOutputFormatTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutputFormat struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleOutputFormatTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleOutputFormatTest" );
	}

    public function testConstructor()
    {
        $fake = new ezcConsoleOutputFormat(
            'default',
            array( 'default' ),
            'default',
            ezcConsoleOutput::TARGET_OUTPUT
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleOutputFormat(),
            'Default values incorrect for ezcConsoleOutputFormat.'
        );
    }

    public function testGetAccessSuccess()
    {
        $format = new ezcConsoleOutputFormat( 'blue',
            array( 'bold' ),
            'red',
            ezcConsoleOutput::TARGET_STDERR
        );

        $this->assertEquals( "blue", $format->color );
        $this->assertEquals( array( "bold" ), $format->style );
        $this->assertEquals( "red", $format->bgcolor );
        $this->assertEquals( "php://stderr", $format->target );
    }

    public function testGetAccessFailure()
    {
        $format = new ezcConsoleOutputFormat();

        try
        {
            $foo = $format->nonExsitent;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }
        $this->fail( "Exception not thrown on access of not existing property on ezcConsoleFormat." );
    }

    public function testSetAccessSuccess()
    {
        $format = new ezcConsoleOutputFormat();

        $format->color = "blue";
        $format->style = array( "bold" );
        $format->bgcolor = "red";
        $format->target = ezcConsoleOutput::TARGET_STDERR;

        $this->assertEquals( "blue", $format->color );
        $this->assertEquals( array( "bold" ), $format->style );
        $this->assertEquals( "red", $format->bgcolor );
        $this->assertEquals( "php://stderr", $format->target );
        
        // Style can also be scalar
        $format->style = "bold";
        $this->assertEquals( array( "bold" ), $format->style );
    }

    public function testSetAccessFailureColor()
    {
        $format = new ezcConsoleOutputFormat();

        try
        {
            $format->color = "nonExistent";
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }
        $this->fail( "Exception not thrown on set of not existing color on ezcConsoleFormat->color." );
    }

    public function testSetAccessFailureStyleArray()
    {
        $format = new ezcConsoleOutputFormat();

        try
        {
            $format->style = array( "nonExistent" );
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }
        $this->fail( "Exception not thrown on set of not existing format code as array on ezcConsoleFormat->style." );
    }

    public function testSetAccessFailureStyleScalar()
    {
        $format = new ezcConsoleOutputFormat();

        try
        {
            $format->style = "nonExistent";
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }
        $this->fail( "Exception not thrown on set of not existing format code as scalar on ezcConsoleFormat->style." );
    }

    public function testSetAccessFailureBgcolor()
    {
        $format = new ezcConsoleOutputFormat();

        try
        {
            $format->bgcolor = "nonExistent";
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }
        $this->fail( "Exception not thrown on set of not existing color on ezcConsoleFormat->bgcolor." );
    }
    
    public function testSetAccessFailureNonexistent()
    {
        $format = new ezcConsoleOutputFormat();

        try
        {
            $format->nonExsitent = "nonExistent";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }
        $this->fail( "Exception not thrown on set of not existing color on ezcConsoleFormat->bgcolor." );
    }

    public function testIssetAccessSuccess()
    {
        $format = new ezcConsoleOutputFormat();

        $this->assertTrue( isset( $format->color ) );
        $this->assertTrue( isset( $format->style ) );
        $this->assertTrue( isset( $format->bgcolor ) );
    }
    
    public function testIssetAccessFailure()
    {
        $format = new ezcConsoleOutputFormat();

        $this->assertFalse( isset( $format->nonExistent ) );
    }
}

?>
