<?php
/**
 * File containing the ezcWebdavXmlBase class.
 *
 * @package Base
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Base class for all XML based objects in this component.
 * The WebDAV specification allows any client/server to introduce own XML
 * elements in an own namespace at almost every place. To suite this need every
 * class that can be parsed from or be serialized to XML must extend this base
 * class (e.g. ezcWebdavProperty or ezcWebdavRequest).
 *
 * If a derived class is parsed from a request, all unrecognized XML elements
 * are available through the getMiscNodes() method as an array of DOMNode
 * objects. The setMiscNodes() method can be used to inject new DOMNode
 * elements into the specific object. These nodes will be injected into the DOM
 * tree generated for the response.
 *
 * The class is declared abstract to avoid direct instantiation, it does not
 * contain any abstract methods.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcWebdavXmlBase
{

    protected $miscNodes = array();

    /**
     * Returns an array of DOMNode objects that were not recognized.
     * This method returns an array of DOMNode objects, which could not be
     * recognized during parsing.
     * 
     * @return array(DOMNode) Not recognized XML elements.
     */
    public function getMiscNodes()
    {
        return $this->miscNodes;
    }

    /**
     * Sets an array of DOMNode objects to inject into the resulting XML.
     * This method receives an array of DOMNode objects, which will be injected
     * into the resulting XML, when it is serialized. Any DOMNode can be used
     * (like DOMAttr or DOMElement).
     * 
     * @param array(DOMNode) $nodes Nodes to inject.
     * @return void
     *
     * @throws ezcBaseValueException
     *         if an element in the submitted array is not a DOMNode.
     */
    public function setMiscNodes( array $nodes )
    {
        foreach ( $nodes as $id => $node )
        {
            if ( ( $node instanceof DOMNode ) )
            {
                throw new ezcBaseValueException( "nodes[$id]", get_class( $node ), 'DOMNode' );
            }
        }
        $this->miscNodes = $nodes;
    }
}

?>
