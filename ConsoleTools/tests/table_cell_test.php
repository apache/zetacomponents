<?php
/**
 * ezcConsoleTableCellTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

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
        try
        {
            $cell->align = "nonExistent";
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "No exception thrown on invalid value for ezcConsoleTableCell->align." );
    }
    
}
?>
