<?php
/**
 * ezcConsoleTableCellTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleTableCell class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleTableCellTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleTableCellTest" );
	}

    public function testConstructorSuccessDefault()
    {
        $cell = new ezcConsoleTableCell();
        $this->assertEquals( $cell->content, "" );
        $this->assertEquals( $cell->format, "default" );
        $this->assertEquals( $cell->align, ezcConsoleTable::ALIGN_DEFAULT );
    }
    
    public function testConstructorSuccessNonDefault()
    {
        $cell = new ezcConsoleTableCell( 'test', 'success', ezcConsoleTable::ALIGN_RIGHT );
        $this->assertEquals(
            "test",
             $cell->content
        );
        $this->assertEquals(
            "success",
            $cell->format
        );
        $this->assertEquals(
            ezcConsoleTable::ALIGN_RIGHT,
            $cell->align
        );
    }
    
    public function testConstructorFailure()
    {
        try
        {
            $cell = new ezcConsoleTableCell( 'test', 'success', 42 );
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid align value." );
    }

    public function testGetAccessSuccess()
    {
        $cell = new ezcConsoleTableCell();
        $this->assertEquals( $cell->content, "" );
        $this->assertEquals( $cell->format, "default" );
        $this->assertEquals( $cell->align, ezcConsoleTable::ALIGN_DEFAULT );
    }

    public function testGetAccessFailure()
    {
        $cell = new ezcConsoleTableCell();

        try
        {
            echo $cell->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on get access of invalid property foo." );
    }

    public function testSetAccessSuccess()
    {
        $cell = new ezcConsoleTableCell();
        $cell->content = "aaa";
        $cell->format = "bbb";
        $cell->align = ezcConsoleTable::ALIGN_RIGHT;

        $this->assertEquals( $cell->content, "aaa" );
        $this->assertEquals( $cell->format, "bbb" );
        $this->assertEquals( $cell->align, ezcConsoleTable::ALIGN_RIGHT );
    }

    public function testSetAccessFailure()
    {
        $cell = new ezcConsoleTableCell();

        $exceptionThrown = false;
        try
        {
            $cell->content = 23;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "No exception thrown on invalid value for ezcConsoleTableCell->content." );

        $exceptionThrown = false;
        try
        {
            $cell->format = 23;
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "No exception thrown on invalid value for ezcConsoleTableCell->format." );

        $exceptionThrown = false;
        try
        {
            $cell->align = "nonExistent";
        }
        catch ( ezcBaseValueException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "No exception thrown on invalid value for ezcConsoleTableCell->align." );

        $exceptionThrown = false;
        try
        {
            $cell->foo = "nonExistent";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $exceptionThrown = true;
        }
        $this->assertTrue( $exceptionThrown, "No exception thrown on set access of invalid property ezcConsoleTableCell->foo." );
    }

    public function testIssetAccess()
    {
        $cell = new ezcConsoleTableCell();
        $this->assertTrue( isset( $cell->content ) );
        $this->assertTrue( isset( $cell->format ) );
        $this->assertTrue( isset( $cell->align ) );
        $this->assertFalse( isset( $cell->foo ) );
    }
}
?>
