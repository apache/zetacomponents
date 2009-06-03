<?php

require_once 'Webdav/tests/client_test.php';

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
