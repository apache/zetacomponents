<?php
/**
 * ezcConsoleToolsOutputFormatsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutputFormats struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsOutputFormatsTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcConsoleToolsOutputFormatsTest" );
	}

    /**
     * testConstructor
     */
    public function testConstructor()
    {
        $fake = new ezcConsoleOutputFormats();
        $fake->default = new ezcConsoleOutputFormat();
        $this->assertEquals( 
            $fake,
            new ezcConsoleOutputFormats(),
            'Default values incorrect for ezcConsoleOutputFormats.'
        );
    }

    /**
     * Test on the fly creation with __get()
     */
    public function testGet()
    {
        $form = new ezcConsoleOutputFormats();
        $fake = new ezcConsoleOutputFormat();
        $this->assertEquals( 
            $fake,
            $form->foobar,
            'On the fly creation of ezcConsoleOutputFormat failed.'
        );
    }

    /**
     * Test on the fly creation with __set()
     */
    public function testGetManipulate()
    {
        $form = new ezcConsoleOutputFormats();
        $form->foobar->color = 'blue';
        
        $fake = new ezcConsoleOutputFormat();
        $fake->color = 'blue';
        
        $this->assertEquals( 
            $fake,
            $form->foobar,
            'Manipulation of ezcConsoleOutputFormat failed.'
        );
    }

}

?>
