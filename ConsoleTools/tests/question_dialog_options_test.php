<?php
/**
 * ezcConsoleQuestionDialogOptionsTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleQuestionDialogOptions class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleQuestionDialogOptionsTest extends ezcTestCase
{
	public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcConsoleQuestionDialogOptionsTest" );
    }

    public function testGetAccessDefaultSuccess()
    {
        $opts = new ezcConsoleQuestionDialogOptions();
        $this->assertEquals( "Please enter a value: ", $opts->text );
        $this->assertType( "ezcConsoleQuestionDialogTypeValidator", $opts->validator );
        $this->assertFalse( $opts->showResults );
        $this->assertEquals( "default", $opts->format );
    }

    public function testGetAccessCustomSuccess()
    {
        $opts = new ezcConsoleQuestionDialogOptions(
            array(
                "text"              => "Do you have a question?",
                "validator"         => new ezcConsoleQuestionDialogCollectionValidator( array( "a", "b" ) ),
                "showResults"    => true,
                "format"            => "test",
            )
        );
        $this->assertEquals( "Do you have a question?", $opts->text );
        $this->assertType( "ezcConsoleQuestionDialogCollectionValidator", $opts->validator );
        $this->assertTrue( $opts->showResults );
        $this->assertEquals( "test", $opts->format );
    }

    public function testGetAccessFailure()
    {
        $opts = new ezcConsoleQuestionDialogOptions();
        
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
        $opts = new ezcConsoleQuestionDialogOptions();
        $opts->text        = "Do you have a question?";
        $opts->validator   = new ezcConsoleQuestionDialogCollectionValidator( array( "a", "b" ) );
        $opts->showResults = true;
        $opts->format      = "test";
        
        $this->assertEquals( "Do you have a question?", $opts->text );
        $this->assertType( "ezcConsoleQuestionDialogCollectionValidator", $opts->validator );
        $this->assertTrue( $opts->showResults );
        $this->assertEquals( "test", $opts->format );
    }

    public function testSetAccessFailure()
    {
        $opts = new ezcConsoleQuestionDialogOptions();
        
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
            $opts->showResults = "Foo";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property showResults." );

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
        $opts = new ezcConsoleQuestionDialogOptions();
        $this->assertTrue( isset( $opts->text ), "Property text not set." );
        $this->assertTrue( isset( $opts->validator ), "Property validator not set." );
        $this->assertTrue( isset( $opts->showResults ), "Property showResults not set." );
        $this->assertTrue( isset( $opts->format ), "Property format not set." );

        $this->assertFalse( isset( $opts->foo ), "Property foo set." );
    }
}

?>
