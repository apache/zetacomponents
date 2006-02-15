<?php
/**
 * ezcConsoleToolsTableCell 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleTableCell class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsTableCellTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcConsoleToolsTableCellTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testCtorSuccess()
    {
        $cell = new ezcConsoleTableCell( 'test', 'success', ezcConsoleTable::ALIGN_RIGHT );
        $this->assertTrue( 
            isset( $cell->content ) && $cell->content === 'test' && isset( $cell->format ) && $cell->format === 'success' && isset( $cell->align ) && $cell->align === ezcConsoleTable::ALIGN_RIGHT,
            "ezcConsoleTableCell not correctly created."
        );
    }
    
    public function testCtorFailure()
    {
        try
        {
            $cell = new ezcConsoleTableCell( 'test', 'success', 42 );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertTrue(true);
            return;
        }
        $this->fail( "Exception not thrown on invalid align value." );
    }
    
}
?>
