<?php
/**
 * @package Base
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once( "base_test.php");
require_once( "base_init_test.php");
require_once( "features_test.php");
require_once( "base_options_test.php");

/**
 * @package Base
 * @subpackage Tests
 */
class ezcBaseSuite extends PHPUnit_Framework_TestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName("Base");
        
        ezcTestRunner::addFileToFilter( 'Translation' );

        $this->addTest( ezcBaseTest::suite() );
        $this->addTest( ezcBaseInitTest::suite() );
        $this->addTest( ezcBaseFeaturesTest::suite() );
        $this->addTest( ezcBaseOptionsTest::suite() );
	}

    public static function suite()
    {
        return new ezcBaseSuite();
    }
}
?>
