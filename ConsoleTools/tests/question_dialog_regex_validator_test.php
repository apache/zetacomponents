<?php
/**
 * ezcConsoleQuestionDialogRegexValidatorTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleQuestionDialogRegexValidator class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleQuestionDialogRegexValidatorTest extends ezcTestCase
{
	public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcConsoleQuestionDialogRegexValidatorTest" );
    }

    public function testGetAccessDefaultSuccess()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );
        $this->assertEquals( "//", $validator->pattern );
        $this->assertNull( $validator->default );
    }

    public function testGetAccessCustomSuccess()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator(
            "/[0-9]+/",
            23
        );
        $this->assertEquals( "/[0-9]+/", $validator->pattern );
        $this->assertEquals( 23, $validator->default );
    }

    public function testGetAccessFailure()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );
        
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
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );

        $validator->pattern = "@^\s+$@";
        $validator->default = 23.42;

        $this->assertEquals( "@^\s+$@", $validator->pattern );
        $this->assertEquals( 23.42, $validator->default );
    }

    public function testSetAccessFailure()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );

        $exceptionCaught = false;
        try
        {
            $validator->pattern = "";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on invalid value for property type." );
        
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
            $validator->foo = "Foo";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionCaught = true;
        }
        $this->assertTrue( $exceptionCaught, "Exception not thrown on nonexistent property foo." );
    }

    public function testIssetAccess()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );
        $this->assertTrue( isset( $validator->pattern ), "Property pattern not set." );
        $this->assertTrue( isset( $validator->default ), "Property default not set." );

        $this->assertFalse( isset( $validator->foo ), "Property foo set." );
    }

    public function testValidate()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );

        $this->assertTrue( $validator->validate( "foo" ), "Value foo is invalid." );
        $this->assertTrue( $validator->validate( true ) );
        $this->assertTrue( $validator->validate( 23 ) );

        $validator->pattern = "/^[0-9]+\.[a-z]+$/";

        $this->assertTrue( $validator->validate( "123.abc" ), "Value 123.abc is invalid." );
        $this->assertFalse( $validator->validate( "abc" ) );
        $this->assertFalse( $validator->validate( 23 ) );
        
        $validator->default = "foo";

        $this->assertTrue( $validator->validate( "" ), "Empty value is invalid." );
    }

    public function testFixup()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );

        $this->assertEquals( "23", $validator->fixup( "23" ) );
        $this->assertEquals( "-23", $validator->fixup( "-23" ) );
        $this->assertEquals( "foo", $validator->fixup( "foo" ) );
        $this->assertEquals( "23.42", $validator->fixup( "23.42" ) );
        $this->assertEquals( "-23.42", $validator->fixup( "-23.42" ) );
        $this->assertEquals( "true", $validator->fixup( "true" ) );
        $this->assertEquals( "false", $validator->fixup( "false" ) );
        $this->assertEquals( "1", $validator->fixup( "1" ) );
        $this->assertEquals( "0", $validator->fixup( "0" ) );
        $this->assertEquals( "", $validator->fixup( "" ) );
        
        $validator->default = "foo";

        $this->assertEquals( "foo", $validator->fixup( "" ) );
    }

    public function testGetResultString()
    {
        $validator = new ezcConsoleQuestionDialogRegexValidator( "//" );

        $this->assertEquals( "(match //)", $validator->getResultString() );

        $validator->default = "foo";

        $this->assertEquals( "(match //) [foo]", $validator->getResultString() );

        $validator->pattern = "/^[0-9]+\.[a-z]+$/";
        $validator->default = null;

        $this->assertEquals( "(match /^[0-9]+\.[a-z]+$/)", $validator->getResultString() );

        $validator->default = "foo";
        
        $this->assertEquals( "(match /^[0-9]+\.[a-z]+$/) [foo]", $validator->getResultString() );
    }
}

?>
