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

    public function getTestSetIds()
    {
        return $this->testSets->getKeys();
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

    public function runTest()
    {
        if ( $this->currentTestSet === false )
        {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'No currentTestSet set for test ' . __CLASS__
            );
        }

        // Store current timezone and switch to UTC for test
        $oldTimezone = date_default_timezone_get();
        date_default_timezone_set( 'UTC' );

        $this->runTestSet( $this->currentTestSet );

        // Reset old timezone
        date_default_timezone_set( $oldTimezone );
    }

    protected function runTestSet( $testSetId )
    {
        try
        {
            call_user_func(
                array( $this->setupClass, 'performSetup' ),
                $this,
                $testSetId
            );
        }
        catch ( RuntimeException $e )
        {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'Back end setup failed: "' . $e->getMessage() . '"'
            );
        }

        $this->backend->options->lockFile = $this->tmpDir . '/backend.lock';


        $testData = $this->testSets[$testSetId];

        $this->adjustRequest( $testData['request'] );

        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = $testData['request']['body'];
        $_SERVER = $testData['request']['server'];

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
        if ( isset( $testData['response']['headers']['WWW-Authenticate'] )
             && isset( $testData['response']['headers']['WWW-Authenticate']['digest'] )
             && isset( $response['headers']['WWW-Authenticate'] )
             && isset( $response['headers']['WWW-Authenticate']['digest'] ) )
        {
            preg_match( '(nonce="([a-zA-Z0-9]+)")', $response['headers']['WWW-Authenticate']['digest'], $matches );
            $testData['response']['headers']['WWW-Authenticate']['digest'] = preg_replace( '(nonce="([a-zA-Z0-9]+)")', 'nonce="' . $matches[1] . '"', $testData['response']['headers']['WWW-Authenticate']['digest'] );
        }

        $this->adjustResponse( $response, $testData['response'] );

        $this->assertEquals(
            $testData['response'],
            $response,
            'Response sent by WebDAV server incorrect.'
        );
    }

    protected function adjustRequest( array &$request )
    {
    }

    protected function adjustResponse( array &$realResponse, array &$expectedResponse )
    {
    }

}

?>
