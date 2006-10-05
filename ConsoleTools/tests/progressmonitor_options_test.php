<?php
/**
 * ezcConsoleToolsProgressMonitorOptionsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleProgressMonitorOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsProgressMonitorOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleToolsProgressMonitorOptionsTest" );
	}
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleProgressMonitorOptions(
            array( 
                "formatString" => "%8.1f%% %s %s",
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleProgressMonitorOptions(),
            'Default values incorrect for ezcConsoleProgressMonitorOptions.'
        );
    }

    public function testNewAccess()
    {
        $opt = new ezcConsoleProgressMonitorOptions();
        $this->assertEquals( "%8.1f%% %s %s", $opt->formatString );

        $this->assertEquals( $opt["formatString"], "%8.1f%% %s %s" );
    }

}

?>
