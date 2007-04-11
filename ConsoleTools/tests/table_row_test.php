<?php
/**
 * ezcConsoleToolsTableRowTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * Test suite for ezcConsoleTableRow class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsTableRowTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleToolsTableRowTest" );
	}

    public function testCtorSuccess_1()
    {
        $row = new ezcConsoleTableRow( new ezcConsoleTableCell(), new ezcConsoleTableCell() );
        $this->assertEquals( 
            2,
            count( $row ),
            "ezcConsoleTableRow not correctly created."
        );
    }
    
    public function testCtorSuccess_2()
    {
        $row = new ezcConsoleTableRow();
        $this->assertEquals( 
            0,
            count( $row ),
            "ezcConsoleTableRow not correctly created."
        );
    }
    
    public function testCtorFailure()
    {
        /*
         *  // Unneccessary, typehint!
         * 
        $row = new ezcConsoleTableRow( 'foo' );
        $this->assertEquals( 
            0,
            count( $row ),
            "ezcConsoleTableRow not correctly created."
        );
        */
    }
    
    public function testAppend()
    {
        $row = new ezcConsoleTableRow();
        $row[]->content = 'foo';
        $this->assertTrue( 
            $row[0] instanceof ezcConsoleTableCell,
            "ezcConsoleTableCell not correctly created on write access."
        );
    }
    
    public function testOntheflyCreationRead_1()
    {
        $row = new ezcConsoleTableRow();
        $this->assertTrue( 
            $row[0] instanceof ezcConsoleTableCell,
            "ezcConsoleTableCell not correctly created on write access."
        );
    }
    
    public function testOntheflyCreationRead_2()
    {
        $row = new ezcConsoleTableRow();
        $row[0]; $row[1]; $row[2];
        $this->assertTrue( 
            count( $row ) == 3,
            "ezcConsoleTableCell not correctly created on write access."
        );
    }

    public function testOntheflyCreationRead_3()
    {
        $row = new ezcConsoleTableRow();
        $row[0]->content = 'test';
        $row[1]->format = 'test';
        $row[2]->align = ezcConsoleTable::ALIGN_CENTER;
        $this->assertTrue( 
            count($row) == 3,
            "ezcConsoleTableCell not correctly created on write access."
        );
    }

    public function testOntheflyCreationWrite_1()
    {
        $row = new ezcConsoleTableRow();
        $row[0] = new ezcConsoleTableCell();
        $row[0]->content = 'test';
        $this->assertTrue( 
            count($row) == 1 && $row[0] instanceof ezcConsoleTableCell && $row[0]->content === 'test',
            "ezcConsoleTableCell not correctly created on write access."
        );
    }
    
    public function testNoOntheflyCreationIsset()
    {
        $row = new ezcConsoleTableRow();
        $this->assertEquals( 
            isset( $row[0] ),
            false,
            "ezcConsoleTableCell created on isset access."
        );
        $this->assertEquals( 
            count($row),
            0,
            "ezcConsoleTableCell created on isset access."
        );
    } 

    public function testForeach_1()
    {
        $row = new ezcConsoleTableRow();
        for ( $i = 0; $i < 10; $i++ )
        {
            $row[$i]->content = 'Is '.$i;
        }
        $this->assertEquals( 
            count( $row ),
            10,
            "ezcConsoleTableCells not correctly created on write access."
        );
        foreach ( $row as $id => $cell )
        {
            $this->assertEquals( 
                'Is ' . $id,
                $cell->content,
                "Cell with wrong content found on iteration."
            );
        }
    }

    public function testForeach_2()
    {
        $row = new ezcConsoleTableRow();
        for ( $i = 0; $i < 20; $i += 2 )
        {
            $row[$i]->content = 'Is '.$i;
        }
        $this->assertEquals( 
            count( $row ),
            19,
            "ezcConsoleTableCells."
        );
        foreach ( $row as $id => $cell );
        {
            $this->assertEquals( 
                'Is ' . $id,
                $cell->content,
                "Cell with wrong content found on iteration."
            );
        }
    }

    public function testCount_1()
    {
        $row = new ezcConsoleTableRow();
        $row[0]->content = 0;
        $this->assertEquals( 
            1,
            count( $row ),
            "Did not count number of cells correctly"
        );
    }

    public function testCount_2()
    {
        $row = new ezcConsoleTableRow();
        $row[1]->content = 0;
        $this->assertEquals( 
            2,
            count( $row ),
            "Did not count number of cells correctly"
        );
    }

    public function testCount_3()
    {
        $row = new ezcConsoleTableRow();
        $row[10]->content = 0;
        $this->assertEquals( 
            11,
            count( $row ),
            "Did not count number of cells correctly"
        );
    }

    public function testNotSetAllCellsProperties_1()
    {
        $row = new ezcConsoleTableRow();
        for ( $i = 0; $i < 10; $i++ )
        {
            $row[$i]->content = $i;
        }
        
        $row->align = ezcConsoleTable::ALIGN_CENTER;
        
        foreach ( $row as $cell )
        {
            $this->assertEquals( 
                ezcConsoleTable::ALIGN_DEFAULT,
                $cell->align,
                "Did not set alignment correctly for all contained cells."
            );
        }
    }

    public function testNotSetAllCellsProperties_2()
    {
        $row = new ezcConsoleTableRow();
        for ( $i = 0; $i < 10; $i++ )
        {
            $row[$i]->content = $i;
        }
        
        $row->format = 'headline';
        
        foreach ( $row as $cell )
        {
            $this->assertEquals( 
                'default',
                $cell->format,
                "Did not set alignment correctly for all contained cells."
            );
        }
    }

}
?>
