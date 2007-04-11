<?php
/**
 * ezcConsoleOutputOptionsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * Test suite for ezcConsoleOutputOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleOutputOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleOutputOptionsTest" );
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

    public function testCompatibility()
    {
        $old = new ezcConsoleOutputOptions( 5, 80 );
        $new = new ezcConsoleOutputOptions(
            array( 
                "verbosityLevel"    => 5,
                "autobreak"         => 80,
            )
        );
        $this->assertEquals( $old, $new, "Old construction method did not produce same result as old one." );
    }

    public function testNewAccess()
    {
        $opt = new ezcConsoleOutputOptions();
        $this->assertEquals( $opt->verbosityLevel, 1 );
        $this->assertEquals( $opt->autobreak, 0 );
        $this->assertEquals( $opt->useFormats, true );
        $this->assertEquals( $opt["verbosityLevel"], 1 );
        $this->assertEquals( $opt["autobreak"], 0 );
        $this->assertEquals( $opt["useFormats"], true );
    }

}

?>
