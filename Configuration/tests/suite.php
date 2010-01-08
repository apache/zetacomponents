<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Configuration
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'configuration_manager_delayed_init_test.php';
require_once 'configuration_test.php';
require_once 'configuration_manager_test.php';
require_once 'configuration_ini_parser_test.php';
require_once 'configuration_ini_reader_test.php';
require_once 'configuration_ini_writer_test.php';
require_once 'configuration_array_writer_test.php';

/**
 * @package Configuration
 * @subpackage Tests
 */
class ezcConfigurationSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Configuration");

        $this->addTest( ezcConfigurationManagerDelayedInitTest::suite() );
        $this->addTest( ezcConfigurationTest::suite() );
        $this->addTest( ezcConfigurationManagerTest::suite() );
        $this->addTest( ezcConfigurationIniReaderTest::suite() );
        $this->addTest( ezcConfigurationIniParserTest::suite() );
        $this->addTest( ezcConfigurationIniWriterTest::suite() );
        $this->addTest( ezcConfigurationArrayWriterTest::suite() );
    }

    public static function suite()
    {
        return new ezcConfigurationSuite();
    }
}

?>
