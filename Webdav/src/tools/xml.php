<?php
/**
 * File containing the ezcWebdavXmlTool class.
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
class ezcWebdavXmlTool
{
    /**
     * The default namespace, where WebDAV XML elements reside in. 
     */
    const XML_DEFAULT_NAMESPACE = 'DAV:';

    /**
     * The XML version to create DOM documents in. 
     */
    const XML_VERSION = '1.0';

    /**
     * Encoding to use to create DOM documents. 
     */
    const XML_ENCODING = 'utf-8';

    /**
     * Properties.
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Creates a new XML tool.
     * 
     * @param ezcWebdavNamespaceRegistry $namespaceRegistry 
     * @return void
     */
    public function __construct( ezcWebdavNamespaceRegistry $namespaceRegistry = null )
    {
        // Initialize properties
        $this->properties['namespaceRegistry'] = null;

        $this->namespaceRegistry = ( $namespaceRegistry === null ? new ezcWebdavNamespaceRegistry() : $namespaceRegistry );
    }

    /**
     * Returns a DOMDocument from the given XML.
     * Creates a new DOMDocument with the options set in the class constants
     * and loads the optionally given $xml string with settings appropriate to
     * work with it. Returns false if the loading fails.
     *
     * @see LIBXML_NOWARNING, LIBXML_NSCLEAN, LIBXML_NOBLANKS
     *
     * @param sting $xml 
     * @return DOMDocument|false
     *
     * @todo This should throw an exception if loading of the XML fails!
     */
    public function createDomDocument( $content = null )
    {
        $dom = new DOMDocument( self::XML_VERSION, self::XML_ENCODING );
        if ( $content !== null )
        {
            if ( $dom->loadXML(
                    $content,
                    LIBXML_NOWARNING | LIBXML_NSCLEAN | LIBXML_NOBLANKS
                 ) === false )
            {
                return false;
            }
        }
        return $dom;
    }

    /**
     * Returns a new DOMElement in the given namespace.
     *
     * Retrieves the shortcut for the $namespace and creates a new DOMElement
     * object with the correct global name for the given $localName.
     * 
     * @param DOMDocument $dom 
     * @param string $localName 
     * @param string $namespace 
     * @return DOMElement
     */
    public function createDomElement( DOMDocument $dom, $localName, $namespace = self::XML_DEFAULT_NAMESPACE )
    {
        return $dom->createElementNS(
            $namespace,
            "{$this->namespaceRegistry[$namespace]}:{$localName}"
        );
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
            case 'namespaceRegistry':
                if ( ( $propertyValue instanceof ezcWebdavNamespaceRegistry ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavNamespaceRegistry' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
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
