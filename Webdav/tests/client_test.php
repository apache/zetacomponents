<?php

libxml_use_internal_errors( true );

abstract class ezcWebdavClientTest extends ezcTestCase
{
    const REGENERATE_REQUEST  = false;
    const REGENERATE_RESPONSE = false;

    protected $setupClass;

    public $dataDir;
    
    public $transport;

    public $backend;

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
        call_user_func( array( $this->setupClass, 'performSetup' ), $this, basename( $testSetName ) );

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
            $response['backend'] = $this->getFileContent( $responseDir, 'backend' );
            
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
                $fileContent = @unserialize( file_get_contents( $filePath ) );
                break;
            case 'txt':
            default:
                $fileContent = trim( file_get_contents( $filePath ) );
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

        if ( $request['result'] === false && self::REGENERATE_REQUEST === true )
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
        $responseObject = $this->backend->performRequest( $requestObject );
        
        $this->transport->handleResponse( $responseObject );
        $responseBody    = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'];
        $responseHeaders = $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'];


        if ( $response['result'] === false )
        {
            if ( self::REGENERATE_RESPONSE )
            {
                // Regenerate
                file_put_contents(
                    "{$this->currentTestSet}/response/result.ser",
                    serialize( array( "headers" => $responseHeaders, "body" => $responseBody ) )
                );
                file_put_contents(
                    "{$this->currentTestSet}/response/backend.ser",
                    serialize( $this->backend )
                );
            }
            if ( isset( $response['body'] ) === false || trim( $response['body'] ) === '' || $responseBody === '' )
            {
                $this->assertEquals(
                    $response['body'],
                    $responseBody,
                    'Response body not generated correctly.'
                );
            }
            else
            {
                $this->assertXmlStringEqualsXmlString(
                    $response['body'],
                    $responseBody,
                    'Response body not generated correctly.'
                );
            }
            if ( isset( $response['backend'] ) && $response['backend'] !== false )
            {
                $this->assertEquals(
                    $response['backend'],
                    $this->backend,
                    'Backend state missmatched.'
                );
            }
        } 
        else
        {
            $this->assertEquals(
                $response['result']['headers'],
                $responseHeaders,
                'Generated headers missmatch.'
            );
            if ( trim( $response['result']['body'] ) === '' || $responseBody === '' )
            {
                $this->assertEquals(
                    $response['result']['body'],
                    $responseBody,
                    'Generated body missmatch.'
                );
            }
            else
            {
                $this->assertXmlStringEqualsXmlString(
                    $response['result']['body'],
                    $responseBody,
                    'Generated body missmatch.'
                );
            }
        }
        if ( self::REGENERATE_RESPONSE )
        {
            // Regenerate new backend file
            file_put_contents(
                "{$this->currentTestSet}/response/backend.ser",
                serialize( $this->backend )
            );
        }

        $this->assertEquals(
            $response['code'],
            $responseObject->status,
            'Response code missmatch'
        );

        $this->assertEquals(
            $response['name'],
            ezcWebdavResponse::$errorNames[$responseObject->status],
            'Response name missmatch'
        );

        return $responseObject;
    }

}

?>
