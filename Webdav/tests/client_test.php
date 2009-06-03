<?php


require_once 'classes/test_sets.php';

class ezcWebdavClientTest extends ezcTestCase
{
    /**
     * If the backend used in client tests should be stored.
     *
     * Helpfull if new client tests should be appended to existing ones.
     */
    const STORE_BACKEND = false;

    protected $setup;

    protected $id;

    public $testData;
    
    public $server;

    public $backend;

    protected $timeZone;

    private $reset = false;

    protected static $backendDir;

    protected $oldLibxmlErrorSetting;

    public function __construct( $id, ezcwebdavClientTestSetup $setup, array $testData )
    {
        parent::__construct(
            sprintf(
                '%s %s',
                $id,
                $testData['request']['server']['REQUEST_METHOD']
            )
        );
        $this->id = $id;
        $this->testData = $testData;
        $this->setup    = $setup;
    }

    public function setUp()
    {
        $this->oldLibxmlErrorSetting = libxml_use_internal_errors( true );

        $this->setup->performSetup( $this, $this->id );

        $this->tmpDir = $this->createTempDir(
            get_class( $this )
        );

        // Store current timezone and switch to UTC for test
        $this->timezone = date_default_timezone_get();
        date_default_timezone_set( 'UTC' );

        $this->backend->options->lockFile = $this->tmpDir . '/backend.lock';
    }

    protected function tearDown()
    {
        libxml_use_internal_errors( $this->oldLibxmlErrorSetting );
        $this->removeTempDir();

        // Reset old timezone
        date_default_timezone_set( $this->timezone );
    }

    public function runTest()
    {
        $this->setup->adjustRequest( $this->testData['request'] );

        $response = $this->performTestSetRun( $this->testData['request'] );

        $this->setup->adjustResponse( $response, $this->testData['response'] );

        $this->assertEquals(
            $this->testData['response'],
            $response,
            'Response sent by WebDAV server incorrect.'
        );
    }

    /**
     * storeBackend 
     * 
     * @TODO Revise!
     * @return void
     */
    protected function storeBackend()
    {
        /*
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
        */
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

}

?>
