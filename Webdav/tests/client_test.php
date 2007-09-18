<?php

abstract class ezcWebdavClientTest extends ezcTestCase
{

    protected $dataDir;

    protected $transportClass;

    private $testSets = array();
    
    private $currentTestSet;

    /**
     * Needs to set different options.
     * {@link $this->dataDir} needs to be set to the base path of
     * Webdav/tests/clients/<clientname>
     * {@link $this->transportClass} needs to be set to the transport class to
     * use, e.g. {@link ezcWebdavTransportTestMock} for a RFC compliant test.
     * 
     * @return void
     */
    abstract protected function setupTestEnvironment();

    public function __construct()
    {
        parent::__construct();
        $this->setupTestEnvironment();

        foreach ( glob( $this->dataDir . '/*' ) as $testSetDir )
        {
            $this->testSets[] = $testSetDir;
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

        $this->runTestSet( $this->currentTestSet );
    }

    protected function runTestSet( $testSetName )
    {
        $requestObject = null;

        // Request test
        if ( file_exists( ( $requestDir = "{$testSetName}/request" ) ) === true )
        {
            // Settings
            $request = array();
            $request['result'] = $this->getFileContent( $requestDir, 'result' );
            $request['server'] = $this->getFileContent( $requestDir, 'server' );
            $request['body']   = $this->getFileContent( $requestDir, 'body' );
            $request['uri']    = $this->getFileContent( $requestDir, 'uri' );
            
            $requestObject = $this->runRequestTest( $request );
        }

        // Response test
        if ( file_exists( ( $responseDir = "{$this->dataDir}/response" ) ) === true && $requestObject !== null )
        {
            // Settings
            $response = array();
            $response['result'] = $this->getFileContent( $responseDir, 'result' );
            $response['headers'] = $this->getFileContent( $responseDir, 'headers' );
            $response['body']   = $this->getFileContent( $responseDir, 'body' );
            
            $responseObject = $this->runResponseTest( $response, $requestObject );
        }
    }

    protected function getFileContent( $dir, $file )
    {
        // No file exists
        if ( count( $files = glob( "{$dir}/{$file}.*" ) ) < 1 )
        {
            return false;
        }

        // The first file overrides
        $fileInfo    = pathinfo( ( $filePath = $files[0] ) );
        $fileContent = '';
        switch( $fileInfo['extension'] )
        {
            case 'php':
                $fileContent = require $filePath;
                break;
            case 'ser':
                $fileContent = unserialize( file_get_contents( $filePath ) );
                break;
            case 'txt':
            default:
                $fileContent = file_get_contents( $filePath );
                break;
        }
        return $fileContent;
    }

    protected function runRequestTest( array $request )
    {
        // Optionally set a body.
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = ( $request['body'] !== false ? $request['body'] : '' );

        // Optionally overwrite $_SERVER
        $_SERVER = ( $request['server'] !== false ? $request['server'] : $_SERVER );

        // Optionally set an URI different from 'http://localhost/webdav.php'
        $uri = ( $request['uri'] !== false  ? $request['uri'] : 'http://localhost/webdav.php' );

        // Setup test environment
        $transportClass = $this->transportClass;
        $transport = new $transportClass();
        
        // Begin request test
        $result = $transport->parseRequest( $uri );

        if ( $request['result'] === false )
        {
            // Regenerate
            file_put_contents(
                "{$this->dataDir}/request/result.txt",
                serialize( $result )
            );
        }

        $this->assertEquals(
            $request['result'],
            $result,
            "Result not parsed correctly for test set '{$this->currentTestSet}'."
        );
    }

    protected function runResponseTest( array $response, ezcWebdavRequest $requestObject )
    {
        // To be implemented...
    }

}

?>
