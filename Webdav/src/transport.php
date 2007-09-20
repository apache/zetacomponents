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
     * Properties.
     * 
     * @var array()
     */
    protected $properties = array();

    public function __construct( ezcWebdavTransportOptions $options = null )
    {
        if ( $options === null )
        {
            $options = new ezcWebdavTransportOptions();
        }
        $this->properties['options'] = $options;
    }

    /**
     * Map of regular header names to $_SERVER keys.
     *
     * @var array(string=>string)
     */
    static protected $headerMap = array(
        'Depth'       => 'HTTP_DEPTH',
        'Destination' => 'HTTP_DESTINATION',
        'Overwrite'   => 'HTTP_OVERWRITE',
        'Timeout'     => 'HTTP_TIMEOUT',
        'Lock-Token'  => 'HTTP_LOCK_TOKEN',
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
        $path = $this->options->pathFactory->parseUriToPath( $uri );

        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'PROPFIND':
                return $this->parsePropFindRequest( $path, $body );
            case 'PROPPATCH':
                return $this->parsePropPatchRequest( $path, $body );
            case 'COPY':
                return $this->parseCopyRequest( $path, $body );
            case 'MOVE':
                return $this->parseMoveRequest( $path, $body );
            case 'DELETE':
                return $this->parseDeleteRequest( $path, $body );
            case 'LOCK':
                return $this->parseLockRequest( $path, $body );
            case 'UNLOCK':
                return $this->parseUnlockRequest( $path, $body );
            case 'MKCOL':
                return $this->parseMakeCollectionRequest( $path, $body );
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
     * Returns a DOMDocument from the given XML.
     * Creates a new DOMDocument and loads the given XML string with settings
     * appropriate to work with it.
     * 
     * @param sting $xml 
     * @return DOMDocument|false
     */
    protected function getDom( $xml = null )
    {
        $dom = new DOMDocument( '1.0', 'utf-8' );
        if ( $xml !== null )
        {
            if ( $dom->loadXML(
                    $xml,
                    LIBXML_NOWARNING | LIBXML_NSCLEAN | LIBXML_NOBLANKS
                 ) === false )
            {
                return false;
            }
        }
        return $dom;
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

        if ( ( $dom = $this->getDom( $body ) ) === false )
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

        if ( ( $dom = $this->getDom( $body ) ) === false )
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

        if ( ( $dom = $this->getDom( $body ) ) === false )
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

        $lockTypeElements  = $dom->documentElement->getElementsByTagnameNS( 'DAV:', 'locktype' );
        $lockScopeElements = $dom->documentElement->getElementsByTagnameNS( 'DAV:', 'lockscope' );
        $ownerElements     = $dom->documentElement->getElementsByTagnameNS( 'DAV:', 'owner' );

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

        if ( ( $dom = $this->getDom( $body ) ) === false )
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
                $request->prop = new ezcWebdavPropertyStorage();
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
     * Returns extracted properties in an ezcWebdavPropertyStorage.
     * This method receives a DOMNodeList $domNodes, which must contain a set
     * of DOMElement objects, while each of those represents a WebDAV property.
     * The list may contain live properties as well as dead ones. Live
     * properties as defined in RFC 2518 are currently recognized. All other
     * properties in the DAV: namespace are silently ignored. Dead properties
     * are parsed. The properties are stored in the given {@link
     * ezcWebdavPropertyStorage} $storage. If a $flag value is provided, this
     * one is submitted as the second parameter to
     * ezcWebdavPropertyStorage->attach() ({@link
     * ezcWebdavFlaggedPropertyStorage}).
     * 
     * @param DOMNodeList $domNodes 
     * @param ezcWebdavPropertyStorage $storage
     * @param int $flag
     * @return ezcWebdavPropertyStorage
     */
    protected function extractProperties( DOMNodeList $domNodes, ezcWebdavPropertyStorage $storage, $flag = null )
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
            if ( $currentNode->namespaceURI === 'DAV:' )
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
                // Create standalone XML for property
                // @TODO How do we need to take care about different namespaces here?
                // It may possibly occur, that shortcut clashes occur...
                $propDom = new DOMDocument();
                $copiedNode = $propDom->importNode( $currentNode, true );
                $propDom->appendChild( $copiedNode );
                
                $property = new ezcWebdavDeadProperty(
                    $currentNode->namespaceURI,
                    $currentNode->localName,
                    $propDom->saveXML()
                );
                $flag === null ? $storage->attach( $property ) : $storage->attach( $property, $flag );
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
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        $activelockElement = $domElement->getElementsByTagNameNS( 'DAV:', 'activelock' )->item( 0 );
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
                    $activelock->timeout = new DateTime( $currentElement->nodeValue );
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

        if ( ( $dom = $this->getDom( $body ) ) === false )
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

        $setElements    = $dom->documentElement->getElementsByTagNameNS( 'DAV:', 'set' );
        $removeElements = $dom->documentElement->getElementsByTagNameNS( 'DAV:', 'remove' );
        
        for ( $i = 0; $i < $setElements->length; ++$i )
        {
            $this->extractProperties(
                $setElements->item( 0 )->firstChild->childNodes,
                $request->updates,
                ezcWebdavPropPatchRequest::SET
            );
        }
        
        for ( $i = 0; $i < $removeElements->length; ++$i )
        {
            $this->extractProperties(
                $removeElements->item( 0 )->firstChild->childNodes,
                $request->updates,
                ezcWebdavPropPatchRequest::REMOVE
            );
        }

        return $request;
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
        $this->sendResponse( $response, $this->processResponse( $response ) );
    }

    protected function processResponse( ezcWebdavResponse $response )
    {
        $dom = null;

        switch ( ( $responseClass = get_class( $response ) ) )
        {
            case 'ezcWebdavPropFindResponse':
                $dom = $this->processPropFindResponse( $response );
                break;
            case 'ezcWebdavMultistatusResponse':
                $dom = $this->processMultiStatusResponse( $response );
                break;
            
            case 'ezcWebdavCopyResponse':
            case 'ezcWebdavDeleteResponse':
            case 'ezcWebdavErrorResponse':
            case 'ezcWebdavGetCollectionResponse':
            case 'ezcWebdavGetResourceResponse':
            case 'ezcWebdavHeadResponse':
            case 'ezcWebdavMakeCollectionResponse':
            case 'ezcWebdavMoveResponse':
            case 'ezcWebdavOptionsResponse':
            case 'ezcWebdavPropPatchResponse':
            case 'ezcWebdavPutResponse':
            default:
                // @TODO: Implement!
                throw new RuntimeException( "Serialization of class $responseClass not implemented, yet." );
            
        }

        return $dom;
    }

    /**
     * Finally send out the response.
     * This method is called to finally send the response to the browser. It
     * can be overwritten in test cases to change the behaviour of printing out
     * the result and sending the headers.
     * 
     * @param ezcWebdavResponse $response 
     * @param DOMDocument $dom 
     * @return void
     */
    protected function sendResponse( ezcWebdavResponse $response, DOMDocument $dom = null )
    {
        header( (string) $response );
        if ( $dom instanceof DOMDocument )
        {
            $dom->formatOutput = true;
            echo $dom->saveXML( $dom );
        }
    }

    /**
     * Returns an XML representation of the given response object.
     *
     * @param ezcWebdavMultiStatusResponse $response 
     * @return DOMDocument
     */
    protected function processMultiStatusResponse( ezcWebdavMultiStatusResponse $response )
    {
        $dom = $this->getDom();

        $multistatusElement = $dom->appendChild(
            $dom->createElementNS(
                'DAV:',
                'D:multistatus'
            )
        );

        foreach ( $response->responses as $subResponse )
        {
            $multistatusElement->appendChild(
                $dom->importNode( $this->processResponse( $subResponse )->documentElement, true )
            );
        }
        
        return $dom;
    }

    /**
     * Returns an XML representation of the given response object.
     *
     * @param ezcWebdavPropFindResponse $response 
     * @return DOMDocument
     */
    protected function processPropFindResponse( ezcWebdavPropFindResponse $response )
    {
        $dom = $this->getDom();

        $responseElement = $dom->appendChild(
            $dom->createElementNS( 'DAV:', 'D:repsonse' )
        );

        $responseElement->appendChild(
            $dom->createElementNS(
                'DAV:',
                'D:href',
                $this->options->pathFactory->generateUriFromPath( $response->node->path )
            )
        );

        foreach ( $response->responses as $propStat )
        {
            $responseElement->appendChild(
                $dom->importNode( $this->processPropStatResponse( $propStat )->documentElement, true )
            );
        }
        return $dom;
    }

    /**
     * Returns an XML representation of the given response object.
     * 
     * @param ezcWebdavPropStatResponse $response 
     * @return DOMDocument
     */
    protected function processPropStatResponse( ezcWebdavPropStatResponse $response )
    {
        $dom = $this->getDom();

        $propstatElement = $dom->appendChild(
            $dom->createElementNS( 'DAV:', 'D:propstat' )
        );
        
        $this->serializePropertyStorage(
            $response->storage,
            $propstatElement->appendChild( $dom->createElementNS( 'DAV:', 'D:prop' ) )
        );

        $propstatElement->appendChild(
            $dom->createElementNS(
                'DAV:',
                'D:status',
                (string) $response
            )
        );

        return $dom;
    }

    /**
     * Serializes an object of ezcWebdavPropertyStorage to XML.
     * Attaches all properties of the $storage to the $parentElement XML
     * element.
     * 
     * @param ezcWebdavPropertyStorage $storage 
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
        if ( $property->content === null || ( $contentDom = $this->getDom( $property->content ) ) === false )
        {
            return $parentElement->appendChild(
                $parentElement->ownerDocument->createElementNS(
                    $property->namespace,
                    // This seems to be a way to not loose the correct prefix here.
                    $property->ownerDocument->lookupPrefix( $property->namespace ) . ':' . $property->name
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
                $elementValue = ( $property->mime !== null ? $property->mime . ( $property->charset === null ? '' : '; charset=' . $property->charset ) : null );
                break;
            case 'ezcWebdavGetEtagProperty':
                $elementName  = 'getetag';
                $elementValue = $property->etag;
                break;
            case 'ezcWebdavGetLastModifiedProperty':
                $elementName  = 'getlastmodified';
                $elementValue = ( $property->date !== null ? $property->date->format( DATE_ISO8601 ) : null );
                break;
            case 'ezcWebdavLockDiscoveryProperty':
                $elementName  = 'lockdiscovery';
                $elementValue = ( $property->activeLock !== null ? $this->serializeActiveLockContent( $property->activeLock ) : null );
                break;
            case 'ezcWebdavResourceTypeProperty':
                $elementName  = 'resourcetype';
                $elementValue = ( $property->type === 'collection' ? new DOMElement( 'D:collection', null, 'DAV:' ) : null );
                break;
            case 'ezcWebdavSourceProperty':
                $elementName  = 'source';
                $elementValue = ( $property->links !== null ? $this->serializeLinkContent( $property->links ) : null );
                break;
            case 'ezcWebdavSupportedLockProperty':
                $elementName  = 'supportedlock';
                $elementValue = ( $property->lockEntry !== null ? $this->serializeLockEntryContent( $property->lockEntry ) : null );
                break;
        }

        $propertyElement = $parentElement->appendChild( 
            $parentElement->ownerDocument->createElementNS(
                'DAV:',
                "D:{$elementName}"
            )
        );

        if ( $elementValue instanceof DOMDocument )
        {
            $propertyElement->appendChild(
                $dom->importNode( $elementValue->documentElement, true )
            );
        }
        else if ( $elementValue !== null )
        {
            $propertyElement->nodeValue = $elementValue;
        }

        return $propertyElement;
    }

    protected function serializeActiveLockContent( ezcWebdavLockDiscoveryPropertyActiveLock $content = null )
    {
        return null;
    }

    protected function serializeLinkContent( array $links = null )
    {
        return null;
    }

    protected function serializeLockEntryContent( array $content = null )
    {
        return null;
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
