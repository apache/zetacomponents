<?php
/**
 * File containing the ezcWebdavPropertyHandler class.
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Description missing
 *
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavPropertyHandler
{
    /**
     * XML tool. 
     * 
     * @var ezcWebdavXmlTool
     */
    protected $xmlTool;

    /**
     * Regedx to parse the <getcontenttype /> XML elemens content.
     *
     * Example: 'text/html; charset=UTF-8'
     */
    const GETCONTENTTYPE_REGEX = '(^(?P<mime>\w+/\w+)\s*(?:;\s*charset\s*=\s*(?P<charset>.+)\s*)?$)i';

    /**
     * Creates a new property handler.
     *
     * An instance of this class is capable of handling live and dead WebDAV
     * properties. It can extract properties from requests and generate
     * response information for properties.
     * 
     * @param ezcWebdavXmlTool $xml 
     * @return void
     */
    public function __construct( ezcWebdavXmlTool $xml = null )
    {
        if ( $xml !== null )
        {
            $this->xmlTool = $xml;
        }
    }

    protected function getXmlTool()
    {
        if ( $this->xmlTool === null )
        {
            return ezcWebdavServer::getInstance()->xmlTool;
        }
        return $this->xmlTool;
    }

    /**
     * Returns extracted properties in an ezcWebdavPropertyStorage.
     *
     * This method receives a DOMNodeList $domNodes which must contain a set
     * of DOMElement objects, while each of those represents a WebDAV property.
     *
     * The list may contain live properties as well as dead ones. Live
     * properties ({@link ezcWebdavLiveProperty}) as defined in RFC 2518 are
     * currently recognized. All other properties in the DAV: namespace are
     * added as dead properties ({@link ezcWebdavDeadProperty}). Dead
     * properties are parsed in general in any namespace.
     *
     * The properties are stored in the given {@link ezcWebdavPropertyStorage}
     * $storage. If a $flag value is provided, this one is submitted as the
     * second parameter to {@link ezcWebdavFlaggedPropertyStorage->attach()}.
     *  
     * @param DOMNodeList $domNodes 
     * @param ezcWebdavPropertyStorage $storage
     * @param int $flag
     * @return ezcWebdavBasicPropertyStorage
     */
    public function extractProperties( DOMNodeList $domNodes, ezcWebdavBasicPropertyStorage $storage, $flag = null )
    {
        for ( $i = 0; $i < $domNodes->length; ++$i )
        {
            $currentNode = $domNodes->item( $i );
            if ( $currentNode->nodeType !== XML_ELEMENT_NODE )
            {
                // Skip
                continue;
            }
            
            // DAV: namespace indicates live property! If parsing live fails, a dead property is returned
            if ( $currentNode->namespaceURI === ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE )
            {
                $flag === null
                    ? $storage->attach( $this->extractLiveProperty( $currentNode ) )
                    : $storage->attach( $this->extractLiveProperty( $currentNode ), $flag );
            }
            // Other namespaces are always dead properties
            else
            {
                $flag === null
                    ? $storage->attach( $this->extractDeadProperty( $currentNode ) )
                    : $storage->attach( $this->extractDeadProperty( $currentNode ), $flag );
            }
        }
        return $storage;
    }

    /**
     * Extract a dead property from a DOMElement.
     *
     * This method is responsible for parsing a {@link ezcWebdavDeadProperty}
     * (unknown) property from a DOMElement.
     * 
     * @param DOMElement $domElement 
     * @return ezcWebdavDeadProperty
     *
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
     *
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
                    $property->languages = array_map( 'trim', explode( ',', $domElement->nodeValue ) );
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

                    if ( isset( $matches['charset'] ) )
                    {
                        $property->charset = $matches['charset'];
                    }
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
     * Serializes an object of new ezcWebdavBasicPropertyStorage to XML.
     * Attaches all properties of the $storage to the $parentElement XML
     * element.
     * 
     * @param new ezcWebdavPropertyStorage $storage 
     * @param DOMElement $parentElement 
     * @return void
     */
    public function serializeProperties( ezcWebdavPropertyStorage $storage, DOMElement $parentElement )
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

    // Extracting

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

    // Serializing

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
        if ( $property->content === null || ( $contentDom = $this->getXmlTool()->createDomDocument( $property->content ) ) === false )
        {
            return $parentElement->appendChild(
                $this->getXmlTool()->createDomElement(
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
                $elementValue = ( $property->type === ezcWebdavResourceTypeProperty::TYPE_COLLECTION ? array( $this->getXmlTool()->createDomElement( $parentElement->ownerDocument, 'collection' ) ) : null );
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
            $this->getXmlTool()->createDomElement( $parentElement->ownerDocument, $elementName, $property->namespace )
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
            $activeLockElement = $this->getXmlTool()->createDomElement( $dom, 'activelock' );
            
            $activeLockElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'locktype' )
            )->appendChild(
                $this->getXmlTool()->createDomElement( $dom, ( $activeLock->lockType === ezcWebdavLockRequest::TYPE_READ ? 'read' : 'write' ) )
            );
            
            $activeLockElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'lockscope' )
            )->appendChild(
                $this->getXmlTool()->createDomElement( $dom, ( $activeLock->lockScope === ezcWebdavLockRequest::SCOPE_EXCLUSIVE ? 'exclusive' : 'shared' ) )
            );
            
            $depthElement = $activeLockElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'depth' )
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
                    $this->getXmlTool()->createDomElement( $dom, 'owner' )
                )->nodeValue = $activeLock->owner;
            }

            $activeLockElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'timeout' )
            )->$activeLock->timeout;

            foreach ( $activeLock->tokens as $token )
            {
                $activeLockElement->appendChild(
                    $this->getXmlTool()->createDomElement( $dom, 'locktoken' )
                )->appendChild(
                    $this->getXmlTool()->createDomElement( $dom, 'href' )
                )->nodeValue = $token;
            }

            $activeLockElements[] = $lockElement;
        }

        return $activeLockElements;
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
            $lockEntryElement = $this->getXmlTool()->createDomElement( $dom, 'lockentry' );
            $lockEntryElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'lockscope' )
            )->appendChild(
                $this->getXmlTool()->createDomElement( $dom, ( $lockEntry->lockScope === ezcWebdavLockRequest::SCOPE_EXCLUSIVE ? 'exclusive' : 'shared' ) )
            );
            $lockEntryElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'locktype' )
            )->appendChild(
                $this->getXmlTool()->createDomElement( $dom, ( $lockEntry->lockScope === ezcWebdavLockRequest::TYPE_READ ? 'read' : 'write' ) )
            );
            $lockEntryContentElements[] = $lockEntryElement;
        }

        return $lockEntryContentElements;
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
            $linkElement = $this->getXmlTool()->createDomElement( $dom, 'link' );
            $linkElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'src' )
            )->nodeValue = $link->src;
            $linkElement->appendChild(
                $this->getXmlTool()->createDomElement( $dom, 'dst' )
            )->nodeValue = $link->dst;
            $linkContentElements[] = $linkElement;
        }

        return $linkContentElements;
    }
}

?>
