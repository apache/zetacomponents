<?php
/**
 * File containing the ezcWebdavClientTestGenerator class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The base directory for all following. 
 */
define( 'PWD', dirname( $_SERVER['SCRIPT_FILENAME'] ) );
/**
 * Where captured data is stored. 
 */
define( 'LOG_DIR', PWD . '/log' );
/**
 * Where temporary data (backend and running test number) are stored.
 */
define( 'TMP_DIR', PWD . '/tmp' );

require_once 'Webdav/tests/classes/test_auth.php';
require_once 'Webdav/tests/classes/test_auth_ie.php';

/**
 * Generator class for client test suites.
 *
 * An instance of this class can be used to generate a client test suite and
 * for general testing and debugging of WebDAV clients.
 *
 * To run the generator copy and adjust the following code to your needs and
 * store it as index.php in a web-enabled directory:
 * <code>
 * require_once 'Base/src/base.php';
 * 
 * function __autoload( $className )
 * {
 *     ezcBase::autoload( $className );
 * }
 * 
 * require_once 'Webdav/tests/scripts/test_generator.php';
 * 
 * // Depends on mod_rewrite! Needed!
 * $generator = new ezcWebdavClientTestGenerator( '/my/webdav/root' );
 * $generator->run();
 * $generator->store();
 * </code>
 *
 * The generator will automaticall instaniate a server for you and mock all
 * transports contained in that server so that the request and response data is
 * captured. If you need to add custom transport configurations, do so right
 * before you instanciate the generator.
 *
 * The generator will store the collected data in a directory structure
 * suitable for a client test suite, although it might also be used for
 * debugging purposes. You need to have directories named log/ and tmp/ in
 * place in your webdav root, which must be writeable by the webserver.
 *
 * The tmp/ dir will be used by the generator to store information between
 * requests, like the state of the backend and the running test number. If you
 * want to cancel the current test run, you should delete the contents of tmp/
 * and log/. After that, you will test with fresh data.
 *
 * The log/ directory stores the captured information. It contains the client
 * test typical request/ and response/ directories for each request a client
 * performed to the generator. Optionally, a file error.php will be generated,
 * if any exceptions occur during the request. This file is not significant for
 * client test cases and only meant for debugging purposes. Each request will
 * be stored in a new test case directory, starting with a running number.
 *
 * To create a client test suite to be integrated into the eZ Components test
 * suite, please consult the {@link Webdav/docs/client_tests.txt} document and
 * follow the steps described there.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogen//
 */
class ezcWebdavClientTestGenerator
{

    /**
     * Directory to store captured data in. 
     * 
     * @var string
     */
    protected $logFileBase;

    /**
     * Backend used.
     * 
     * @var ezcWebdavBackend
     */
    protected $backend;

    /**
     * File to restore/store the backend.
     * 
     * @var string
     */
    protected $backendFile;

    /**
     * Server with mocked transports.
     * 
     * @var ezcWebdavServer
     */
    protected $server;

    /**
     * Carries an array of exceptions of such occur.
     * 
     * @var array(Exception)
     */
    protected $exceptions = array();

    /**
     * PCREs that indicate $_SERVER keys to keep.
     * 
     * @var array
     */
    protected $serverWhiteList = array(
        '(^CONTENT_.*$)',
        '(^DOCUMENT_.*$)',
        '(^GATEWAY_.*$)',
        '(^HTTP_.*)',
        '(^LANG$)',
        '(^PATH_.*$)',
        '(^PHP_SELF$)',
        '(^PHP_AUTH.*$)',
        '(^QUERY_.*$)',
        '(^REDIRECT_.*$)',
        '(^REMOTE_.*$)',
        '(^REQUEST_.*$)',
        '(^SCRIPT_.*$)',
        '(^SERVER_.*$)',
    );

    protected $serverOverwrite = array(
        'REQUEST_TIME' => 1220431173,
        'REMOTE_HOST'  => '127.0.0.1',
        'REMOTE_PORT'  => '33458',
    );

    /**
     * Number of digits for the test case number. 
     * 
     * @var mixed
     */
    protected $testCaseNoDigits;
    
    /**
     * Template to mock transport classes.
     *
     * @var string
     */
    protected $mockClassSource = '
        class %s extends %s
        {
            /**
             * Retreives the body from a global variable.
             * 
             * @return void
             */
            protected function retrieveBody()
            {
                $GLOBALS["EZC_WEBDAV_REQUEST_BODY"] = parent::retrieveBody();
                return $GLOBALS["EZC_WEBDAV_REQUEST_BODY"];
            }
        
            /**
             * Captures the response data in global variables.
             * 
             * @param ezcWebdavOutputResult $output 
             * @return void
             */
            protected function sendResponse( ezcWebdavOutputResult $output )
            {
                $GLOBALS["EZC_WEBDAV_RESPONSE_STATUS"]  = $output->status;
                $GLOBALS["EZC_WEBDAV_RESPONSE_HEADERS"] = $output->headers;
                $GLOBALS["EZC_WEBDAV_RESPONSE_BODY"]    = $output->body;
                parent::sendResponse( $output );
            }
        }
    ';

    /**
     * If a copy of the backend should be stored after each request.
     *
     * For debugging purposes.
     * 
     * @var bool
     */
    protected $storeBackends;
    
    /**
     * Creates a new test generator.
     *
     * This method checks if a backend has been stored from a previous request,
     * restores this one or retrieves the default on. It then initializes a
     * server using {@link initServer()} and retrieves and stores the current
     * and next test number to set the {$logFileBase}.
     * 
     * @param string $baseUri Base URI, if server is not in doc root.
     * @return void
     */
    public function __construct( $baseUri = '', $storeBackends = false, $ie = false, $testCaseNoDigits = 3 )
    {
        $this->lock = TMP_DIR . '/test_generator.lock';

        // Lock for exclusive access
        while ( ( $fp = @fopen( $this->lock, 'x' ) ) === false )
        {
            usleep( 100 );
        }
        fwrite( $fp, microtime() );
        fclose( $fp );


        $this->storeBackends = $storeBackends;
        $this->testCaseNoDigits = $testCaseNoDigits;

        $this->filterServerVars();

        // Restore backend from previous request or setup new
        $this->backend = ( file_exists( ( $this->backendFile = TMP_DIR . '/backend.ser' ) )
            ? unserialize( file_get_contents( $this->backendFile ) )
            : $this->getBackend()
        );

        // Basic path factory, use mod_rewrite!
        try
        {
            $pathFactory = new ezcWebdavBasicPathFactory( 'http://' . $_SERVER['HTTP_HOST'] . $baseUri );
            $this->initServer( $pathFactory, $ie );
        }
        catch ( Exception $e )
        {
            $this->exceptions[] = $e;
        }
        
        // Get current test number and store it for next request
        $testNo = ( file_exists( ( $testNoFile = TMP_DIR . '/testno.txt' ) )
            ? (int) file_get_contents( $testNoFile )
            : 1
        );
        // The captured data will be stored here.
        $this->logFileBase = sprintf( "%s/%0{$this->testCaseNoDigits}s_%s",
            LOG_DIR,
            $testNo,
            strtr(
                $_SERVER['REQUEST_METHOD'],
                array(
                    ' ' => '_',
                    ':' => '_',
                    '(' => '',
                    ')' => '',
                )
            )
        );
        file_put_contents( $testNoFile, ++$testNo );
    }

    /**
     * Runs the server.
     * 
     * @return void
     */
    public function run()
    {
        $GLOBALS['EZC_WEBDAV_ERROR']  = array();
        set_error_handler( array( $this, 'handleErrors' ) );
        try
        {
            $this->server->handle( $this->backend );
        }
        catch ( Exception $e )
        {
            $this->exceptions[] = $e;
        }
        restore_error_handler();
    }

    public function handleErrors( $errNo, $errStr, $errFile, $errLine, $errContext )
    {
        ob_start();
        debug_print_backtrace();
        $backtrace = ob_get_clean();

        $GLOBALS['EZC_WEBDAV_ERROR'][] = array(
            'no'        => $errNo,
            'string'    => $errStr,
            'file'      => $errFile,
            'line'      => $errLine,
            'context'   => $errContext,
            'backtrace' => $backtrace,
        );
    }

    /**
     * Stores captured data.
     *
     * Stores all captured data to the $logFileBase.
     * 
     * @return void
     */
    public function store()
    {
        $requestLogFileBase  = "{$this->logFileBase}_request";
        $responseLogFileBase = "{$this->logFileBase}_response";

        if ( count( $this->exceptions ) > 0 )
        {
            file_put_contents(
                "{$this->logFileBase}_exception.php",
                "<?php\n\nreturn " . var_export( $this->exceptions, true ) . ";\n\n?>"
            );
        }
        if ( count( $GLOBALS['EZC_WEBDAV_ERROR'] ) )
        {
            file_put_contents(
                "{$this->logFileBase}_error.php",
                "<?php\n\nreturn " . var_export( $GLOBALS['EZC_WEBDAV_ERROR'], true ) . ";\n\n?>"
            );
        }

        file_put_contents(
            "{$requestLogFileBase}_server.php",
            "<?php\n\nreturn " . var_export( $_SERVER, true ) . ";\n\n?>"
        );
        file_put_contents(
            "{$requestLogFileBase}_body.xml",
            $GLOBALS['EZC_WEBDAV_REQUEST_BODY']
        );

        file_put_contents(
            "{$responseLogFileBase}_headers.php",
            "<?php\n\nreturn " . var_export( $GLOBALS['EZC_WEBDAV_RESPONSE_HEADERS'], true ) . ";\n\n?>"
        );
        file_put_contents(
            "{$responseLogFileBase}_body.xml",
            $GLOBALS['EZC_WEBDAV_RESPONSE_BODY']
        );
        file_put_contents(
            "{$responseLogFileBase}_status.txt",
            $GLOBALS['EZC_WEBDAV_RESPONSE_STATUS']
        );

        $serBackend = serialize( $this->backend );
        file_put_contents( $this->backendFile, $serBackend );
        if ( $this->storeBackends )
        {
            file_put_contents(
                "{$this->logFileBase}_backend.ser",
                $serBackend
            );
        }
    }

    /**
     * Finish and cleanup.
     * 
     * @return void
     */
    public function finish()
    {
        unlink( $this->lock );
    }

    /**
     * Remove unwanted keys from $_SERVER.
     * 
     * @return void
     */
    protected function filterServerVars()
    {
        foreach ( $_SERVER as $key => $val )
        {
            foreach ( $this->serverWhiteList as $regex )
            {
                if ( preg_match( $regex, $key ) )
                {
                    continue 2;
                }
            }
            // No regex matched
            unset( $_SERVER[$key] );
        }

        // Adjust variables for better test case comparison
        foreach ( $this->serverOverwrite as $key => $val )
        {
            if ( isset( $_SERVER[$key] ) )
            {
                $_SERVER[$key] = $val;
            }
        }
    }

    /**
     * Retrieves the initial backend.
     * 
     * @return ezcWebdavBackend
     */
    protected function getBackend()
    {
        try
        {
            return require_once dirname( __FILE__ ) . '/test_generator_backend.php';
        }
        catch ( Exception $e )
        {
            $this->exceptions[] = $e;
        }
    }
    
    /**
     * Initialializes the WebDAV server used for capturing.
     * 
     * Retrieves the global server singleton and replaces all configured
     * transports with their corresponding mock.
     *
     * @param ezcWebdavPathFactory $pathFactory 
     * @return void
     */
    protected function initServer( ezcWebdavPathFactory $pathFactory, $ie )
    {
        $this->server = ezcWebdavServer::getInstance();
        
        foreach ( $this->server->configurations as $id => $transportCfg )
        {
            // Prepare mock classes, if not done, yet
            if ( !class_exists( ( $mockClass = ( $transportCfg->transportClass . 'Mock' ) ), false ) )
            {
                eval( sprintf( $this->mockClassSource, $mockClass, $transportCfg->transportClass ) );
            }

            // Replace with mock config
            $this->server->configurations[$id]->transportClass  = $mockClass;
            $this->server->configurations[$id]->pathFactory     = $pathFactory;
        }

        $this->server->auth = ( $ie ? new ezcWebdavTestAuthIe() : new ezcWebdavTestAuth() );
    }
}

?>
