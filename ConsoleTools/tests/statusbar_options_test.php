<?php
/**
 * ezcConsoleStatusbarOptionsTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * Test suite for ezcConsoleStatusbarOptions struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleStatusbarOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleStatusbarOptionsTest" );
	}
    
    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructorNew()
    {
        $fake = new ezcConsoleStatusbarOptions(
            array( 
                "successChar" => "+",
                "failureChar" => "-",
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcConsoleStatusbarOptions(),
            'Default values incorrect for ezcConsoleStatusbarOptions.'
        );
    }

    public function testNewAccess()
    {
        $opt = new ezcConsoleStatusbarOptions();
        $this->assertEquals( "+", $opt->successChar );
        $this->assertEquals( "-", $opt->failureChar );

        $this->assertEquals( $opt["successChar"], "+" );
        $this->assertEquals( $opt["failureChar"], "-" );
    }

}

?>
