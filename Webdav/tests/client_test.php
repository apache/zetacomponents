<?php

abstract class ezcWebdavClientTest extends ezcTestCase
{
    protected $testSets = array();

    protected $dataDir;

    protected $transportClass;

    protected $currentTestSet;

    /**
     * Needs 
     * 
     * @return void
     */
    abstract protected function setupTestEnvironment();

    public function __construct()
    {
        parent::__construct();
        $this->setupTestEnvironment();

        foreach ( glob( $this->dataDir . '/*.result.txt' ) as $resultFile )
        {
            $this->testSets[] = dirname( $resultFile ) . '/' . basename( $resultFile, '.result.txt' );
        }
    }

    public function getTestSets()
    {
        return $this->testSets;
    }

    public function setTestSet( $testSet )
    {
        $this->currentTestSet = $testSet;
    }

    public function runTest()
    {
        if ( $this->currentTestSet === false )
        {
            throw new PHPUnit_Framework_ExpectationFailedException( "No currentTestSet set for test " . __CLASS__ );
        }

        $this->runTestSet();
    }

    protected function runTestSet()
    {
        if ( file_exists( ( $resultFile = $this->currentTestSet . '.result.txt' ) ) === true 
            && ( $referenceResult = file_get_contents( $resultFile ) ) !== ''
           )
        {
            $referenceResult = unserialize( file_get_contents( $resultFile ) );
        }
        else
        {
            $referenceResult = false;
        }

        // Optionally set a body.
        if ( file_exists( ($bodyFile = $this->currentTestSet . '.body.php' ) ) )
        {
            $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = require $bodyFile;
        }
        else
        {
            $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = '';
        }

        // Optionally overwrite $_SERVER
        if ( file_exists( ( $serverFile = $this->currentTestSet . '.server.php' ) ) )
        {
            $_SERVER = require $serverFile;
        }
        
        if ( file_exists( ( $uriFile = $this->currentTestSet . 'uri.txt' ) ) )
        {
            $uri = file_get_contents( $uriFile );
        }
        else
        {
            $uri = 'http://localhost/webdav.php';
        }

        $transportClass = $this->transportClass;
        $transport = new $transportClass();
        $result = $transport->parseRequest( $uri );

        if ( $referenceResult === false )
        {
            // Regenerate
            file_put_contents( $resultFile, serialize( $result ) );
        }

        $this->assertEquals(
            $referenceResult,
            $result,
            "Result not parsed correctly for test set '{$this->currentTestSet}'."
        );
    }

}

?>
