<?php
/**
 * File containing the basic standard compliant transport mecanism.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Handler class that handles parsing of requests and handling of responses.
 *
 * This basic implementation handles requests and responses as defined in RFC
 * 2518 and should be extended for misbehaving clients.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavTransport
{
    /**
     * Regedx to parse the <getcontenttype /> XML elemens content.
     *
     * Example: 'text/html; charset=UTF-8'
     */
    const GETCONTENTTYPE_REGEX = '(^(?P<mime>\w+/\w+)\s*;\s*charset\s*=\s*(?P<charset>.+)\s*$)i';

    /**
     * Map of regular header names to $_SERVER keys.
     *
     * @var array(string=>string)
     */
    static protected $headerMap = array(
        'Depth'          => 'HTTP_DEPTH',
        'Destination'    => 'HTTP_DESTINATION',
        'Overwrite'      => 'HTTP_OVERWRITE',
        'Timeout'        => 'HTTP_TIMEOUT',
        'Lock-Token'     => 'HTTP_LOCK_TOKEN',
        'Content-Length' => 'HTTP_CONTENT_LENGTH',
        'Content-Type'   => 'CONTENT_TYPE',
    );

    /**
     * Map of HTTP methods to object method names for parsing.
     *
     * @var array(string=>string)
     */
    static protected $parsingMap = array(
        'COPY'      => 'parseCopyRequest',
        'DELETE'    => 'parseDeleteRequest',
        'GET'       => 'parseGetRequest',
        'HEAD'      => 'parseHeadRequest',
        'LOCK'      => 'parseLockRequest',
        'MKCOL'     => 'parseMakeCollectionRequest',
        'MOVE'      => 'parseMoveRequest',
        'OPTIONS'   => 'parseOptionsRequest',
        'PROPFIND'  => 'parsePropFindRequest',
        'PROPPATCH' => 'parsePropPatchRequest',
        'PUT'       => 'parsePutRequest',
        'UNLOCK'    => 'parseUnlockRequest',
    );

    /**
     * Map of response objects to handling methods.
     *
     * @array(string=>string)
     */
    static protected $handlingMap = array(
        'ezcWebdavPropFindResponse'       => 'processPropFindResponse',
        'ezcWebdavMultistatusResponse'    => 'processMultiStatusResponse',
        'ezcWebdavCopyResponse'           => 'processCopyResponse',
        'ezcWebdavDeleteResponse'         => 'processDeleteResponse',
        'ezcWebdavErrorResponse'          => 'processErrorResponse',
        'ezcWebdavGetCollectionResponse'  => 'processGetCollectionResponse',
        'ezcWebdavGetResourceResponse'    => 'processGetResourceResponse',
        'ezcWebdavOptionsResponse'        => 'processOptionsResponse',
        'ezcWebdavPropPatchResponse'      => 'processPropPatchResponse',
        'ezcWebdavHeadResponse'           => 'processHeadResponse',
        'ezcWebdavMakeCollectionResponse' => 'processMakeCollectionResponse',
        'ezcWebdavMoveResponse'           => 'processMoveResponse',
        'ezcWebdavPutResponse'            => 'processPutResponse',
    );

    /**
     * Properties.
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Creates a new transport object.
     *
     * The transport object will make use of the submitted $options or create a
     * default {@link ezcWebdavTransportOptions} object for use. You can access
     * and change the option at any time through the {@link $optiosn} property.
     *
     * The methods {@link $this->parseRequest()} and {@
     * $this->handleResponse()} are called by {@link ezcWebdavServer to perform
     * the specific operations.
     * 
     * @param ezcWebdavTransportOptions $options 
     * @return void
     */
    public function __construct( ezcWebdavXmlTool $xml = null, ezcWebdavTransportOptions $options = null )
    {
        $this->properties['xml']     = ( $xml === null     ? new ezcWebdavXmlTool()          : $xml );
        $this->properties['options'] = ( $options === null ? new ezcWebdavTransportOptions() : $options );
    }

    /**
     * Parses the incoming request into a fitting request abstraction object.
     *
     * This method is the main entry point of {@link ezcWebdavServer} and is
     * utilized by it to parse the incoming request into an instance of {@link
     * ezcWebdavRequest}.
     *
     * The submitted URI must be formatted in a way, that the {@link
     * ezcWebdavBasicPathFactory} (by default this is {@link
     * ezcWebdavAutomaticPathFactory}) set in the {@link
     * ezcWebdavTransportOptions $pathFactory} option can convert it into a
     * path absolute to the WebDAV repository.
     *
     * The retrieval of the request body is performed by the {@link
     * retreiveBody()} method, the request method from {@link
     * $_SERVER['REQUEST_METHOD']}. The latter one is mapped through the
     * {self::$parsingMap} attribute to a local object method.
     *
     * @return ezcWebdavRequest
     *
     * @throws ezcWebdavInvalidRequestBodyException
     *         if the request method in {@link $_SERVER} was not found in
     *         {@link self::$parsingMap}.
     *
     * @todo TS: I made this final for now and made it dispatch to protected
     * methods for its special operations. This way we can ensure that the
     * server API stays stable across extended transports.
     */
    public final function parseRequest( $uri )
    {
        $body = $this->retreiveBody();
        $path = $this->options->pathFactory->parseUriToPath( $uri );

        if ( isset( self::$parsingMap[$_SERVER['REQUEST_METHOD']] ) === false )
        {
            throw new ezcWebdavInvalidRequestMethodException(
                $_SERVER['REQUEST_METHOD']
            );
        }
        return call_user_func( array( $this, self::$parsingMap[$_SERVER['REQUEST_METHOD']] ), $path, $body );
    }

    /**
     * Handle a response and send it to the browser.
     * This method is part of the integral communication between the client and
     * the {@link ezcWebdavServer}. It is declared final to ensure a minimal
     * compatibile API between the extended classes.
     *
     * It currently just maps internally to {@link processResponse()} and
     * passes the result to {@ sendResponse()}. It is not recommended that the
     * {@link processResponse()} method is overwritten, because this one takes
     * care about the dispatching. The {@link sendResponse()} may be
     * overwritten, mainly for debugging, testing and logging purposes.
     * 
     * @param ezcWebdavResponse $response
     * @return void
     */
    public final function handleResponse( ezcWebdavResponse $response )
    {
        $this->sendResponse( $this->processResponse( $response ) );
    }

    /**
     * Returns the body content of the request.
     *
     * This method mainly exists for unittesting purpose. It reads the request
     * body and returns the contents as a string. This method can also be
     * usefull to override in cases of strange web severs.
     * 
     * @return string
     */
    protected function retreiveBody()
    {
        $body = '';
        $in   = fopen( 'php://input', 'r' );

        while ( $data = fread( $in, 1024 ) )
        {
            $body .= $data;
        }
        return $body;
    }

    /**
     * Serializes a response object to XML.
     * This method performs the internal dispatching of a given $response
     * object. It determines the method to handle the response by {@link
     * self::$handlingMap} and throws an Exception if the given class could not
     * be dispatched.
     *
     * It is not recommend to overwrite this method in derived classes, since
     * this contains the elemental dispatching algorithm for response classes
     * and might change in future. It is therefore marked private.
     * 
     * @private
     *
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavDisplayInformation
     *
     * @throws RuntimeException
     *         if the class of the given object could not be dispatched.
     *
     * @todo Correct exception. Or better: Correct all exception mess!
     */
    protected function processResponse( ezcWebdavResponse $response )
    {
        if ( isset( self::$handlingMap[( $responseClass = get_class( $response ) )] ) === false )
        {
            throw new RuntimeException( "Serialization of class $responseClass not implemented, yet." );
        }
        return call_user_func( array( $this, self::$handlingMap[( $responseClass = get_class( $response ) )] ), $response );
    }

    /**
     * Finally send out the response.
     *
     * This method is called to finally send the response to the browser. It
     * can be overwritten in test cases to change the behaviour of printing out
     * the result and sending the headers. The method automatically generates an
     * appropriate Content-Type header for XML output, if a DOMDocument is received in
     * ezcWebdavDisplayInformation. A header existent in the response object
     * will not be affected and the method will silently go on.
     *
     * If the {@link ezcWebdavDisplayInformation::$body} property is a string,
     * correct setting of the Content-Type header is checked and an {@link
     * ezcWebdavMissingHeaderException} is thrown in negative case {@link
     * ezcWebdavMissingHeaderException} is thrown in negative case.
     *
     * If a null body is received, the method checks if Content-Type and
     * Content-Length headers are not present, so they are not excplicitly send
     * later on.
     * 
     * @param ezcWebdavDisplayInformation $info
     * @return void
     *
     * @todo ezcWebdavDisplayInformation should be refactored to have
     *       subclasses for the different content types (DOMDOcument, null,
     *       string).
     */
    protected function sendResponse( ezcWebdavDisplayInformation $info )
    {
        switch ( true )
        {
            case ( $info->body instanceof DOMDocument ):
                $info->body->formatOutput = true;
                // Explicitly set txt/xml content type
                if ( $info->response->getHeader( 'Content-Type' ) === null )
                {
                    $info->response->setHeader( 'Content-Type', 'text/xml; charset="utf-8"' );
                }
                $result = $info->body->saveXML( $info->body );
                break;
                
            case ( is_string( $info->body ) ):
                if ( $info->response->getHeader( 'Content-Type' ) === null )
                {
                    throw new ezcWebdavMissingHeaderException( 'ContentType' );
                }
                $result = $info->body;
                break;
            case ( $info->body === null ):

            default:
                if ( ( $contenTypeHeader = $info->response->getHeader( 'Content-Type' ) ) !== null  )
                {
                    throw new ezcWebdavInvalidHeaderException( 'Content-Type', $contenTypeHeader, 'null' );
                }
                if ( ( $contenLengthHeader = $info->response->getHeader( 'Content-Length' ) ) !== null  )
                {
                    throw new ezcWebdavInvalidHeaderException( 'Content-Length', $contenLengthHeader, 'null' );
                }
                $result = null;
                break;
        }
        
        // Sends HTTP response code and description, 3rd param forces status
        header( (string) $info->response, true, (int) $info->response->status );

        // Send headers defined by response
        $headers = $info->response->getHeaders();
        foreach ( $headers as $name => $value )
        {
            header( "{$name}: {$value}" );
        }

        if ( $result !== null )
        {
            // Content-Length header automatically send
            echo $result;
        }
    }

    /**
     * Returns an array with the given headers.
     * Checks for the availability of headers in $headerNamess, given as an array
     * of header names, and parses them according to their format. 
     *
     * The returned array can be used with {@link ezcWebdavRequest->setHeaders()}.
     * 
     * @param array(string) $headerNames 
     * @return array(string=>mixed)
     */
    protected function parseHeaders( array $headerNames )
    {
        $resultHeaders = array();
        foreach ( $headerNames as $headerName )
        {
            if ( isset( self::$headerMap[$headerName] ) === false )
            {
                throw new ezcWebdavUnknownHeaderException( $headerName );
            }
            if ( isset( $_SERVER[self::$headerMap[$headerName]] ) )
            {
                $resultHeaders[$headerName] = $this->parseHeader( $headerName, $_SERVER[self::$headerMap[$headerName]] );
            }
        }
        return $resultHeaders;
    }

    /**
     * Prases a single header.
     * Takes the $headerName and $value of a header and parses the value accordingly,
     * if necessary. Returns the parsed or unmanipuled result.
     * 
     * @param string $headerName 
     * @param string $value 
     * @return mixed
     */
    protected function parseHeader( $headerName, $value )
    {
        switch ( $headerName )
        {
            case 'Depth':
                switch ( trim( $value ) )
                {
                    case '0':
                        $value = ezcWebdavRequest::DEPTH_ZERO;
                        break;
                    case '1':
                        $value = ezcWebdavRequest::DEPTH_ONE;
                        break;
                    case 'infinity':
                        $value = ezcWebdavRequest::DEPTH_INFINITY;
                        break;
                    // No default. Header stays as is, if not matched
                }
                break;
            case 'Destination':
                $value = $this->options->pathFactory->parseUriToPath( $value );
                break;
            default:
                // @TODO Add extensiability hook
        }
        return $value;
    }

    // GET

    /**
     * Parses the GET request and returns a request object.
     * This method is responsible for parsing the GET request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavGet} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavGetRequest
     */
    protected function parseGetRequest( $path, $body )
    {
        return new ezcWebdavGetRequest( $path );
    }

    // PUT

    /**
     * Parses the PUT request and returns a request object.
     * This method is responsible for parsing the PUT request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavPut} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavPutRequest
     */
    protected function parsePutRequest( $path, $body )
    {
        $req = new ezcWebdavPutRequest( $path, $body );
        $req->setHeaders(
            $this->parseHeaders(
                array(
                    'Content-Length', 'Content-Type'
                )
            )
        );
        return $req;
    }

    // HEAD

    /**
     * Parses the HEAD request and returns a request object.
     * This method is responsible for parsing the HEAD request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavHead} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavHeadRequest
     */
    protected function parseHeadRequest( $path, $body )
    {
        return new ezcWebdavHeadRequest( $path );
    }

    // COPY

    /**
     * Parses the COPY request and returns a request object.
     * This method is responsible for parsing the COPY request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavCopyRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavCopyRequest
     */
    protected function parseCopyRequest( $path, $body )
    {
        $headers = $this->parseHeaders(
            array( 'Destination', 'Depth', 'Overwrite' )
        );

        $request = new ezcWebdavCopyRequest( $path, $headers['Destination'] );

        $request->setHeaders( $headers );

        if ( trim( $body ) === '' )
        {
            // No body present
            return $request;
        }

        if ( ( $dom = $this->xml->createDomDocument( $body ) ) === false )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'COPY',
                "Could not open XML as DOMDocument: '{$body}'."
            );
        }
        
        if ( $dom->documentElement->localName !== 'propertybehavior' )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'COPY',
                "Expected XML element <propertybehavior />, received <{$dom->documentElement->localName} />."
            );
        }
        
        return $this->parsePropertyBehaviourContent( $dom, $request );
    }

    // MOVE

    /**
     * Parses the MOVE request and returns a request object.
     * This method is responsible for parsing the MOVE request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavMoveRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavMoveRequest
     */
    protected function parseMoveRequest( $path, $body )
    {
        $headers = $this->parseHeaders(
            array( 'Destination', 'Depth', 'Overwrite' )
        );

        $request = new ezcWebdavMoveRequest( $path, $headers['Destination'] );

        $request->setHeaders( $headers );

        if ( trim( $body ) === '' )
        {
            // No body present
            return $request;
        }

        if ( ( $dom = $this->xml->createDomDocument( $body ) ) === false )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'MOVE',
                "Could not open XML as DOMDocument: '{$body}'."
            );
        }
        
        if ( $dom->documentElement->localName !== 'propertybehavior' )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'MOVE',
                "Expected XML element <propertybehavior />, received <{$dom->documentElement->localName} />."
            );
        }
        
        return $this->parsePropertyBehaviourContent( $dom, $request );
    }

    /**
     * Parses the <propertybehavior /> XML element. 
     * 
     * @param DOMDocument $dom 
     * @param ezcWebdavRequest $request 
     * @return ezcWebdavRequest
     */
    protected function parsePropertyBehaviourContent( DOMDocument $dom, ezcWebdavRequest $request )
    {
        $propertyBehaviourNode = $dom->documentElement;

        $request->propertyBehaviour = new ezcWebdavRequestPropertyBehaviourContent();
        switch ( $propertyBehaviourNode->firstChild->localName )
        {
            case 'omit':
                $request->propertyBehavior->omit = true;
                break;
            case 'keepalive':
                if ( $propertyBehaviourNode->firstChild->nodeValue === '*' )
                {
                    $request->propertyBehaviour->keepAlive = ezcWebdavRequestPropertyBehaviourContent::ALL;
                }
                else
                {
                    $keepAliveContent = array();
                    $hrefNodes        = $propertyBehaviourNode->firstChild->getElementsByTagName( 'href' );

                    for ( $i = 0; $i < $hrefNodes->length; ++$i )
                    {
                        $keepAliveContent[] = $hrefNodes->item( $i )->nodeValue;
                    }

                    $request->propertyBehaviour->keepAlive = $keepAliveContent;
                }
        }
        return $request;
    }
    
    // DELETE

    /**
     * Parses the DELETE request and returns a request object.
     * This method is responsible for parsing the DELETE request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavDeleteRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavDeleteRequest
     */
    protected function parseDeleteRequest( $path, $body )
    {
        return new ezcWebdavDeleteRequest( $path );
    }
    
    // LOCK

    /**
     * Parses the LOCK request and returns a request object.
     * This method is responsible for parsing the LOCK request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavLockRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavLockRequest
     */
    protected function parseLockRequest( $path, $body )
    {
        $request = new ezcWebdavLockRequest( $path );

        $request->setHeaders(
            $this->parseHeaders(
                array( 'Depth', 'Timeout' )
            )
        );

        if ( trim( $body ) === '' )
        {
            return $request;
        }

        if ( ( $dom = $this->xml->createDomDocument( $body ) ) === false )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Could not open XML as DOMDocument: '{$body}'."
            );
        }
        
        if ( $dom->documentElement->localName !== 'lockinfo' )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Expected XML element <lockinfo />, received <{$dom->documentElement->localName} />."
            );
        }

        $lockTypeElements  = $dom->documentElement->getElementsByTagnameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'locktype' );
        $lockScopeElements = $dom->documentElement->getElementsByTagnameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'lockscope' );
        $ownerElements     = $dom->documentElement->getElementsByTagnameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'owner' );

        if ( $lockTypeElements->length === 0 )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Expected XML element <locktype /> as child of <lockinfo /> in namespace DAV: which was not found."
            );
        }
        if ( $lockScopeElements->length === 0 )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Expected XML element <lockscope /> as child of <lockinfo /> in namespace DAV: which was not found."
            );
        }

        // @TODO is the following not restrictive enough?
        $request->lockInfo = new ezcWebdavRequestLockInfoContent(
            ( $lockScopeElements->item( 0 )->firstChild->localName === 'exclusive'
                ? ezcWebdavLockRequest::SCOPE_EXCLUSIVE
                : ezcWebdavLockRequest::SCOPE_SHARED ),
            ( $lockTypeElements->item( 0 )->firstChild->localName === 'read'
                ? ezcWebdavLockRequest::TYPE_READ
                : ezcWebdavLockRequest::TYPE_WRITE ),
            ( $ownerElements->length > 0 
                ? $ownerElements->item( 0 )->textContent
                : null )
        );

        return $request;
    }
    
    // UNLOCK

    /**
     * Parses the UNLOCK request and returns a request object.
     * This method is responsible for parsing the UNLOCK request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavUnlockRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavUnlockRequest
     */
    protected function parseUnlockRequest( $path, $body )
    {
        $request = new ezcWebdavUnlockRequest( $path );

        $request->setHeaders(
            $this->parseHeaders(
                array( 'Lock-Token' )
            )
        );

        return $request;
    }

    // MKCOL

    /**
     * Parses the MKCOL request and returns a request object.
     * This method is responsible for parsing the MKCOL request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavMakeCollectionRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavMakeCollectionRequest
     */
    protected function parseMakeCollectionRequest( $path, $body )
    {
        return new ezcWebdavMakeCollectionRequest( $path, ( trim( $body ) === '' ? null : $body ) );
    }
    
    // OPTIONS

    /**
     * Parses the OPTIONS request and returns a request object.
     * This method is responsible for parsing the OPTIONS request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavOptionsRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavOptionsRequest
     */
    protected function parseOptionsRequest( $path, $body )
    {
        return new ezcWebdavOptionsRequest( $path, ( trim( $body ) === '' ? null : $body ) );
    }

    // PROPFIND

    /**
     * Parses the PROPFIND request and returns a request object.
     * This method is responsible for parsing the PROPFIND request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavPropFindRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavPropFindRequest
     */
    protected function parsePropFindRequest( $path, $body )
    {
        $request = new ezcWebdavPropFindRequest( $path );

        $request->setHeaders(
            $this->parseHeaders(
                array( 'Depth' )
            )
        );

        if ( ( $dom = $this->xml->createDomDocument( $body ) ) === false )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'PROPFIND',
                "Could not open XML as DOMDocument: '{$body}'."
            );
        }

        if ( $dom->documentElement->localName !== 'propfind' )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'PROPFIND',
                "Expected XML element <propfind />, received <{$dom->documentElement->localName} />."
            );
        }
        if ( $dom->documentElement->firstChild === null )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'PROPFIND',
                "Element <propfind /> does not have a child element."
            );
        }

        switch ( $dom->documentElement->firstChild->localName )
        {
            case 'allprop':
                $request->allProp = true;
                break;
            case 'propname':
                $request->propName = true;
                break;
            case 'prop':
                $request->prop = new ezcWebdavBasicPropertyStorage();
                $this->extractProperties(
                    $dom->documentElement->firstChild->childNodes,
                    $request->prop
                );
                break;
            default:
                throw new ezcWebdavInvalidRequestBodyException(
                    'PROPFIND',
                    "XML element <{$dom->documentElement->firstChild->tagName} /> is not a valid child element for <propfind />."
                );
        }
        return $request;
    }
    

    /**
     * Returns extracted properties in an new ezcWebdavBasicPropertyStorage.
     * This method receives a DOMNodeList $domNodes, which must contain a set
     * of DOMElement objects, while each of those represents a WebDAV property.
     * The list may contain live properties as well as dead ones. Live
     * properties as defined in RFC 2518 are currently recognized. All other
     * properties in the DAV: namespace are silently ignored. Dead properties
     * are parsed. The properties are stored in the given {@link
     * new ezcWebdavBasicPropertyStorage} $storage. If a $flag value is provided, this
     * one is submitted as the second parameter to
     * new ezcWebdavBasicPropertyStorage->attach() ({@link
     * ezcWebdavFlaggedPropertyStorage}).
     * 
     * @param DOMNodeList $domNodes 
     * @param new ezcWebdavBasicPropertyStorage $storage
     * @param int $flag
     * @return new ezcWebdavBasicPropertyStorage
     */
    protected function extractProperties( DOMNodeList $domNodes, ezcWebdavBasicPropertyStorage $storage, $flag = null )
    {
        for ( $i = 0; $i < $domNodes->length; ++$i )
        {
            $currentNode = $domNodes->item( $i );
            if ( $currentNode->nodeType !== XML_ELEMENT_NODE )
            {
                // Skip
                continue;
            }
            
            // DAV: namespace indicates live property!
            // Other RFCs allready intruded into this namespace, as 3253 does.
            if ( $currentNode->namespaceURI === ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE )
            {
                $property = $this->extractLiveProperty( $currentNode );
                // In case we don't know the property, we currently ignore it!
                if ( $property !== null )
                {
                    $flag === null ? $storage->attach( $property ) : $storage->attach( $property, $flag );
                }
            }
            
            // Other namespaces are always dead properties
            else
            {
                $property = $this->extractDeadProperty( $currentNode );
                $flag === null ? $storage->attach( $property ) : $storage->attach( $property, $flag );
            }
        }
        return $storage;
    }

    /**
     * Extract a dead property from a DOMElement.
     * This method is responsible for parsing a {@link ezcWebdavDeadProperty}
     * (unknown) property from a DOMElement.
     * 
     * @param DOMElement $domElement 
     * @return ezcWebdavDeadProperty
     * @todo How do we need to take care about different namespaces here?
     */
    protected function extractDeadProperty( DOMElement $domElement )
    {
        // Create standalone XML for property
        // It may possibly occur, that shortcut clashes occur...
        $propDom    = new DOMDocument();
        $copiedNode = $propDom->importNode( $domElement, true );
        $propDom->appendChild( $copiedNode );
        
        return new ezcWebdavDeadProperty(
            $domElement->namespaceURI,
            $domElement->localName,
            $propDom->saveXML()
        );
    }

    /**
     * Extracts a live property from a DOMElement.
     * This method is responsible for parsing WebDAV live properties. The
     * DOMElement $domElement must be an XML element in the DAV: namepsace. If
     * the received property is not defined in RFC 2518, null is returned.
     * 
     * @param DOMElement $domElement 
     * @return ezcWebdavLiveProperty|null
     */
    protected function extractLiveProperty( DOMElement $domElement )
    {
        switch ( $domElement->localName )
        {
            case 'creationdate':
                $property = new ezcWebdavCreationDateProperty();
                if ( empty( $domElement->nodeValue ) === false )
                {
                    $property->date = new ezcWebdavDateTime( $domElement->nodeValue );
                }
                break;
            case 'displayname':
                $property = new ezcWebdavDisplayNameProperty();
                if ( empty( $domElement->nodeValue ) === false )
                {
                    $property->displayName = $domElement->nodeValue;
                }
                break;
            case 'getcontentlanguage':
                $property = new ezcWebdavGetContentLanguageProperty();
                if ( empty( $domElement->nodeValue ) === false )
                {
                    // e.g. 'de, en'
                    $property->displayName = array_map( 'trim', explode( ',', $domElement->nodeValue ) );
                }
                break;
            case 'getcontentlength':
                $property = new ezcWebdavGetContentLengthProperty();
                if ( empty( $domElement->nodeValue ) === false )
                {
                    $property->length = trim( $domElement->nodeValue );
                }
                break;
            case 'getcontenttype':
                $property = new ezcWebdavGetContentTypeProperty();
                // @TODO: Should this throw an exception, if the match fails?
                // Currently, the property stays empty and the backend needs to handle this
                if ( empty( $domElement->nodeValue ) === false 
                  && preg_match( self::GETCONTENTTYPE_REGEX, $domElement->nodeValue, $matches ) > 0 )
                {
                    $property->mime    = $matches['mime'];
                    $property->charset = $matches['charset'];
                }
                break;
            case 'getetag':
                $property = new ezcWebdavGetEtagProperty();
                if ( empty( $domElement->nodeValue ) === false )
                {
                    $property->etag = $domElement->nodeValue;
                }
                break;
            case 'getlastmodified':
                $property = new ezcWebdavGetLastModifiedProperty();
                if ( empty( $domElement->nodeValue ) === false )
                {
                    $property->date = new ezcWebdavDateTime( $domElement->nodeValue );
                }
                break;
            case 'lockdiscovery':
                $property = new ezcWebdavLockDiscoveryProperty();
                if ( $domElement->hasChildNodes() === true )
                {
                    $property->activeLock = $this->extractActiveLockContent( $domElement );
                }
                break;
            case 'resourcetype':
                $property = new ezcWebdavResourceTypeProperty();
                if ( empty( $domElement->nodeValue ) === false )
                {
                    $property->type = $domElement->nodeValue;
                }
                break;
            case 'source':
                $property = new ezcWebdavSourceProperty();
                if ( $domElement->hasChildNodes() === true )
                {
                    $property->links = $this->extractLinkContent( $domElement );
                }
                break;
            case 'supportedlock':
                $property = new ezcWebdavSupportedLockProperty();
                if ( $domElement->hasChildNodes() === true )
                {
                    $property->links = $this->extractLockEntryContent( $domElement );
                }
                break;
            default:
                // @TODO Implement extension plugins
                // Currently just ignore
                $property = $this->extractDeadProperty( $domElement );
        }
        return $property;
    }

    /**
     * Extracts the <activelock /> XML elements.
     * This method extracts the <activelock /> XML elements from the
     * <lockdiscovery /> element and returns the corresponding
     * ezcWebdavLockDiscoveryPropertyActiveLock object to be used as the
     * content of ezcWebdavLockDiscoveryProperty.
     * 
     * @param DOMElement $domElement 
     * @return ezcWebdavLockDiscoveryPropertyActiveLock
     */
    protected function extractActiveLockContent( DOMElement $domElement )
    {
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        $activelockElement = $domElement->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'activelock' )->item( 0 );
        for ( $i = 0; $i < $activelockElement->childNodes->length; ++$i )
        {
            if ( ( ( $currentElement = $activelockElement->childNodes->item( $i ) ) instanceof DOMElement ) === false )
            {
                // Skip non element children
                continue;
            }
            switch ( $currentElement->localName )
            {
                case 'locktype':
                    if ( $currentElement->hasChildren && $currentElement->firstChild->localName !== 'write' )
                    {
                        $activelock->lockType = ezcWebdavLockRequest::TYPE_READ;
                    }
                    else
                    {
                        $activelock->lockType = ezcWebdavLockRequest::TYPE_WRITE;
                    }
                    break;
                case 'lockscope':
                    if ( $currentElement->hasChildren )
                    {
                        switch ( $currentElement->firstChild->localName )
                        {
                            case 'exclusive':
                                $activelock->lockScope = ezcWebdavLockRequest::SCOPE_EXCLUSIVE;
                                break;
                            case 'shared':
                                $activelock->lockScope = ezcWebdavLockRequest::SCOPE_SHARED;
                                break;
                        }
                    }
                    break;
                case 'depth':
                    switch ( trim( $currentElement->nodeValue ) )
                    {
                        case '0':
                            $activelock->depth = ezcWebdavRequest::DEPTH_ZERO;
                            break;
                        case '1':
                            $activelock->depth = ezcWebdavRequest::DEPTH_ONE;
                            break;
                        case 'infinity':
                            $activelock->depth = ezcWebdavRequest::DEPTH_INFINITY;
                            break;
                    }
                    break;
                case 'owner':
                    // Ignore <href /> element by intention!
                    $activelock->owner = $currentElement->textContent;
                    break;
                case 'timeout':
                    // @TODO Need to check for special values here!
                    $activelock->timeout = new ezcWebdavDateTime( $currentElement->nodeValue );
                    break;
                case 'locktoken':
                    for ( $i = 0; $i < $currentElement->childNodes->length; ++$i )
                    {
                        $activelock->tokens[] = trim( $currentElement->childNodes->item( $i )->textContent );
                    }
                    break;
            }
        }
        return $activelock;
    }

    /**
     * Extracts the <link /> XML elements.
     * This method extracts the <link /> XML elements from the <source />
     * element and returns the corresponding ezcWebdavSourcePropertyLink object
     * to be used as the content of ezcWebdavSourceProperty.
     * 
     * @param DOMElement $domElement 
     * @return ezcWebdavSourcePropertyLink
     */
    protected function extractLinkContent( DOMElement $domElement )
    {
        $links = array();

        $linkElements = $domElement->getElementsByTagNameNS(
            ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'link'
        );
        for ( $i = 0; $i < $linkElements->length; ++$i )
        {
            $links[] = new ezcWebdavSourcePropertyLink(
                $linkElements->item( $i )->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'src' )->nodeValue,
                $linkElements->item( $i )->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'dst' )->nodeValue
            );
        }
        return $links;
    }
    
    /**
     * Extracts the <lockentry /> XML elements.
     * This method extracts the <lockentry /> XML elements from the <supportedlock />
     * element and returns the corresponding
     * ezcWebdavSupportedLockPropertyLockentry object to be used as the content
     * of ezcWebdavSupportedLockProperty.
     * 
     * @param DOMElement $domElement 
     * @return ezcWebdavSupportedLockProperty
     */
    protected function extractLockEntryContent( DOMElement $domElement )
    {
        $lockEntries = array();

        $lockEntryElements = $domElement->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'lockentry' );
        for ( $i = 0; $i < $lockEntryElements->length; ++$i )
        {
            $lockEntries[] = new ezcWebdavSupportedLockPropertyLockentry(
                ( $lockEntryElements->item( $i )->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'locktype' )->item( 0 )->localname === 'write'
                    ? ezcWebdavLockRequest::TYPE_WRITE : ezcWebdavLockRequest::TYPE_READ ),
                ( $lockEntryElements->item( $i )->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'lockscope' )->item( 0 )->localname === 'shared'
                    ? ezcWebdavLockRequest::SCOPE_SHARED : ezcWebdavLockRequest::SCOPE_EXCLUSIVE )
            );
        }
        return $lockEntries;
    }
    
    // PROPPATCH

    /**
     * Parses the PROPPATCH request and returns a request object.
     * This method is responsible for parsing the PROPPATCH request. It
     * retrieves the current request URI in $path and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavPropPatchRequest} object.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavPropPatchRequest
     */
    protected function parsePropPatchRequest( $path, $body )
    {
        $request = new ezcWebdavPropPatchRequest( $path );

        if ( ( $dom = $this->xml->createDomDocument( $body ) ) === false )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'PROPPATCH',
                "Could not open XML as DOMDocument: '{$body}'."
            );
        }

        if ( $dom->documentElement->localName !== 'propertyupdate' )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'PROPPATCH',
                "Expected XML element <propertyupdate />, received <{$dom->documentElement->localName} />."
            );
        }

        $setElements    = $dom->documentElement->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'set' );
        $removeElements = $dom->documentElement->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'remove' );
        
        for ( $i = 0; $i < $setElements->length; ++$i )
        {
            $this->extractProperties(
                $setElements->item( $i )->firstChild->childNodes,
                $request->updates,
                ezcWebdavPropPatchRequest::SET
            );
        }
        
        for ( $i = 0; $i < $removeElements->length; ++$i )
        {
            $this->extractProperties(
                $removeElements->item( $i )->firstChild->childNodes,
                $request->updates,
                ezcWebdavPropPatchRequest::REMOVE
            );
        }

        return $request;
    }


    /**
     * Returns an XML representation of the given response object.
     *
     * @param ezcWebdavMultiStatusResponse $response 
     * @return DOMDocument
     */
    protected function processMultiStatusResponse( ezcWebdavMultiStatusResponse $response )
    {
        $dom = $this->xml->createDomDocument();

        $multistatusElement = $dom->appendChild(
            $this->xml->createDomElement( $dom, 'multistatus' )
        );

        foreach ( $response->responses as $subResponse )
        {
            $multistatusElement->appendChild(
                ( $subResponse instanceof ezcWebdavErrorResponse 
                    ? $dom->importNode( $this->processErrorResponse( $subResponse, true )->body->documentElement, true )
                    : $dom->importNode( $this->processResponse( $subResponse )->body->documentElement, true )
                )
            );
        }
        
        return new ezcWebdavDisplayInformation( $response, $dom );
    }

    /**
     * Returns an XML representation of the given response object.
     *
     * @param ezcWebdavPropFindResponse $response 
     * @return DOMDocument
     */
    protected function processPropFindResponse( ezcWebdavPropFindResponse $response )
    {
        $dom = $this->xml->createDomDocument();

        $responseElement = $dom->appendChild(
            $this->xml->createDomElement( $dom, 'response' )
        );

        $responseElement->appendChild(
            $this->xml->createDomElement( $dom, 'href' )
        )->nodeValue = $this->options->pathFactory->generateUriFromPath( $response->node->path );

        foreach ( $response->responses as $propStat )
        {
            $responseElement->appendChild(
                $dom->importNode( $this->processPropStatResponse( $propStat )->body->documentElement, true )
            );
        }
        return new ezcWebdavDisplayInformation( $response, $dom );
    }

    /**
     * Returns an XML representation of the given response object.
     *
     * @param ezcWebdavPropPatchResponse $response 
     * @return DOMDocument
     */
    protected function processPropPatchResponse( ezcWebdavPropPatchResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, null );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavCopyResponse $response 
     * @return DOMDocument|null
     */
    protected function processCopyResponse( ezcWebdavCopyResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, null );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavMoveResponse $response 
     * @return DOMDocument|null
     */
    protected function processMoveResponse( ezcWebdavMoveResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, null );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavDeleteResponse $response 
     * @return DOMDocument|null
     */
    protected function processDeleteResponse( ezcWebdavDeleteResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, null );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavErrorResponse $response 
     * @param bool $xml DOMDocument in result only generated of true.
     * @return DOMDocument|null
     */
    protected function processErrorResponse( ezcWebdavErrorResponse $response, $xml = false )
    {
        $dom = null;
        if ( $xml === true )
        {
            $dom = $this->xml->createDomDocument();
            $responseElement = $dom->appendChild(
                $this->xml->createDomElement( $dom, 'response' )
            );
            
            $responseElement->appendChild(
                $this->xml->createDomElement( $dom, 'href' )
            )->nodeValue = $this->options->pathFactory->generateUriFromPath( $response->requestUri );
            
            $responseElement->appendChild(
                $this->xml->createDomElement( $dom, 'status' )
            )->nodeValue = (string) $response;

        }
        return new ezcWebdavDisplayInformation( $response, $dom );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavGetCollectionResponse $response 
     * @return DOMDocument|null
     */
    protected function processGetCollectionResponse( ezcWebdavGetCollectionResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, null );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavGetResourceResponse $response 
     * @return DOMDocument|null
     * @todo Do we need to set more headers here?
     */
    protected function processGetResourceResponse( ezcWebdavGetResourceResponse $response )
    {
        // Generate Content-Type header if necessary
        if ( $response->getHeader( 'Content-Type' ) === null )
        {
            $contentTypeProperty = $response->resource->liveProperties->get( 'getcontenttype' );
            $contentTypeHeader = ( $contentTypeProperty->mime    !== null ? $contentTypeProperty->mime    : 'application/octet-stream' ) .
                '; charset="' .   ( $contentTypeProperty->charset !== null ? $contentTypeProperty->charset : 'utf-8' ) . '"';
            $response->setHeader( 'Content-Type', $contentTypeHeader );
        }
        // Generate Content-Length header if necessary
        /*
        if ( $response->getHeader( 'Content-Length' ) === null )
        {
            $response->setHeader( 'Content-Length', ( strlen( $response->resource->content ) + 1 ) );
        }
        */
        return new ezcWebdavDisplayInformation( $response, $response->resource->content );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavPutResponse $response 
     * @return DOMDocument|null
     */
    protected function processPutResponse( ezcWebdavPutResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, $response );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavHeadResponse $response 
     * @return DOMDocument|null
     * @todo Do we need to set more headers here?
     */
    protected function processHeadResponse( ezcWebdavHeadResponse $response )
    {
        // Generate Content-Type header if necessary
        if ( $response->getHeader( 'Content-Type' ) === null )
        {
            $contentTypeProperty = $response->resource->liveProperties->get( 'getcontenttype' );
            $contentTypeHeader = ( $contentTypeProperty->mime    !== null ? $contentTypeProperty->mime    : 'application/octet-stream' ) .
                '; charset="' .   ( $contentTypeProperty->charset !== null ? $contentTypeProperty->charset : 'utf-8' ) . '"';
            $response->setHeader( 'Content-Type', $contentTypeHeader );
        }
        // Generate Content-Length header if necessary
        if ( $response->getHeader( 'Content-Length' ) === null )
        {
            $response->setHeader( 'Content-Length', ( strlen( $response->resource->content ) + 1 ) );
        }
        return new ezcWebdavDisplayInformation( $response, $response->resource->content );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavMakeCollectionResponse $response 
     * @return DOMDocument|null
     */
    protected function processMakeCollectionResponse( ezcWebdavMakeCollectionResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, null );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavOptionsResponse $response 
     * @return DOMDocument|null
     */
    protected function processOptionsResponse( ezcWebdavOptionsResponse $response )
    {
        return new ezcWebdavDisplayInformation( $response, null );
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavPropStatResponse $response 
     * @return DOMDocument|null
     */
    protected function processPropStatResponse( ezcWebdavPropStatResponse $response )
    {
        $dom = $this->xml->createDomDocument();

        $propstatElement = $dom->appendChild(
            $this->xml->createDomElement( $dom, 'propstat' )
        );
        
        $this->serializePropertyStorage(
            $response->storage,
            $propstatElement->appendChild( $this->xml->createDomElement( $dom, 'prop' ) )
        );

        $propstatElement->appendChild(
            $this->xml->createDomElement(
                $dom,
                'status'
            )
        )->nodeValue = (string) $response;

        return new ezcWebdavDisplayInformation( $response, $dom );
    }

    /**
     * Serializes an object of new ezcWebdavBasicPropertyStorage to XML.
     * Attaches all properties of the $storage to the $parentElement XML
     * element.
     * 
     * @param new ezcWebdavBasicPropertyStorage $storage 
     * @param DOMElement $parentElement 
     * @return void
     */
    protected function serializePropertyStorage( ezcWebdavPropertyStorage $storage, DOMElement $parentElement )
    {
        foreach ( $storage as $property )
        {
            if ( $property instanceof ezcWebdavLiveProperty )
            {
                $this->serializeLiveProperty( $property, $parentElement );
            }
            else
            {
                $this->serializeDeadProperty( $property, $parentElement );
            }
        }
    }

    /**
     * Returns the XML representation of a dead property.
     * Returns a DOMElement, representing the content of the given $property.
     * The newly created element is also appended as a child to the given
     * $parentElement.
     * 
     * @param ezcWebdavDeadProperty $property 
     * @param DOMElement $parentElement 
     * @return DOMElement
     */
    protected function serializeDeadProperty( ezcWebdavDeadProperty $property, DOMElement $parentElement )
    {
        if ( $property->content === null || ( $contentDom = $this->xml->createDomDocument( $property->content ) ) === false )
        {
            return $parentElement->appendChild(
                $this->xml->createDomElement(
                    $parentElement->ownerDocument,
                    $property->name,
                    $property->namespace
                )
            );
        }

        return $parentElement->appendChild(
            $parentElement->ownerDocument->importNode( $contentDom->documentElement, true )
        );
    }

    /**
     * Returns the XML representation of a live property.
     * Returns a DOMElement, representing the content of the given $property.
     * The newly created element is also appended as a child to the given
     * $parentElement.
     * 
     * @param ezcWebdavLiveProperty $property 
     * @param DOMElement $parentElement 
     * @return DOMElement
     */
    protected function serializeLiveProperty( ezcWebdavLiveProperty $property, DOMElement $parentElement )
    {
        switch ( get_class( $property ) )
        {
            case 'ezcWebdavCreationDateProperty':
                $elementName  = 'creationdate';
                $elementValue = ( $property->date !== null ? $property->date->format( DATE_ISO8601 ) : null );
                break;
            case 'ezcWebdavDisplayNameProperty':
                $elementName  = 'displayname';
                $elementValue = $property->displayName;
                break;
            case 'ezcWebdavGetContentLanguageProperty':
                $elementName  = 'getcontentlanguage';
                $elementValue = ( count( $property->languages ) > 0 ? implode( ', ', $property->languages ) : null );
                break;
            case 'ezcWebdavGetContentLengthProperty':
                $elementName  = 'getcontentlength';
                $elementValue = $property->length;
                break;
            case 'ezcWebdavGetContentTypeProperty':
                $elementName  = 'getcontenttype';
                $elementValue = ( $property->mime !== null ? $property->mime . ( $property->charset === null ? '' : '; charset="' . $property->charset . '"' ) : null );
                break;
            case 'ezcWebdavGetEtagProperty':
                $elementName  = 'getetag';
                $elementValue = $property->etag;
                break;
            case 'ezcWebdavGetLastModifiedProperty':
                $elementName  = 'getlastmodified';
                $elementValue = ( $property->date !== null ? $property->date->format( DATE_RFC1123 ) : null );
                break;
            case 'ezcWebdavLockDiscoveryProperty':
                $elementName  = 'lockdiscovery';
                $elementValue = ( $property->activeLock !== null ? $this->serializeActiveLockContent( $property->activeLock, $parentElement->ownerDocument ) : null );
                break;
            case 'ezcWebdavResourceTypeProperty':
                $elementName  = 'resourcetype';
                $elementValue = ( $property->type === ezcWebdavResourceTypeProperty::TYPE_COLLECTION ? array( $this->xml->createDomElement( $parentElement->ownerDocument, 'collection' ) ) : null );
                break;
            case 'ezcWebdavSourceProperty':
                $elementName  = 'source';
                $elementValue = ( $property->links !== null ? $this->serializeLinkContent( $property->links, $parentElement->ownerDocument ) : null );
                break;
            case 'ezcWebdavSupportedLockProperty':
                $elementName  = 'supportedlock';
                $elementValue = ( $property->lockEntry !== null ? $this->serializeLockEntryContent( $property->lockEntry, $parentElement->ownerDocument ) : null );
                break;
        }

        $propertyElement = $parentElement->appendChild( 
            $this->xml->createDomElement( $parentElement->ownerDocument, $elementName, $property->namespace )
        );

        if ( $elementValue instanceof DOMDocument )
        {
            $propertyElement->appendChild(
                $dom->importNode( $elementValue->documentElement, true )
            );
        }
        else if ( is_array( $elementValue ) )
        {
            foreach( $elementValue as $subValue )
            {
                $propertyElement->appendChild( $subValue );
            }
        }
        else if ( is_scalar( $elementValue ) )
        {
            $propertyElement->nodeValue = $elementValue;
        }

        return $propertyElement;
    }

    /**
     * Serializes an array of ezcWebdavLockDiscoveryPropertyActiveLock elements to XML.
     * 
     * @param array(ezcWebdavLockDiscoveryPropertyActiveLock) $links 
     * @param DOMDocument $dom To create the returned DOMElements.
     * @return array(DOMElement)
     */
    protected function serializeActiveLockContent( array $activeLocks = null, DOMDocument $dom )
    {
        $activeLockElements = array();
        foreach ( $activeLocks as $activeLock )
        {
            $activeLockElement = $this->xml->createDomElement( $dom, 'activelock' );
            
            $activeLockElement->appendChild(
                $this->xml->createDomElement( $dom, 'locktype' )
            )->appendChild(
                $this->xml->createDomElement( $dom, ( $activeLock->lockType === ezcWebdavLockRequest::TYPE_READ ? 'read' : 'write' ) )
            );
            
            $activeLockElement->appendChild(
                $this->xml->createDomElement( $dom, 'lockscope' )
            )->appendChild(
                $this->xml->createDomElement( $dom, ( $activeLock->lockScope === ezcWebdavLockRequest::SCOPE_EXCLUSIVE ? 'exclusive' : 'shared' ) )
            );
            
            $depthElement = $activeLockElement->appendChild(
                $this->xml->createDomElement( $dom, 'depth' )
            );
            
            switch ( $activeLock->depth )
            {
                case ezcWebdavRequest::DEPTH_ZERO:
                    $depthElement->nodeValue = '0';
                    break;
                case ezcWebdavRequest::DEPTH_ONE:
                    $depthElement->nodeValue = '1';
                    break;
                case ezcWebdavRequest::DEPTH_INFINITY:
                    $depthElement->nodeValue = 'Infity';
                    break;
            }

            if ( $activeLock->owner !== null )
            {
                $activeLockElement->appendChild(
                    $this->xml->createDomElement( $dom, 'owner' )
                )->nodeValue = $activeLock->owner;
            }

            $activeLockElement->appendChild(
                $this->xml->createDomElement( $dom, 'timeout' )
            )->$activeLock->timeout;

            foreach ( $activeLock->tokens as $token )
            {
                $activeLockElement->appendChild(
                    $this->xml->createDomElement( $dom, 'locktoken' )
                )->appendChild(
                    $this->xml->createDomElement( $dom, 'href' )
                )->nodeValue = $token;
            }

            $activeLockElements[] = $lockElement;
        }

        return $activeLockElements;
    }

    /**
     * Serializes an array of ezcWebdavSourcePropertyLink elements to XML.
     * 
     * @param array(ezcWebdavSourcePropertyLink) $links 
     * @param DOMDocument $dom To create the returned DOMElements.
     * @return array(DOMElement)
     */
    protected function serializeLinkContent( array $links = null, DOMDocument $dom )
    {
        $linkContentElements = array();

        foreach( $links as $link )
        {
            $linkElement = $this->xml->createDomElement( $dom, 'link' );
            $linkElement->appendChild(
                $this->xml->createDomElement( $dom, 'src' )
            )->nodeValue = $link->src;
            $linkElement->appendChild(
                $this->xml->createDomElement( $dom, 'dst' )
            )->nodeValue = $link->dst;
            $linkContentElements[] = $linkElement;
        }

        return $linkContentElements;
    }

    /**
     * Serializes an array of ezcWebdavSupportedLockPropertyLockentry elements to XML.
     * 
     * @param array(ezcWebdavSupportedLockPropertyLockentry) $lockEntries 
     * @param DOMDocument $dom To create the returned DOMElements.
     * @return array(DOMElement)
     */
    protected function serializeLockEntryContent( array $lockEntries = null, DOMDocument $dom )
    {
        $lockEntryContentElements = array();

        foreach( $lockEntries as $lockEntry )
        {
            $lockEntryElement = $this->xml->createDomElement( $dom, 'lockentry' );
            $lockEntryElement->appendChild(
                $this->xml->createDomElement( $dom, 'lockscope' )
            )->appendChild(
                $this->xml->createDomElement( $dom, ( $lockEntry->lockScope === ezcWebdavLockRequest::SCOPE_EXCLUSIVE ? 'exclusive' : 'shared' ) )
            );
            $lockEntryElement->appendChild(
                $this->xml->createDomElement( $dom, 'locktype' )
            )->appendChild(
                $this->xml->createDomElement( $dom, ( $lockEntry->lockScope === ezcWebdavLockRequest::TYPE_READ ? 'read' : 'write' ) )
            );
            $lockEntryContentElements[] = $lockEntryElement;
        }

        return $lockEntryContentElements;
    }
    
    /**
     * Property read access.
     * 
     * @param string $propertyName Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     * @ignore
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) === false )
        {
            throw new ezcBasePropertyNotFoundException( $propertyName );
        }
            
        return $this->properties[$propertyName];
    }

    /**
     * Property write access.
     * 
     * @param string $propertyName Name of the property.
     * @param mixed $propertyValue  The value for the property.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'options':
                if ( ( $propertyValue instanceof ezcWebdavTransportOptions ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavTransportOptions' );
                }
                break;
            case 'xml':
                if ( ( $propertyValue instanceof ezcWebdavXmlTool ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavXmlTool' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }

    /**
     * Property isset access.
     *
     * @param string $propertyName Name of the property.
     * @return bool True is the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}

?>
