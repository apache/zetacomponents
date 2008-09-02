<?php

/**
 * File containing the ezcDocumentDocbookElementVisitorConverter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Basic converter which stores a list of handlers for each node in the docbook
 * element tree. Those handlers will be executed for the elements, when found.
 * The handler can then handle the repective subtree.
 *
 * Additional handlers may be added by the user to the converter class.
 * 
 * @package Document
 * @version //autogen//
 */
abstract class ezcDocumentDocbookElementVisitorConverter extends ezcDocumentConverter
{
    /**
     * Element handlers
     *
     * Element handlers for elements per namespace. The namespace names may be
     * names, which might have document specific meaning, like "docbook" for
     * all different docbook versions, or a namespace URI.
     *
     * The handler is as an object of a class inheriting from
     * ezcDocumentDocbookElementVisitorHandler.
     * 
     * @var array
     */
    protected $visitorElementHandler = array(
    );

    /**
     * Deafult document namespace
     *
     * If no namespace has been explicitely declared in the source document
     * assume this as the defalt namespace.
     * 
     * @var string
     */
    protected $defaultNamespace = 'docbook';

    /**
     * Convert documents between two formats
     * 
     * Convert documents of the given type to the requested type.
     *
     * @param ezcDocumentXmlBase $doc 
     * @return ezcDocumentDocument
     */
    public function convert( $source )
    {
        $destination = $this->initializeDocument();

        $destination = $this->visitChildren(
            $source->getDomDocument(),
            $destination
        );

        return $this->createDocument( $destination );
    }

    /**
     * Initialize destination document
     * 
     * Initialize the structure which the destination document could be build
     * with. This may be an initial DOMDocument with some default elements, or
     * a string, or something else.
     *
     * @return mixed
     */
    abstract protected function initializeDocument();

    /**
     * Create document from structure
     *
     * Build a ezcDocumentDocument object from the structure created during the
     * visiting process.
     *
     * @param mixed $content 
     * @return ezcDocumentDocument
     */
    abstract protected function createDocument( $content );

    /**
     * Recursively visit children of a document node.
     * 
     * Recurse through the whole document tree and call the defined callbacks
     * for node transformations, defined in the class property
     * $visitorElementHandler.
     *
     * @param DOMNode $node 
     * @param mixed $root 
     * @return mixed
     */
    public function visitChildren( DOMNode $node, $root )
    {
        // Recurse into child elements
        foreach ( $node->childNodes as $child )
        {
            switch ( $child->nodeType )
            {
                case XML_ELEMENT_NODE:
                    if ( isset( $this->visitorElementHandler[$this->defaultNamespace][$child->tagName] ) )
                    {
                        $root = $this->visitorElementHandler[$this->defaultNamespace][$child->tagName]->handle( $this, $child, $root );
                    }
                    else
                    {
                        // Trigger notive for unhandled elements
                        $this->triggerError( E_NOTICE, "Unhandled element '{$child->tagName}'." );

                        // Recurse into element childs anyways
                        $this->visitChilds( $child, $root );
                    }
                    break;

                case XML_TEXT_NODE:
                    $root = $this->visitText( $child, $root );
                    break;
            }
        }

        return $root;
    }

    /**
     * Visit text node.
     *
     * Visit a text node in the source document and transform it to the
     * destination result
     * 
     * @param DOMText $text 
     * @param mixed $root 
     * @return mixed
     */
    abstract protected function visitText( DOMText $text, $root );

    /**
     * Set custom element handler
     *
     * Set handler for yet unhandled element or overwrite the handler of an
     * existing element.
     * 
     * @param string $namespace 
     * @param string $element 
     * @param ezcDocumentDocbookElementVisitorHandler $handler 
     * @return void
     */
    public function setElementHandler( $namespace, $element, ezcDocumentDocbookElementVisitorHandler $handler )
    {
        $this->visitorElementHandler[$namespace][$element] = $handler;
    }
}

?>
