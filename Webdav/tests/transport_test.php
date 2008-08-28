<?php

libxml_use_internal_errors( true );

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Require mocked version of ezcWebdavPluginConfiguration. 
 */
require_once 'classes/custom_plugin_configuration.php';

class ezcWebdavMockedTransport extends ezcWebdavTransport
{
    public function handleException( Exception $e, $uri = null )
    {
        return parent::handleException( $e, $uri );
    }

    public function flattenResponse( ezcWebdavDisplayInformation $info )
    {
        return parent::flattenResponse( $info );
    }

    public function parseCopyRequest( $path, $body )
    {
        return parent::parseCopyRequest( $path, $body );
    }

    public function parseMoveRequest( $path, $body )
    {
        return parent::parseMoveRequest( $path, $body );
    }

    public function parsePropFindRequest( $path, $body )
    {
        return parent::parsePropFindRequest( $path, $body );
    }

    public function parsePropPatchRequest( $path, $body )
    {
        return parent::parsePropPatchRequest( $path, $body );
    }

    public function processErrorResponse( ezcWebdavErrorResponse $response, $xml = false )
    {
        return parent::processErrorResponse( $response, $xml );
    }
}

class ezcWebdavMockedErrorResponse extends ezcWebdavErrorResponse
{

}

/**
 * Tests for ezcWebdavTransport class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavTransportTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    protected function setUp()
    {
        parent::setUp();
        ezcWebdavServer::getInstance()->init(
            new ezcWebdavBasicPathFactory( 'http://example.com/foo/bar' ),
            new ezcWebdavXmlTool(),
            new ezcWebdavPropertyHandler(),
            new ezcWebdavHeaderHandler(),
            new ezcWebdavMockedTransport()
        );
    }

    protected function tearDown()
    {
        ezcWebdavServer::getInstance()->reset();
        parent::tearDown();
    }

    public function testParseUnknownRequest()
    {
        $_SERVER['DOCUMENT_ROOT']   = '/var/www/localhost/htdocs';
        $_SERVER['HTTP_USER_AGENT'] = 'RFC compliant';
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/localhost/htdocs';
        $_SERVER['SERVER_NAME']     = 'webdav';
        $_SERVER['REQUEST_METHOD']  = 'UNKNOWN';

        $uri = 'http://example.com/foo/bar/baz.html';

        $res = ezcWebdavServer::getInstance()->transport->parseRequest( $uri );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_501,
                $uri
            ),
            $res,
            'Error response not generated on UNKNOWN request method'
        );
    }

    public function testHandleMiscException()
    {
        $e   = new Exception( 'Foo bar' );
        $uri = 'http://example.com/foo/bar/baz.html';
        
        $res = ezcWebdavServer::getInstance()->transport->handleException( $e, $uri );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_500,
                $uri,
                $e->getMessage()
            ),
            $res,
            'Error response not generated when handling unknown exception.'
        );
    }

    public function testHandleUnknownResponse()
    {
        $uri = 'http://example.com/foo/bar/baz.html';
        $response = new ezcWebdavMockedErrorResponse(
            ezcWebdavResponse::STATUS_500,
            $uri,
            'Foo bar'
        );
        
        // Silence warning of headers already been send, but keep other errors
        $errRep = error_reporting( ( E_ALL | E_STRICT ) & ~E_WARNING );
        
        $res = ezcWebdavServer::getInstance()->transport->handleResponse( $response );
        
        // Reset old error level
        error_reporting( $errRep );

        $this->assertNull(
            $res,
            'Result incorrect on handling of completly unknown response.'
        );
    }

    public function testFlattenResponseErrorMissingContentTypeHeader()
    {
        $uri = 'http://example.com/foo/bar/baz.html';
        $info = new ezcWebdavStringDisplayInformation( 
            new ezcWebdavMockedErrorResponse(
                ezcWebdavResponse::STATUS_500,
                $uri
            ),
            'Foo bar'
        );
        $info->response->setHeader( 'Server', 'Foo bar baz server' );
        $info->response->validateHeaders();
        
        try
        {
            $res = ezcWebdavServer::getInstance()->transport->flattenResponse( $info );
            $this->fail(
                'Exception not thrown on missing Content-Type header in string display info.'
            );
        }
        catch ( ezcWebdavMissingHeaderException $e )
        {}
    }

    public function testFlattenResponseErrorContentTypeHeaderTooMuch()
    {
        $uri = 'http://example.com/foo/bar/baz.html';
        $info = new ezcWebdavEmptyDisplayInformation( 
            new ezcWebdavMockedErrorResponse(
                ezcWebdavResponse::STATUS_500,
                $uri
            )
        );
        $info->response->setHeader( 'Server', 'Foo bar baz server' );
        $info->response->setHeader( 'Content-Type', 'text/xml; charset="utf-8"' );
        $info->response->validateHeaders();
        
        try
        {
            $res = ezcWebdavServer::getInstance()->transport->flattenResponse( $info );
            $this->fail(
                'Exception not thrown on missing Content-Type header in string display info.'
            );
        }
        catch ( ezcWebdavInvalidHeaderException $e )
        {}
    }

    public function testParseCopyRequestErrorMissingHeader()
    {
        $path = '/baz.html';
        $body = 'Foo bar baz';

        try
        {
            ezcWebdavServer::getInstance()->transport->parseCopyRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing copy request without destination header.'
            );
        }
        catch ( ezcWebdavMissingHeaderException $e )
        {
            return;    
        }
    }

    public function testParseCopyRequestErrorBodyInvalidXml()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = 'Foo bar baz';
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parseCopyRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing copy request with invalid XML body.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {}
    }
    
    public function testParseCopyRequestErrorMissingPropertyBehaviourTag()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<d:propertymissbehavior xmlns:d="DAV:">
  <d:omit/>
</d:propertymissbehavior>
EOT;
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parseCopyRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing copy request with invalid XML body.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {}
    }

    public function testParseCopyRequestPropertyBehaviourOmitTag()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d="DAV:">
  <d:omit/>
</d:propertybehavior>
EOT;
        
        $res = ezcWebdavServer::getInstance()->transport->parseCopyRequest( $path, $body );

        $this->assertTrue(
            ( $res instanceof ezcWebdavCopyRequest ),
            'Request not parsed correctly: Invalid request class!'
        );

        $this->assertTrue(
            $res->propertyBehaviour->omit,
            'Omit property of response object not set correctly.'
        );
    }

    public function testParseCopyRequestPropertyBehaviourKeepaliveTagWithHrefContent()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d="DAV:">
  <d:keepalive>
      <d:href>some property</d:href>
      <d:href>another property</d:href>
  </d:keepalive>
</d:propertybehavior>
EOT;
        
        $res = ezcWebdavServer::getInstance()->transport->parseCopyRequest( $path, $body );

        $this->assertTrue(
            ( $res instanceof ezcWebdavCopyRequest ),
            'Request not parsed correctly: Invalid request class!'
        );

        $this->assertEquals(
            array(
                'some property',
                'another property',
            ),
            $res->propertyBehaviour->keepAlive,
            'Omit property of response object not set correctly.'
        );
    }

    public function testParseMoveRequestErrorMissingHeader()
    {
        $path = '/baz.html';
        $body = 'Foo bar baz';

        try
        {
            ezcWebdavServer::getInstance()->transport->parseMoveRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing move request without destination header.'
            );
        }
        catch ( ezcWebdavMissingHeaderException $e )
        {
            return;    
        }
    }

    public function testParseMoveRequestErrorBodyInvalidXml()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = 'Foo bar baz';
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parseMoveRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing move request with invalid XML body.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {}
    }
    
    public function testParseMoveRequestErrorMissingPropertyBehaviourTag()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<d:propertymissbehavior xmlns:d="DAV:">
  <d:omit/>
</d:propertymissbehavior>
EOT;
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parseMoveRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing move request with invalid XML body.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {}
    }

    public function testParseMoveRequestPropertyBehaviourOmitTag()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d="DAV:">
  <d:omit/>
</d:propertybehavior>
EOT;
        
        $res = ezcWebdavServer::getInstance()->transport->parseMoveRequest( $path, $body );

        $this->assertTrue(
            ( $res instanceof ezcWebdavMoveRequest ),
            'Request not parsed correctly: Invalid request class!'
        );

        $this->assertTrue(
            $res->propertyBehaviour->omit,
            'Omit property of response object not set correctly.'
        );
    }

    public function testParseMoveRequestPropertyBehaviourKeepaliveTagWithHrefContent()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d="DAV:">
  <d:keepalive>
      <d:href>some property</d:href>
      <d:href>another property</d:href>
  </d:keepalive>
</d:propertybehavior>
EOT;
        
        $res = ezcWebdavServer::getInstance()->transport->parseMoveRequest( $path, $body );

        $this->assertTrue(
            ( $res instanceof ezcWebdavMoveRequest ),
            'Request not parsed correctly: Invalid request class!'
        );

        $this->assertEquals(
            array(
                'some property',
                'another property',
            ),
            $res->propertyBehaviour->keepAlive,
            'Omit property of response object not set correctly.'
        );
    }

    public function testParsePropFindRequestErrorBodyInvalidXml()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = 'Foo bar baz';
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parsePropFindRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing propfind request with invalid XML body.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {
            return;    
        }
    }

    public function testParsePropFindRequestErrorBodyMissingPropFindTag()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:propnotfound xmlns:D="DAV:">
  <D:prop xmlns:R="http://www.foo.bar/boxschema/">
       <R:bigbox/>
       <R:author/>
       <R:DingALing/>
       <R:Random/>
  </D:prop>
</D:propnotfound>
EOT;
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parsePropFindRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing propfind request with invalid XML root element.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {
            return;    
        }
    }

    public function testParsePropFindRequestErrorBodyMissingPropFindTagChildren()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:"/>
EOT;
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parsePropFindRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing propfind request with missing child tags for the propfind XML element.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {
            return;    
        }
    }

    public function testParsePropPatchRequestErrorBodyInvalidXml()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = 'Foo bar baz';
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parsePropPatchRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing propfind request with invalid XML body.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {
            return;    
        }
    }

    public function testParsePropPatchRequestErrorBodyMissingPropertyUpdateTag()
    {
        $_SERVER['HTTP_DESTINATION'] = '/foo/bar/baz.html';

        $path = '/baz.html';
        $body = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:propertydowndate xmlns:D="DAV:"
xmlns:Z="http://www.w3.com/standards/z39.50/">
  <D:set>
       <D:prop>
            <Z:authors>
                 <Z:Author>Jim Whitehead</Z:Author>
                 <Z:Author>Roy Fielding</Z:Author>
            </Z:authors>
       </D:prop>
  </D:set>
  <D:remove>
       <D:prop><Z:Copyright-Owner/></D:prop>
  </D:remove>
</D:propertydowndate>
EOT;
        
        try
        {
            ezcWebdavServer::getInstance()->transport->parsePropPatchRequest( $path, $body );
            $this->fail(
                'Exception not thrown on parsing propfind request with invalid XML root element.'
            );
        }
        catch ( ezcWebdavInvalidRequestBodyException $e )
        {
            return;    
        }
    }

    public function testProcessErrorResponseWithResponseDescription()
    {
        $uri = 'http://example.com/foo/bar/baz.html';
        $response = new ezcWebdavErrorResponse(
            ezcWebdavResponse::STATUS_500,
            $uri,
            'Some error occured!'
        );
        
        $res = ezcWebdavServer::getInstance()->transport->processErrorResponse( $response, true );

        $this->assertTrue(
            ( $res instanceof ezcWebdavXmlDisplayInformation ),
            'Response not processed correctly: Invalid display information class!'
        );
        
        $nodelist = $res->body->getElementsByTagNameNS( 'DAV:', 'responsedescription' );
        $this->assertEquals(
            1,
            $nodelist->length,
            'No responsedescripion tag generated.'
        );

        $this->assertEquals(
            $response->responseDescription,
            $nodelist->item( 0 )->nodeValue,
            'Response description content not generated correctly.'
        );
    }
}

?>
