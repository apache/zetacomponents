<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_lockplugin_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientLockPluginTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestLockPluginSetup';
        $this->dataDir    = dirname( __FILE__ ) . '/clients/lockplugin';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }

    protected function runTestSet( $testSetName )
    {
        parent::runTestSet( $testSetName );
        
        $assertionFile = "{$testSetName}_assertions.php";

        if ( file_exists( $assertionFile ) )
        {
            $assertions = include $assertionFile;

            foreach ( $assertions as $assertion )
            {
                $assertion( $this->backend );
            }
        }
    }
}

?>
