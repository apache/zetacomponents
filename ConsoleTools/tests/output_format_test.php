<?php
/**
 * ezcConsoleToolsOutputFormatTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutputFormat struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsOutputFormatTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcConsoleToolsOutputFormatTest" );
	}

    /**
     * testConstructor
     * 
     * @access public
     */
    public function testConstructor()
    {
        $fake = new ezcConsoleOutputFormat('default', array( 'default' ), 'default' );
        $this->assertEquals( 
            $fake,
            new ezcConsoleOutputFormat(),
            'Default values incorrect for ezcConsoleOutputFormat.'
        );
    }
}

?>
