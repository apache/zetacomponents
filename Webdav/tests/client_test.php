<?php

libxml_use_internal_errors( true );

abstract class ezcWebdavClientTest extends ezcTestCase
{
    /**
     * If the backend used in client tests should be stored.
     *
     * Helpfull if new client tests should be appended to existing ones.
     */
    const STORE_BACKEND = false;

    protected $setupClass;

    public $dataDir;
    
    public $server;

    public $backend;

    private $testSets = array();
    
    private $currentTestSet;

    private $reset = false;

    protected static $backendDir;

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

        // Initialize directory to store backend dumps in
        if ( self::STORE_BACKEND && self::$backendDir === null )
        {
            self::$backendDir = $this->createTempDir( 'WebdavBackendDump' );
        }

        $this->setupTestEnvironment();

        // Reset the backend at start of the suite

        foreach ( glob( $this->dataDir . '/*request_server.php' ) as $testSetFile )
        {
            $this->testSets[] = substr( $testSetFile, 0, -19 );
        }
    }

    public function setUp()
    {
        $this->tmpDir = $this->createTempDir(
            get_class( $this )
        );
    }

    public function tearDown()
    {
        $this->removeTempDir();
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

        // Store current timezone and switch to UTC for test
        $oldTimezone = date_default_timezone_get();
        date_default_timezone_set( 'UTC' );

        $this->runTestSet( $this->currentTestSet );

        // Reset old timezone
        date_default_timezone_set( $oldTimezone );
    }

    protected function runTestSet( $testSetName )
    {
        try
        {
            call_user_func( array( $this->setupClass, 'performSetup' ), $this, $testSetName );
        }
        catch ( RuntimeException $e )
        {
            $this->markTestSkipped( 'Backend setup failed.' );
            return;
        }

        $this->backend->options->lockFile = $this->tmpDir . '/backend.lock';

        $requestObject = null;

        $serverBase = array(
            'DOCUMENT_ROOT'   => '/var/www/localhost/htdocs',
            'HTTP_USER_AGENT' => 'RFC compliant',
            'SCRIPT_FILENAME' => '/var/www/localhost/htdocs',
            'SERVER_NAME'     => 'webdav',
        );

        $requestFileName  = $testSetName . '_request';
        $responseFileName = $testSetName . '_response';

        // Settings
        $request = array();
        $request['server'] = array_merge( $serverBase, $this->getFileContent( $requestFileName, 'server' ) );
        $request['body']   = $this->getFileContent( $requestFileName, 'body' );

        $this->adjustRequest( $request );

        // Settings
        $expectedRespons = array();
        $expectedResponse['headers'] = $this->getFileContent( $responseFileName, 'headers' );
        $expectedResponse['body']    = $this->getFileContent( $responseFileName, 'body' );
        $expectedResponse['status']  = trim( $this->getFileContent( $responseFileName, 'status' ) );
        
        // Optionally set a body.
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = ( $request['body'] !== false ? $request['body'] : '' );

        // Optionally overwrite $_SERVER
        $_SERVER = $request['server'];

        ini_set( 'xdebug.collect_return', 1 );
        xdebug_start_trace( './traces/' . basename( $testSetName ) );
        $this->server->handle( $this->backend );
        xdebug_stop_trace();

        $response['headers'] = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'];
        $response['body']    = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'];
        $response['status']  = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS'];

        // Reset globals
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS'] );

        // Store backend after test execution, if desired
        if ( self::STORE_BACKEND )
        {
            $backendDir = self::$backendDir . '/' . get_class( $this );

            if ( !is_dir( $backendDir ) )
            {
                mkdir( $backendDir );
            }

            file_put_contents(
                $backendDir . '/' . basename( $testSetName ) . '.ser',
                serialize( $this->backend )
            );
        }

        // Unify server generated nounce
        if ( isset( $expectedResponse['headers']['WWW-Authenticate'] )
             && isset( $expectedResponse['headers']['WWW-Authenticate']['digest'] )
             && isset( $response['headers']['WWW-Authenticate'] )
             && isset( $response['headers']['WWW-Authenticate']['digest'] ) )
        {
            preg_match( '(nonce="([a-zA-Z0-9]+)")', $response['headers']['WWW-Authenticate']['digest'], $matches );
            $expectedResponse['headers']['WWW-Authenticate']['digest'] = preg_replace( '(nonce="([a-zA-Z0-9]+)")', 'nonce="' . $matches[1] . '"', $expectedResponse['headers']['WWW-Authenticate']['digest'] );
        }

        $this->adjustResponse( $response, $expectedResponse );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Response sent by WebDAV server incorrect.'
        );
    }

    protected function getFileContent( $filePrefix, $file )
    {
        // No file exists
        if ( count( $files = glob( "{$filePrefix}_{$file}.*" ) ) < 1 )
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

    protected function adjustRequest( array &$request )
    {
    }

    protected function adjustResponse( array &$realResponse, array &$expectedResponse )
    {
    }

}

?>
