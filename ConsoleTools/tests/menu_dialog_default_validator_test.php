<?php
/**
 * ezcConsoleMenuDialogDefaultValidatorTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleMenuDialogDefaultValidator class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleMenuDialogDefaultValidatorTest extends ezcTestCase
{
	public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcConsoleMenuDialogDefaultValidatorTest" );
    }

    public function testGetAccessDefaultSuccess()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements );
        $this->assertEquals( $elements, $validator->elements );
        $this->assertNull( $validator->default );
        $this->assertEquals( ezcConsoleMenuDialogDefaultValidator::CONVERT_NONE, $validator->conversion );
    }

    public function testGetAccessCustomSuccess()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator(
            $elements,
            "F",
            ezcConsoleMenuDialogDefaultValidator::CONVERT_UPPER
        );
        $this->assertEquals( $elements, $validator->elements );
        $this->assertEquals( "F", $validator->default );
        $this->assertEquals( ezcConsoleMenuDialogDefaultValidator::CONVERT_UPPER, $validator->conversion );
    }

    public function testGetAccessFailure()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements );
        
        try
        {
            echo $validator->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid property foo." );
    }

    public function testSetAccessSuccess()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements );

        $elementsNew = array( 23, 42 );
        $validator->elements = $elementsNew;
        $validator->default = 23;
        $validator->conversion = ezcConsoleMenuDialogDefaultValidator::CONVERT_LOWER;

        $this->assertEquals( $elementsNew, $validator->elements );
        $this->assertEquals( 23, $validator->default );
        $this->assertEquals( ezcConsoleMenuDialogDefaultValidator::CONVERT_LOWER, $validator->conversion );
    }

    public function testSetAccessFailure()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements );
        
        $exceptionCaught = false;
        try
        {
            $validator->elements = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property elements." );

        $exceptionCaught = false;
        try
        {
            $validator->default = array();
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property default." );

        $exceptionCaught = false;
        try
        {
            $validator->conversion = "Foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property conversion." );

        $exceptionCaught = false;
        try
        {
            $validator->foo = "Foo";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on access of nonexistent property foo." );
    }

    public function testIssetAccess()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements );
        $this->assertTrue( isset( $validator->elements ), "Property elements not set." );
        $this->assertTrue( isset( $validator->default ), "Property default not set." );
        $this->assertTrue( isset( $validator->conversion ), "Property conversion not set." );

        $this->assertFalse( isset( $validator->foo ), "Property foo set." );
    }

    public function testValidate()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements );
        $this->assertTrue( $validator->validate( "F" ) );
        $this->assertFalse( $validator->validate( "test" ) );
    }

    public function testFixup()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements, null );

        $this->assertEquals( "F", $validator->fixup( "F" ) );
        $this->assertEquals( "f", $validator->fixup( "f" ) );

        $validator->conversion = ezcConsoleMenuDialogDefaultValidator::CONVERT_UPPER;
        
        $this->assertEquals( "F", $validator->fixup( "F" ) );
        $this->assertEquals( "F", $validator->fixup( "f" ) );

        $validator->conversion = ezcConsoleMenuDialogDefaultValidator::CONVERT_LOWER;
        
        $this->assertEquals( "f", $validator->fixup( "F" ) );
        $this->assertEquals( "f", $validator->fixup( "f" ) );

        $this->assertEquals( "", $validator->fixup( "" ) );

        $validator->default = "F";

        $this->assertEquals( "F", $validator->fixup( "" ) );
    }

    public function testGetResultString()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements, null );

        $this->assertEquals( "", $validator->getResultString() );

        $validator->default = "F";

        $this->assertEquals( "[F]", $validator->getResultString() );
    }

    public function testGetElements()
    {
        $elements = array( "F" => "Foo", "B" => "Bar", "Z" => "Baz" );
        $validator = new ezcConsoleMenuDialogDefaultValidator( $elements, null );
        
        $this->assertEquals( $elements, $validator->getElements() );
    }
}

?>
