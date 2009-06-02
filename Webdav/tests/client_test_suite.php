<?php

require_once 'Webdav/tests/client_test_rfc_setup.php';
require_once 'Webdav/tests/client_test_rfc_lock_setup.php';
require_once 'Webdav/tests/client_test_continuous_setup.php';
require_once 'Webdav/tests/client_test_continuous_lock_setup.php';
require_once 'Webdav/tests/client_test_continuous_setup_ie_auth.php';

class ezcWebdavClientTestSuite extends PHPUnit_Framework_TestSuite
{
    protected $testSets;

    protected $setup;

    public function __construct( $name, $dataFile, ezcWebdavClientTestSetup $setup = null )
    {
        $this->name = "Client: $name";
        $this->testSets = new ezcWebdavTestSetContainer(
            dirname( __FILE__ ) . '/' . $dataFile
        );
        $this->setup = (
            $setup === null ? new ezcWebdavClientTestContinousSetup() : $setup
        );

        foreach ( $this->testSets as $testId => $testData )
        {
            $this->addTest(
                new ezcWebdavClientTest(
                    $testId,
                    $this->setup,
                    $testData
                )
            );
        }
    }
}

?>
