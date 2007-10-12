<?php

libxml_use_internal_errors( true );

abstract class ezcWebdavClientTest extends ezcTestCase
{

    /**
     * Do not switch true together with REGENERATE_RESPONSE. 
     */
    const REGENERATE_REQUEST  = false;
    /**
     * Do not switch true together with REGENERATE_REQUEST. 
     */
    const REGENERATE_RESPONSE = false;

    protected $setupClass;

    public $dataDir;
    
    public $server;

    public $backend;

    private $testSets = array();
    
    private $currentTestSet;

    private $reset = false;

    /**
     * Needs to set different options.
     * {@link $this->dataDir} needs to be set to the base path of
     * Webdav/tests/clients/<clientname>
     * {@link $this->transport} needs to be set to the transport to
     * use, e.g. {@link ezcWebdavTransportTestMock} for a RFC compliant test.
     * 
     * @return void
     */
    abstract protected function setupTestEnvironment();

    public function __construct()
    {
        parent::__construct();
        $this->setupTestEnvironment();

        // Reset the backend at start of the suite

        foreach ( glob( $this->dataDir . '/*', GLOB_ONLYDIR ) as $testSetDir )
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
        $this->setName( basename( $testSet ) );
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
        call_user_func( array( $this->setupClass, 'performSetup' ), $this, $testSetName );

        $requestObject = null;

        $serverBase = array(
            'DOCUMENT_ROOT'   => '/var/www/localhost/htdocs',
            'HTTP_USER_AGENT' => 'RFC compliant',
            'SCRIPT_FILENAME' => '/var/www/localhost/htdocs',
            'SERVER_NAME'     => 'webdav',
        );

        // Request test
        if ( file_exists( ( $requestDir = "{$testSetName}/request" ) ) === false )
        {
            throw new PHPUnit_Framework_ExpectationFailedException( "No test data found for '$requestDir'." );
        }
        // Settings
        $request = array();
        $request['server'] = array_merge( $serverBase, $this->getFileContent( $requestDir, 'server' ) );
        $request['body']   = $this->getFileContent( $requestDir, 'body' );

        // Response test
        if ( file_exists( ( $responseDir = "{$testSetName}/response" ) ) === true && $requestObject instanceof ezcWebdavRequest && $this->setupClass !== null )
        {
            throw new PHPUnit_Framework_ExpectationFailedException( "No test data found for '$requestDir'." );
        }
        // Settings
        $response = array();
        $response['headers'] = $this->getFileContent( $responseDir, 'headers' );
        $response['body']    = $this->getFileContent( $responseDir, 'body' );
        $response['code']    = trim( $this->getFileContent( $responseDir, 'code' ) );
        $response['name']    = trim( $this->getFileContent( $responseDir, 'name' ) );
        
        // Optionally set a body.
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = ( $request['body'] !== false ? $request['body'] : '' );

        // Optionally overwrite $_SERVER
        $_SERVER = $request['server'];

        $this->server->handle( $this->backend );

        $responseBody    = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'];
        $responseHeaders = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'];
        $responseStatus  = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS'];

        // Reset globals
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS'] );

        $this->assertEquals(
            $response['headers'],
            $responseHeaders,
            'Headers sent by WebDAV server incorrect.'
        );

        $this->assertEquals(
            $response['body'],
            $responseBody,
            'Body sent by WebDAV server incorrect.'
        );

        $this->assertEquals(
            "HTTP/1.1 {$response['code']} {$response['name']}",
            $responseStatus,
            'Status code sent by WebDAV server incoreect.'
        );
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
            case 'txt':
            default:
                $fileContent = file_get_contents( $filePath );
                break;
        }
        return $fileContent;
    }

}

?>
