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
                if ( $domElement->hasChildNodes() )
                {
                    $property->activeLock = $this->extractActiveLockContent( $domElement );
                }
                break;
            case 'supportedlock':
                $property = new ezcWebdavSupportedLockProperty();
                if ( $domElement->hasChildNodes() )
                {
                    $property->links = $this->extractLockEntryContent( $domElement );
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
     * @param DOMElement $domElement 
     * @return ezcWebdavLockDiscoveryPropertyActiveLock
     */
    protected function extractActiveLockContent( DOMElement $domElement )
    {
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        $activelockElement = $domElement->getElementsByTagNameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'activelock' )->item( 0 );
        for ( $i = 0; $i < $activelockElement->childNodes->length; ++$i )
        {
            if ( !( ( $currentElement = $activelockElement->childNodes->item( $i ) ) instanceof DOMElement ) )
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
                    // @todo Need to check for special values here!
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
                    $property->lockEntry !== null
                        ? $this->serializeLockEntryContent( $property->lockEntry, $parentElement->ownerDocument, $xmlTool )
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
    protected function serializeActiveLockContent( array $activeLocks = null, DOMDocument $dom, ezcWebdavXmlTool $xmlTool )
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
                    $depthElement->nodeValue = 'Infity';
                    break;
            }

            if ( $activeLock->owner !== null )
            {
                $activeLockElement->appendChild(
                    $xmlTool->createDomElement( $dom, 'owner' )
                )->nodeValue = $activeLock->owner;
            }

            $activeLockElement->appendChild(
                $xmlTool->createDomElement( $dom, 'timeout' )
            )->$activeLock->timeout;

            foreach ( $activeLock->tokens as $token )
            {
                $activeLockElement->appendChild(
                    $xmlTool->createDomElement( $dom, 'locktoken' )
                )->appendChild(
                    $xmlTool->createDomElement( $dom, 'href' )
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
     * @param ezcWebdavXmlTool $xmlTool
     * @return array(DOMElement)
     */
    protected function serializeLockEntryContent( array $lockEntries = null, DOMDocument $dom, ezcWebdavXmlTool $xmlTool )
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
}

?>
