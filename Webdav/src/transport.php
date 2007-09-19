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
 * The transport handler parses the request and echos the response depending on
 * the client it has been written for.
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
     * Map of regular header names to $_SERVER keys.
     *
     * @var array(string=>string)
     */
    static protected $headerMap = array(
        'Depth'       => 'HTTP_DEPTH',
        'Destination' => 'HTTP_DESTINATION',
        'Overwrite'   => 'HTTP_OVERWRITE',
    );

    /**
     * Regedx to parse the <getcontenttype /> XML elemens content.
     * Example: 'text/html; charset=UTF-8'
     */
    const GETCONTENTTYPE_REGEX = '(^(?P<mime>\w+/\w+)\s*;\s*charset\s*=\s*(?P<charset>.+)\s*$)i';

    /**
     * Parses the webserver environment variables to create a proper request
     * object from then containing all relevant information to handle the
     * request by the backend.
     *
     * @return ezcWebdavRequest
     */
    public function parseRequest( $uri )
    {
        $body = $this->retreiveBody();
        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'PROPFIND':
                return $this->parsePropFindRequest( $uri, $body );
            case 'COPY':
                return $this->parseCopyRequest( $uri, $body );
            case 'DELETE':
                return $this->parseDeleteRequest( $uri, $body );
            case 'LOCK':
                return $this->parseLockRequest( $uri, $body );
            default:
                throw new ezcWebdavInvalidRequestMethodException(
                    $_SERVER['REQUEST_METHOD']
                );
        }
    }

    /**
     * Returns the body content of the request.
     * This method mainly exists for unittesting purpose. It reads the request
     * body and returns the contents.
     * 
     * @return string void
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
            default:
                // @TODO Add extensiability hook
        }
        return $value;
    }

    // COPY

    /**
     * Parses the COPY request and returns a request object.
     * This method is responsible for parsing the COPY request. It
     * retrieves the current request URI in $uri and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavCopyRequest} object.
     * 
     * @param string $uri 
     * @param string $body 
     * @return ezcWebdavCopyRequest
     */
    protected function parseCopyRequest( $uri, $body )
    {
        $headers = $this->parseHeaders(
            array( 'Destination', 'Depth', 'Overwrite' )
        );

        $request = new ezcWebdavCopyRequest( $uri, $headers['Destination'] );

        $request->setHeaders( $headers );

        if ( trim( $body ) === '' )
        {
            // No body present
            return $request;
        }

        $dom = new DOMDocument();
        if ( $dom->loadXML( $body, LIBXML_NOWARNING | LIBXML_NSCLEAN | LIBXML_NOBLANKS ) === false )
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
     * retrieves the current request URI in $uri and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavDeleteRequest} object.
     * 
     * @param string $uri 
     * @param string $body 
     * @return ezcWebdavDeleteRequest
     */
    protected function parseDeleteRequest( $uri, $body )
    {
        return new ezcWebdavDeleteRequest( $uri );
    }
    
    // LOCK

    /**
     * Parses the LOCK request and returns a request object.
     * This method is responsible for parsing the LOCK request. It
     * retrieves the current request URI in $uri and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavLockRequest} object.
     * 
     * @param string $uri 
     * @param string $body 
     * @return ezcWebdavLockRequest
     */
    protected function parseLockRequest( $uri, $body )
    {
        return new ezcWebdavLockRequest( $uri );
    }

    // PROPFIND

    /**
     * Parses the PROPFIND request and returns a request object.
     * This method is responsible for parsing the PROPFIND request. It
     * retrieves the current request URI in $uri and the request body as $body.
     * The return value, if no exception is thrown, is a valid {@link
     * ezcWebdavPropFindRequest} object.
     * 
     * @param string $uri 
     * @param string $body 
     * @return ezcWebdavPropFindRequest
     */
    protected function parsePropFindRequest( $uri, $body )
    {
        $request = new ezcWebdavPropFindRequest( $uri );

        $request->setHeaders(
            $this->parseHeaders(
                array( 'Depth' )
            )
        );

        $dom = new DOMDocument();
        if ( $dom->loadXML( $body, LIBXML_NOWARNING | LIBXML_NSCLEAN | LIBXML_NOBLANKS ) === false )
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
                $request->prop = $this->extractProperties(
                    $dom->documentElement->firstChild->childNodes
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
     * Returns extracted properties in an ezcWebdavPropertyStorage.
     * This method receives a DOMNodeList $domNodes, which must contain a set
     * of DOMElement objects, while each of those represents a WebDAV property.
     * The list may contain live properties as well as dead ones. Live
     * properties as defined in RFC 2518 are currently recognized. All other
     * properties in the DAV: namespace are silently ignored. Dead properties
     * are parsed.
     * 
     * @param DOMNodeList $domNodes 
     * @return ezcWebdavPropertyStorage
     */
    protected function extractProperties( DOMNodeList $domNodes )
    {
        $storage = new ezcWebdavPropertyStorage();

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
            if ( $currentNode->namespaceURI === 'DAV:' )
            {
                $property = $this->extractLiveProperty( $currentNode );
                // In case we don't know the property, we currently ignore it!
                if ( $property !== null )
                {
                    $storage->attach( $property );
                }
            }
            
            // Other namespaces are always dead properties
            else
            {
                // Create standalone XML for property
                // @TODO How do we need to take care about different namespaces here?
                // It may possibly occur, that shortcut clashes occur...
                $propDom = new DOMDocument();
                $copiedNode = $propDom->importNode( $currentNode, true );
                $propDom->appendChild( $copiedNode );
                $storage->attach(
                    new ezcWebdavDeadProperty(
                        $currentNode->namespaceURI,
                        $currentNode->localName,
                        $propDom->saveXML()
                    )
                );
            }
        }
        return $storage;
    }

    /**
     * Extracts a live property from an DOMElement.
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
                    $property->date = new DateTime( $domElement->nodeValue );
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
                    $property->date = new DateTime( $domElement->nodeValue );
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
                    $property->links = $this->extractLinkContent( $domElemente );
                }
                break;
            case 'supportedlock':
                $property = new ezcWebdavSupportedLockProperty();
                if ( $domElement->hasChildNodes() === true )
                {
                    $property->links = $this->extractLockEntryContent( $domElemente );
                }
                break;
            default:
                // @TODO Implement extension plugins
                // Currently just ignore
                $property = null;
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
        // @TODO Implement
        return null;
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
        // @TODO Implement
        return null;
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
        // @TODO Implement
        return null;
    }

    /**
     * Handle a response from the backend and output it depending on the
     * current transport mechanism.
     * 
     * @param ezcWebdavResponse $response
     * @return void
     */
    public function handleResponse( ezcWebdavResponse $response )
    {
        // @TODO: Implement
    }
}

?>
