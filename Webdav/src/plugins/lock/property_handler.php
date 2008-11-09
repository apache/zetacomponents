<?php
/**
 * File containing the ezcWebdavLockPropertyHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Property handler of the Lock plugin.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockPropertyHandler
{
    /**
     * Extracts a live property from a DOMElement.
     *
     * This method is responsible for parsing WebDAV live properties. The
     * DOMElement $domElement must be an XML element in the DAV: namepsace. If
     * the received property is not defined in RFC 2518, null is returned.
     * 
     * @param DOMElement $domElement 
     * @param ezcWebdavXmlTool $xmlTool
     * @return ezcWebdavLiveProperty|null
     */
    public function extractLiveProperty( DOMElement $domElement, ezcWebdavXmlTool $xmlTool )
    {
        $property = null;
        switch ( $domElement->localName )
        {
            case 'lockdiscovery':
                $property = new ezcWebdavLockDiscoveryProperty();
                foreach ( $domElement->childNodes as $activeLockChild )
                {
                    if ( $activeLockChild->nodeType === XML_ELEMENT_NODE && $activeLockChild->localName === 'activelock' )
                    {
                        $property->activeLock->append( $this->extractActiveLockContent( $activeLockChild ) );
                    }
                }
                break;
            case 'supportedlock':
                $property = new ezcWebdavSupportedLockProperty();
                foreach ( $domElement->childNodes as $childNode )
                {   
                    if ( $childNode->nodeType === XML_ELEMENT_NODE && $childNode->localName === 'lockentry' )
                    {
                        $property->lockEntries->append( $this->extractLockEntryContent( $childNode ) );
                    }
                }
                break;
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
     * @param DOMElement $activeLockElement 
     * @return ezcWebdavLockDiscoveryPropertyActiveLock
     */
    protected function extractActiveLockContent( DOMElement $activeLockElement )
    {
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        foreach ( $activeLockElement->childNodes as $currentElement )
        {
            if ( !( $currentElement instanceof DOMElement ) )
            {
                // Skip non element children
                continue;
            }
            switch ( $currentElement->localName )
            {
                case 'locktype':
                    if ( $currentElement->hasChildNodes() && $currentElement->firstChild->localName !== 'write' )
                    {
                        $activeLock->lockType = ezcWebdavLockRequest::TYPE_READ;
                    }
                    else
                    {
                        $activeLock->lockType = ezcWebdavLockRequest::TYPE_WRITE;
                    }
                    break;
                case 'lockscope':
                    if ( $currentElement->hasChildNodes() )
                    {
                        switch ( $currentElement->firstChild->localName )
                        {
                            case 'exclusive':
                                $activeLock->lockScope = ezcWebdavLockRequest::SCOPE_EXCLUSIVE;
                                break;
                            case 'shared':
                                $activeLock->lockScope = ezcWebdavLockRequest::SCOPE_SHARED;
                                break;
                        }
                    }
                    break;
                case 'depth':
                    switch ( trim( $currentElement->nodeValue ) )
                    {
                        case '0':
                            $activeLock->depth = ezcWebdavRequest::DEPTH_ZERO;
                            break;
                        case '1':
                            $activeLock->depth = ezcWebdavRequest::DEPTH_ONE;
                            break;
                        case 'infinity':
                            $activeLock->depth = ezcWebdavRequest::DEPTH_INFINITY;
                            break;
                    }
                    break;
                case 'owner':
                    $activeLock->owner = new ezcWebdavPotentialUriContent(
                        trim( $currentElement->textContent ),
                        // Owner indicated by an URI?
                        ( $currentElement->hasChildNodes() && $currentElement->childNodes->item( 0 )->localName === 'href' )
                    );
                    break;
                case 'timeout':
                    $timeoutVal = trim( $currentElement->nodeValue );
                    if ( substr( $timeoutVal, 0, 7 ) === 'Second-' )
                    {
                        $activeLock->timeout = (int) substr( $timeoutVal, 7 );
                    }
                    break;
                case 'locktoken':
                    // @TODO: This may only be 1, no ArrayObject needed!
                    $activeLock->token = new ezcWebdavPotentialUriContent(
                        trim( $currentElement->textContent ),
                        // Is lock token represented by an URI?
                        ( $currentElement->hasChildNodes() && $currentElement->firstChild->localName === 'href' )
                    );
                    break;

                // Custom elements of the lock plugin
                case 'baseuri':
                    if ( $currentElement->namespaceURI !== ezcWebdavLockPlugin::XML_NAMESPACE )
                    {
                        throw new ezcWebdavInvalidXmlException(
                            'Namespace of baseuri element is ' . $currentElement->namespaceURI . ', expected ' . ezcWebdavLockPlugin::XML_NAMESPACE
                        );
                    }
                    $activeLock->baseUri = $currentElement->textContent;
                    break;
                case 'lastaccess':
                    if ( $currentElement->namespaceURI !== ezcWebdavLockPlugin::XML_NAMESPACE )
                    {
                        throw new ezcWebdavInvalidXmlException(
                            'Namespace of lastaccess element is ' . $currentElement->namespaceURI . ', expected ' . ezcWebdavLockPlugin::XML_NAMESPACE
                        );
                    }
                    $activeLock->lastAccess = new ezcWebdavDateTime( $currentElement->textContent );
                    break;
            }
        }
        return $activeLock;
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
        return new ezcWebdavSupportedLockPropertyLockentry(
            ( $domElement->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'locktype' )->item( 0 )->firstChild->localName === 'write'
                ? ezcWebdavLockRequest::TYPE_WRITE : ezcWebdavLockRequest::TYPE_READ ),
            ( $domElement->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'lockscope' )->item( 0 )->firstChild->localName === 'shared'
                ? ezcWebdavLockRequest::SCOPE_SHARED : ezcWebdavLockRequest::SCOPE_EXCLUSIVE )
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
     * @param ezcWebdavXmlTool $xmlTool
     * @return DOMElement
     */
    public function serializeLiveProperty( ezcWebdavLiveProperty $property, DOMElement $parentElement, ezcWebdavXmlTool $xmlTool )
    {
        switch ( get_class( $property ) )
        {
            case 'ezcWebdavLockDiscoveryProperty':
                $elementName  = 'lockdiscovery';
                $elementValue = (
                    $property->activeLock !== null 
                        ? $this->serializeActiveLockContent( $property->activeLock, $parentElement->ownerDocument, $xmlTool )
                        : null
                );
                break;
            case 'ezcWebdavSupportedLockProperty':
                $elementName  = 'supportedlock';
                $elementValue = (
                    count( $property->lockEntries ) !== 0
                        ? $this->serializeLockEntryContent( $property->lockEntries, $parentElement->ownerDocument, $xmlTool )
                        : null
                );
                break;
        }

        $propertyElement = $parentElement->appendChild( 
            $xmlTool->createDomElement( $parentElement->ownerDocument, $elementName, $property->namespace )
        );

        if ( $elementValue instanceof DOMDocument )
        {
            $propertyElement->appendChild(
                $dom->importNode( $elementValue->documentElement, true )
            );
        }
        else if ( is_array( $elementValue ) )
        {
            foreach ( $elementValue as $subValue )
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
     * Receives an array of {@link ezcWebdavLockDiscoveryPropertyActiveLock}
     * objects in $activeLocks and serializes them to XML nodes in the received
     * $dom DOMDocument, using the received {@link ezcWebdavXmlTool} $xmlTool.
     * The created DOMElement objects are returned as an error for further
     * processing.
     * 
     * @param array(ezcWebdavLockDiscoveryPropertyActiveLock) $activeLocks 
     * @param DOMDocument $dom 
     * @param ezcWebdavXmlTool $xmlTool
     * @return array(DOMElement)
     */
    protected function serializeActiveLockContent( ArrayObject $activeLocks = null, DOMDocument $dom, ezcWebdavXmlTool $xmlTool )
    {
        $activeLockElements = array();
        foreach ( $activeLocks as $activeLock )
        {
            $activeLockElement = $xmlTool->createDomElement( $dom, 'activelock' );
            
            $activeLockElement->appendChild(
                $xmlTool->createDomElement( $dom, 'locktype' )
            )->appendChild(
                $xmlTool->createDomElement(
                    $dom, ( $activeLock->lockType === ezcWebdavLockRequest::TYPE_READ ? 'read' : 'write' )
                )
            );
            
            $activeLockElement->appendChild(
                $xmlTool->createDomElement( $dom, 'lockscope' )
            )->appendChild(
                $xmlTool->createDomElement(
                    $dom, ( $activeLock->lockScope === ezcWebdavLockRequest::SCOPE_EXCLUSIVE ? 'exclusive' : 'shared' )
                )
            );
            
            $depthElement = $activeLockElement->appendChild(
                $xmlTool->createDomElement( $dom, 'depth' )
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
                    $depthElement->nodeValue = 'Infinity';
                    break;
            }

            if ( $activeLock->owner !== null )
            {
                $ownerElement = $activeLockElement->appendChild(
                    $xmlTool->createDomElement( $dom, 'owner' )
                );

                // If owner is represented by an URI, wrap it in <href>
                if ( $activeLock->owner->isUri )
                {
                    $ownerElement = $ownerElement->appendChild(
                        $xmlTool->createDomElement( $dom, 'href' )
                    );
                }
                
                $ownerElement->nodeValue = $activeLock->owner->content;
            }

            $activeLockElement->appendChild(
                $xmlTool->createDomElement( $dom, 'timeout' )
            )->nodeValue = "Second-{$activeLock->timeout}";

            $lockTokenElement = $activeLockElement->appendChild(
                $xmlTool->createDomElement( $dom, 'locktoken' )
            );
            
            if ( $activeLock->token->isUri )
            {
                $lockTokenElement = $lockTokenElement->appendChild(
                    $xmlTool->createDomElement( $dom, 'href' )
                );
            }

            $lockTokenElement->nodeValue = $activeLock->token->content;

            // Lock plugin custom elements

            if ( $activeLock->baseUri !== null )
            {
                $activeLockElement->appendChild(
                    $xmlTool->createDomElement( $dom, 'baseuri', ezcWebdavLockPlugin::XML_NAMESPACE )
                )->nodeValue = $activeLock->baseUri;
            }

            if ( $activeLock->lastAccess !== null )
            {
                $activeLockElement->appendChild(
                    $xmlTool->createDomElement( $dom, 'lastaccess', ezcWebdavLockPlugin::XML_NAMESPACE )
                )->nodeValue = $activeLock->lastAccess->format( 'c' );
            }

            $activeLockElements[] = $activeLockElement;
        }

        return $activeLockElements;
    }

    /**
     * Serializes an array of ezcWebdavSupportedLockPropertyLockentry elements to XML.
     * 
     * @param array(ezcWebdavSupportedLockPropertyLockentry) $lockEntries 
     * @param DOMDocument $dom To create the returned DOMElements.
     * @param ezcWebdavXmlTool $xmlTool
     * @return array(DOMElement)
     */
    protected function serializeLockEntryContent( ArrayObject $lockEntries = null, DOMDocument $dom, ezcWebdavXmlTool $xmlTool )
    {
        $lockEntryContentElements = array();

        foreach ( $lockEntries as $lockEntry )
        {
            $lockEntryElement = $xmlTool->createDomElement( $dom, 'lockentry' );
            $lockEntryElement->appendChild(
                $xmlTool->createDomElement( $dom, 'lockscope' )
            )->appendChild(
                $xmlTool->createDomElement(
                    $dom, ( $lockEntry->lockScope === ezcWebdavLockRequest::SCOPE_EXCLUSIVE ? 'exclusive' : 'shared' )
                )
            );
            $lockEntryElement->appendChild(
                $xmlTool->createDomElement( $dom, 'locktype' )
            )->appendChild(
                $xmlTool->createDomElement(
                    $dom, ( $lockEntry->lockScope === ezcWebdavLockRequest::TYPE_READ ? 'read' : 'write' )
                )
            );
            $lockEntryContentElements[] = $lockEntryElement;
        }

        return $lockEntryContentElements;
    }

    /**
     * Extracts a dead property from the given $element.
     *
     * Checks is the given $element encodes a dead property which can be parsed
     * by this class. If this is the case, the corresponding property object is
     * returned, otherwise null.
     * 
     * @param DOMElement $element 
     * @param ezcWebdavXmlTool $xmlTool 
     * @return ezcWebdavDeadProperty|null
     */
    public function extractDeadProperty( DOMElement $element, ezcWebdavXmlTool $xmlTool )
    {
        switch ( $element->localName )
        {
            case 'lockinfo':
                return $this->extractLockInfoProperty( $element, $xmlTool );

            // default:
                return null;
        }
    }

    /**
     * Extracts the <lockinfo> property from the given $element.
     * 
     * @param DOMElement $element 
     * @param ezcWebdavXmlTool $xmlTool 
     * @return ezcWebdavLockInfoProperty
     */
    protected function extractLockInfoProperty( DOMElement $element, ezcWebdavXmlTool $xmlTool )
    {
        $tokenInfos    = new ArrayObject();
        $nullResource = false;

        foreach ( $element->childNodes as $child )
        {
            if ( $child->nodeType !== XML_ELEMENT_NODE )
            {
                // skip non-tags
                continue;
            }

            switch ( $child->localName )
            {
                case 'null':
                    $nullResource = true;
                    break;

                case 'tokeninfo':
                    $tokenInfo = $this->extractLockTokenInfo( $child, $xmlTool );
                    $tokenInfos[$tokenInfo->token] = $tokenInfo;
                    break;

                // Ignore all other elements
            }
        }
        return new ezcWebdavLockInfoProperty( $tokenInfos, $nullResource );
    }

    /**
     * Extracts the <tokeninfo> from the given $element.
     * 
     * @param DOMElement $element 
     * @param ezcWebdavXmlTool $xmlTool 
     * @return ezcWebdavLockTokenInfo
     */
    protected function extractLockTokenInfo( DOMElement $element, ezcWebdavXmlTool $xmlTool )
    {
        $tokenInfo = new ezcWebdavLockTokenInfo();

        foreach ( $element->childNodes as $child )
        {
            if ( $child->nodeType !== XML_ELEMENT_NODE )
            {
                // Skip non-tags
                continue;
            }

            switch( $child->localName )
            {
                case 'token':
                    $tokenInfo->token = $child->nodeValue;
                    break;

                case 'lockbase':
                    $tokenInfo->lockBase = $child->nodeValue;
                    break;

                case 'lastaccess':
                    $tokenInfo->lastAccess = new ezcWebdavDateTime(
                        $child->nodeValue
                    );
                    break;

                // Ignore all other tags
            }
        }

        return $tokenInfo;
    }

    /**
     * Serializes the given $property to a DOMElement.
     *
     * Checks if the given $property can be serialized to XML. If this is the
     * case, a DOMElement representing the given $property is returned,
     * otherwise null. The DOMElement must in addition be appended to the given
     * $parent element (which most likely is a property storage element, but
     * can also be different).
     * 
     * @param ezcWebdavDeadProperty $property 
     * @param DOMElement $parent
     * @param ezcWebdavXmlTool $xmlTool 
     * @return DOMElement|null
     */
    public function serializeDeadProperty( ezcWebdavDeadProperty $property, DOMElement $parent, ezcWebdavXmlTool $xmlTool )
    {
        $element = null;
        switch ( get_class( $property ) )
        {
            case 'ezcWebdavLockInfoProperty':
                $element = $this->serializeLockInfoProperty( $property, $parent, $xmlTool );
                break;

            // default:
                // break;
        }

        return $element;
    }
    
    protected function serializeLockInfoProperty( ezcWebdavLockInfoProperty $property, DOMElement $parent, ezcWebdavXmlTool $xmlTool )
    {
        $domDocument = $parent->ownerDocument;

        $lockInfoElement = $xmlTool->createDomElement(
            $domDocument, 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE
        );

        if ( $property->null )
        {
            $lockInfoElement->appendChild(
                $xmlTool->createDomElement(
                    $domDocument, 'null', ezcWebdavLockPlugin::XML_NAMESPACE
                )
            );
        }

        foreach ( $property->tokenInfos as $tokenInfo )
        {
            // <tokenfinfo>
            $tokenInfoElement = $lockInfoElement->appendChild(
                $xmlTool->createDomElement(
                    $domDocument, 'tokeninfo', ezcWebdavLockPlugin::XML_NAMESPACE
                )
            );
            
            // <token>$token</token>
            $tokenInfoElement->appendChild(
                $xmlTool->createDomElement(
                    $domDocument, 'token', ezcWebdavLockPlugin::XML_NAMESPACE
                )
            )->appendChild(
                new DOMText( $tokenInfo->token )
            );

            // Primary check for <tokenbase> (more often present?)
            if ( $lockInfoElement->tokeninfo->lockBase !== null )
            {
                $tokenInfoElement->appendChild(
                    $xmlTool->createDomElement(
                        $domDocument, 'lockbase', ezcWebdavLockPlugin::XML_NAMESPACE
                    )
                )->appendChild(
                    new DOMText( $tokenInfo->lockBase )
                );
            }
            // If <tokenbase> is not set, <lastaccess> should be!
            else if ( $lockInfoElement->tokeninfo->lastAccess !== null )
            {
                $tokenInfoElement->appendChild(
                    $xmlTool->createDomElement(
                        $domDocument, 'lastaccess', ezcWebdavLockPlugin::XML_NAMESPACE
                    )
                )->appendChild(
                    new DOMText( $tokenInfo->lastAccess->format( 'c' ) )
                );
            }
        }
        return $lockInfoElement;
    }
}

?>
