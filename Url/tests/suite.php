<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "url_test.php" );
require_once( "url_configuration_test.php" );
require_once( "url_creator_test.php" );
require_once( "url_tools_test.php" );

/**
 * @package Url
 * @subpackage Tests
 */
class ezcUrlSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Url" );

        $this->addTest( ezcUrlTest::suite() );
        $this->addTest( ezcUrlConfigurationTest::suite() );
        $this->addTest( ezcUrlCreatorTest::suite() );
        $this->addTest( ezcUrlToolsTest::suite() );
    }

    public static function suite()
    {
        return new ezcUrlSuite();
    }
}
?>
