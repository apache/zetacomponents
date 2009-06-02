<?php

libxml_use_internal_errors( true );

require_once 'classes/test_sets.php';

abstract class ezcWebdavClientTest extends ezcTestCase
{
    /**
     * If the backend used in client tests should be stored.
     *
     * Helpfull if new client tests should be appended to existing ones.
     */
    const STORE_BACKEND = false;

    protected $setupClass;

    public $dataFile;
    
    public $server;

    public $backend;

    protected $timeZone;

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


        $this->testSets = new ezcWebdavTestSetContainer(
            $this->dataFile
        );
    }

    public function setTestSet( $testSetId )
    {
        $this->currentTestSet = $testSetId;
        $this->setName(
            sprintf(
                '%s_%s',
                get_class( $this ),
                $testSetId
            )
        );
    }

    public function setUp()
    {
        if ( $this->currentTestSet === false )
        {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'No currentTestSet set for test ' . __CLASS__
            );
        }

        $this->tmpDir = $this->createTempDir(
            get_class( $this )
        );

        // Store current timezone and switch to UTC for test
        $this->timezone = date_default_timezone_get();
        date_default_timezone_set( 'UTC' );

        try
        {
            call_user_func(
                array( $this->setupClass, 'performSetup' ),
                $this,
                $this->currentTestSet
            );
        }
        catch ( RuntimeException $e )
        {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'Back end setup failed: "' . $e->getMessage() . '"'
            );
        }

        $this->backend->options->lockFile = $this->tmpDir . '/backend.lock';
    }

    protected function tearDown()
    {
        $this->removeTempDir();

        // Reset old timezone
        date_default_timezone_set( $this->timezone );
    }

    public function getTestSetIds()
    {
        return $this->testSets->getKeys();
    }

    public function runTest()
    {
        $testData = $this->testSets[$this->currentTestSet];

        $this->adjustRequest( $testData['request'] );

        $response = $this->performTestSetRun( $testData['request'] );

        $this->adjustResponse( $response, $testData['response'] );

        $this->assertEquals(
            $testData['response'],
            $response,
            'Response sent by WebDAV server incorrect.'
        );
    }

    protected function storeBackend()
    {
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
    }

    protected function performTestSetRun( array $request )
    {
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = $request['body'];
        $_SERVER = $request['server'];

        // ini_set( 'xdebug.collect_return', 1 );
        // xdebug_start_trace( './traces/' . basename( $testSetName ) );
        $this->server->handle( $this->backend );
        // xdebug_stop_trace();

        $response['body']    = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'];
        $response['headers'] = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'];
        $response['status']  = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS'];

        // Reset globals
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'] );
        unset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS'] );

        return $response;
    }

    protected function runTestSet( $testSetId )
    {
    }

    protected function adjustRequest( array &$request )
    {
    }

    protected function adjustResponse( array &$actualResponse, array &$expectedResponse )
    {
        // Unify server generated nounce
        if ( isset( $expectedResponse['headers']['WWW-Authenticate']['digest'] )
             && isset( $actualResponse['headers']['WWW-Authenticate']['digest'] ) )
        {
            preg_match(
                '(nonce="[a-zA-Z0-9]+")',
                $actualResponse['headers']['WWW-Authenticate']['digest'],
                $matches
            );
            $expectedResponse['headers']['WWW-Authenticate']['digest'] = preg_replace(
                '(nonce="([a-zA-Z0-9]+)")',
                $matches[0],
                $expectedResponse['headers']['WWW-Authenticate']['digest']
            );
        }
    }
}

?>
