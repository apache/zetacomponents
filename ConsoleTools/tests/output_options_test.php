<?php
/**
 * ezcConsoleToolsOutputOptionsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutputOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsOutputOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcConsoleToolsOutputOptionsTest" );
	}

    /**
     * testConstructor
     * 
     * @access public
     */
    public function testConstructor()
    {
        $fake = new ezcConsoleOutputOptions( 1, 0, true );
        $this->assertEquals( 
            $fake,
            new ezcConsoleOutputOptions(),
            'Default values incorrect for ezcConsoleOutputOptions.'
        );
    }
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleOutputOptions(
            array( 
                "verbosityLevel" => 1,
                "autobreak" => 0,
                "useFormats" => true,
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleOutputOptions(),
            'Default values incorrect for ezcConsoleOutputOptions.'
        );
    }

}

?>
