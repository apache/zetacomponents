<?php

abstract class ezcWebdavClientTest extends ezcTestCase
{

    protected $dataDir;

    protected $transport;

    protected $setupClass;

    protected $pathFactory = 'ezcWebdavPathFactory';

    private $testSets = array();
    
    private $currentTestSet;

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
        $requestObject = null;

        $serverBase = array(
            'DOCUMENT_ROOT'   => '/var/www/localhost/htdocs',
            'SCRIPT_FILENAME' => '/var/www/localhost/htdocs',
        );

        // Request test
        if ( file_exists( ( $requestDir = "{$testSetName}/request" ) ) === true )
        {
            // Settings
            $request = array();
            $request['result'] = $this->getFileContent( $requestDir, 'result' );
            $request['server'] = array_merge( $serverBase, $this->getFileContent( $requestDir, 'server' ) );
            $request['body']   = $this->getFileContent( $requestDir, 'body' );
            $request['uri']    = $this->getFileContent( $requestDir, 'uri' );
            
            $requestObject = $this->runRequestTest( $request );
        }

        // Response test
        if ( file_exists( ( $responseDir = "{$testSetName}/response" ) ) === true && $requestObject instanceof ezcWebdavRequest && $this->setupClass !== null )
        {
            $requestObject->validateHeaders();

            // Settings
            $response = array();
            $response['result']  = $this->getFileContent( $responseDir, 'result' );
            $response['headers'] = $this->getFileContent( $responseDir, 'headers' );
            $response['body']    = $this->getFileContent( $responseDir, 'body' );
            $response['code']    = $this->getFileContent( $responseDir, 'code' );
            $response['name']    = $this->getFileContent( $responseDir, 'name' );
            $response['backend'] = call_user_func( array( $this->setupClass, 'getSetup' ), basename( $testSetName ) );
            
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
        $uri = ( $request['uri'] !== false ? $request['uri'] : '/webdav.php' );

        // Begin request test
        $result = $this->transport->parseRequest( $uri );

        if ( $request['result'] === false )
        {
            // Regenerate
            file_put_contents(
                "{$this->currentTestSet}/request/result.ser",
                serialize( $result )
            );
        }

        $this->assertEquals(
            $request['result'],
            $result,
            "Result not parsed correctly for test set '{$this->currentTestSet}'."
        );

        return $result;
    }

    protected function runResponseTest( array $response, ezcWebdavRequest $requestObject )
    {
        switch( get_class( $requestObject ) )
        {
            case 'ezcWebdavGetRequest':
                $responseObject = $response['backend']->get( $requestObject );
                break;
            case 'ezcWebdavHeadRequest':
                $responseObject = $response['backend']->head( $requestObject );
                break;
            case 'ezcWebdavPropFindRequest':
                $responseObject = $response['backend']->propFind( $requestObject );
                break;
            case 'ezcWebdavPropPatchRequest':
                $responseObject = $response['backend']->propPatch( $requestObject );
                break;
            case 'ezcWebdavDeleteRequest':
                if ( $requestObject instanceof ezcWebdavBackendChange )
                {
                    $responseObject = $response['backend']->delete( $requestObject );
                }
                else
                {
                    $this->fail( 'Backend does not support testing DELETE request.' );
                }
                break;
            case 'ezcWebdavCopyRequest':
                if ( $requestObject instanceof ezcWebdavBackendChange )
                {
                    $responseObject = $response['backend']->copy( $requestObject );
                }
                else
                {
                    $this->fail( 'Backend does not support testing COPY request.' );
                }
                break;
            case 'ezcWebdavMoveRequest':
                if ( $requestObject instanceof ezcWebdavBackendChange )
                {
                    $responseObject = $response['backend']->move( $requestObject );
                }
                else
                {
                    $this->fail( 'Backend does not support testing MOVE request.' );
                }
                break;
            case 'ezcWebdavMakeCollectionRequest':
                if ( $requestObject instanceof ezcWebdavBackendMakeCollection )
                {
                    $responseObject = $response['backend']->makeCollection( $requestObject );
                }
                else
                {
                    $this->fail( 'Backend does not support testing MKCOL request.' );
                }
                break;
            case 'ezcWebdavPutRequest':
                if ( ( $requestObject instanceof ezcWebdavBackendPut ) === false )
                {
                    $responseObject = $response['backend']->put( $requestObject );
                }
                else
                {
                    $this->fail( 'Backend does not support testing PUT request.' );
                }
                break;
            default:
                throw new PHPUnit_Framework_ExpectationFailedException( "Unable to dispatch request of class " . get_class( $requestObject ) );
        }

        $this->assertEquals(
            $response['code'],
            $responseObject->status,
            "Request returned status code '{$responseObject->status}' instead of '{$response['code']}' '{$requestObject->requestUri}'."
        );

        foreach ( $response['headers'] as $headerName => $headerValue )
        {
            // Headers can only be set after XML generation
            if ( $headerName !== 'Content-Type' && $headerName !== 'Content-Length' )
            {
                $this->assertEquals(
                    $headerValue,
                    $responseObject->getHeader( $headerName ),
                    "Header '$headerName' not set to value '$headerValue'."
                );
            }
        }

        return $responseObject;
    }

}

?>
