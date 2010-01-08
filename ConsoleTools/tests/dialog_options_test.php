<?php
/**
 * ezcConsoleDialogOptionsTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleDialogOptions class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleDialogOptionsTest extends ezcTestCase
{
	public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcConsoleDialogOptionsTest" );
    }

    public function testGetAccessDefaultSuccess()
    {
        $opts = new ezcConsoleDialogOptions();
        $this->assertNull( $opts->validator );
        $this->assertEquals( "default", $opts->format );
    }

    public function testGetAccessCustomSuccess()
    {
        $opts = new ezcConsoleDialogOptions(
            array(
                "validator"         => new ezcConsoleQuestionDialogCollectionValidator( array( "a", "b" ) ),
                "format"            => "test",
            )
        );
        $this->assertType( "ezcConsoleQuestionDialogCollectionValidator", $opts->validator );
        $this->assertEquals( "test", $opts->format );
    }

    public function testGetAccessFailure()
    {
        $opts = new ezcConsoleDialogOptions();
        
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
        $opts = new ezcConsoleDialogOptions();
        $opts->validator   = new ezcConsoleQuestionDialogCollectionValidator( array( "a", "b" ) );
        $opts->format      = "test";
        
        $this->assertType( "ezcConsoleQuestionDialogCollectionValidator", $opts->validator );
        $this->assertEquals( "test", $opts->format );
    }

    public function testSetAccessFailure()
    {
        $opts = new ezcConsoleDialogOptions();
        
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
        $opts = new ezcConsoleDialogOptions();
        $this->assertTrue( isset( $opts->validator ), "Property validator not set." );
        $this->assertTrue( isset( $opts->format ), "Property format not set." );

        $this->assertFalse( isset( $opts->foo ), "Property foo set." );
    }
}

?>
