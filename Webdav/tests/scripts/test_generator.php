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
    protected $logDir;

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
     * $_SERVER keys to unset.
     * 
     * @var array
     */
    protected $serverBlacklist = array(
        'BOOTLEVEL', 'CONSOLETYPE', 'DEFAULTLEVEL', 'FCGI_ROLE',
        'PHP_FCGI_CHILDREN', 'SHELL', 'SHLVL', 'SOFTLEVEL', 'SVCNAME',
        'TERM', 'USER', 'argc', 'argv',
    );
    
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
            protected function retreiveBody()
            {
                $GLOBALS["EZC_WEBDAV_REQUEST_BODY"] = parent::retreiveBody();
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
     * Creates a new test generator.
     *
     * This method checks if a backend has been stored from a previous request,
     * restores this one or retrieves the default on. It then initializes a
     * server using {@link initServer()} and retrieves and stores the current
     * and next test number to set the {$logDir}.
     * 
     * @param string $baseUri Base URI, if server is not in doc root.
     * @return void
     */
    public function __construct( $baseUri = '' )
    {
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
            $this->initServer( $pathFactory );
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
        $this->logDir = sprintf( '%s/%03s_%s',
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
        try
        {
            $this->server->handle( $this->backend );
        }
        catch ( Exception $e )
        {
            $this->exceptions[] = $e;
        }
    }

    /**
     * Stores captured data.
     *
     * Stores all captured data to the $logDir.
     * 
     * @return void
     */
    public function store()
    {
        if ( !file_exists( $this->logDir ) )
        {
            mkdir( $this->logDir );
        }
        if ( !file_exists( ( $requestLogDir = "{$this->logDir}/request" ) ) )
        {
            mkdir( $requestLogDir );
        }
        if ( !file_exists( ( $responseLogDir = "{$this->logDir}/response" ) ) )
        {
            mkdir( $responseLogDir );
        }

        if ( count( $this->exceptions ) > 0 )
        {
            file_put_contents(
                "{$this->logDir}/error.php",
                "<?php\n\nreturn " . var_export( $this->exceptions, true ) . ";\n\n?>"
            );
        }
        file_put_contents( $this->backendFile, serialize( $this->backend ) );

        file_put_contents(
            "{$requestLogDir}/server.php",
            "<?php\n\nreturn " . var_export( $_SERVER, true ) . ";\n\n?>"
        );
        file_put_contents(
            "{$requestLogDir}/body.xml",
            $GLOBALS['EZC_WEBDAV_REQUEST_BODY']
        );

        file_put_contents(
            "{$responseLogDir}/headers.php",
            "<?php\n\nreturn " . var_export( $GLOBALS['EZC_WEBDAV_RESPONSE_HEADERS'], true ) . ";\n\n?>"
        );
        file_put_contents(
            "{$responseLogDir}/body.xml",
            $GLOBALS['EZC_WEBDAV_RESPONSE_BODY']
        );
        file_put_contents(
            "{$responseLogDir}/status.txt",
            $GLOBALS['EZC_WEBDAV_RESPONSE_STATUS']
        );
    }

    /**
     * Remove unwanted keys from $_SERVER.
     * 
     * @return void
     */
    protected function filterServerVars()
    {
        foreach ( $this->serverBlacklist as $key )
        {
            if ( isset( $_SERVER[$key] ) )
            {
                unset( $_SERVER[$key] );
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
    protected function initServer( ezcWebdavPathFactory $pathFactory )
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
    }
}

?>
