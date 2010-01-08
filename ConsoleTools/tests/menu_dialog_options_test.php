<?php
/**
 * ezcConsoleMenuDialogOptionsTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleMenuDialogOptions class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleMenuDialogOptionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcConsoleMenuDialogOptionsTest" );
    }

    public function testGetAccessDefaultSuccess()
    {
        $opts = new ezcConsoleMenuDialogOptions();
        $this->assertEquals( "Please choose an item.", $opts->text );
        $this->assertEquals( "%3s) %s\n", $opts->formatString );
        $this->assertEquals( "Select: ", $opts->selectText );
        $this->assertType( "ezcConsoleMenuDialogDefaultValidator", $opts->validator );
        $this->assertEquals( "default", $opts->format );
    }

    public function testGetAccessCustomSuccess()
    {
        $menuElements = array(
            "F" => "Foo",
            "B" => "Bar",
        );
        $opts = new ezcConsoleMenuDialogOptions(
            array(
                "text"              => "Please select a fitting mode:\n",
                "validator"         => new ezcConsoleMenuDialogDefaultValidator(
                    $menuElements
                ),
                "selectText"        => "Select a mode: ",
                "formatString"      => "%10s] %s\n",
                "format"            => "test",
            )
        );
        $this->assertEquals( "Please select a fitting mode:\n", $opts->text );
        $this->assertEquals( "%10s] %s\n", $opts->formatString );
        $this->assertType( "ezcConsoleMenuDialogDefaultValidator", $opts->validator );
        $this->assertEquals( $menuElements, $opts->validator->elements );
        $this->assertEquals( "Select a mode: ", $opts->selectText );
        $this->assertEquals( "test", $opts->format );
    }

    public function testGetAccessFailure()
    {
        $opts = new ezcConsoleMenuDialogOptions();
        
        try
        {
            echo $opts->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid property foo." );
    }

    public function testSetAccessSuccess()
    {
        $menuElements = array(
            "F" => "Foo",
            "B" => "Bar",
        );
        $opts = new ezcConsoleMenuDialogOptions();
        $opts->text         = "Please select a fitting mode:\n";
        $opts->validator    = new ezcConsoleMenuDialogDefaultValidator( $menuElements );
        $opts->selectText   = "Select a mode: ";
        $opts->formatString = "%10s] %s\n";
        $opts->format       = "test";
        
        $this->assertEquals( "Please select a fitting mode:\n", $opts->text );
        $this->assertEquals( "%10s] %s\n", $opts->formatString );
        $this->assertType( "ezcConsoleMenuDialogDefaultValidator", $opts->validator );
        $this->assertEquals( $menuElements, $opts->validator->elements );
        $this->assertEquals( "Select a mode: ", $opts->selectText );
        $this->assertEquals( "test", $opts->format );
    }

    public function testSetAccessFailure()
    {
        $opts = new ezcConsoleMenuDialogOptions();
        
        $exceptionCaught = false;
        try
        {
            $opts->text = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property text." );

        $exceptionCaught = false;
        try
        {
            $opts->validator = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property validator." );

        $exceptionCaught = false;
        try
        {
            $opts->selectText = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property selectText." );

        $exceptionCaught = false;
        try
        {
            $opts->formatString = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property formatString." );

        $exceptionCaught = false;
        try
        {
            $opts->format = true;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property format." );

        $exceptionCaught = false;
        try
        {
            $opts->foo = "Foo";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on access of nonexistent property foo." );
    }

    public function testIssetAccess()
    {
        $opts = new ezcConsoleMenuDialogOptions();
        $this->assertTrue( isset( $opts->text ), "Property text not set." );
        $this->assertTrue( isset( $opts->validator ), "Property validator not set." );
        $this->assertTrue( isset( $opts->selectText ), "Property selectText not set." );
        $this->assertTrue( isset( $opts->formatString ), "Property formatString not set." );
        $this->assertTrue( isset( $opts->format ), "Property format not set." );

        $this->assertFalse( isset( $opts->foo ), "Property foo set." );
    }
}

?>
