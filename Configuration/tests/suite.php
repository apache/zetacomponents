<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Configuration
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'configuration_test.php';
require_once 'configuration_manager_test.php';
require_once 'configuration_ini_reader_test.php';
require_once 'configuration_ini_writer_test.php';
require_once 'configuration_array_writer_test.php';

/**
 * @package Configuration
 * @subpackage Tests
 */
class ezcConfigurationSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Configuration");

        $this->addTest( ezcConfigurationTest::suite() );
        $this->addTest( ezcConfigurationManagerTest::suite() );
        $this->addTest( ezcConfigurationIniReaderTest::suite() );
        $this->addTest( ezcConfigurationIniWriterTest::suite() );
        $this->addTest( ezcConfigurationArrayWriterTest::suite() );
    }

    public static function suite()
    {
        return new ezcConfigurationSuite();
    }
}

?>
