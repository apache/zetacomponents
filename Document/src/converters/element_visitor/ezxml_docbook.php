<?php

/**
 * File containing the ezcDocumentXsltConverter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Converter for docbook to XDocbook with a PHP callback based mechanism, for fast
 * and easy PHP based extensible transformations.
 *
 * This converter does not support the full docbook standard, but only a subset
 * commonly used in the document component. If you need to transform documents
 * using the full docbook you might prefer to use the
 * ezcDocumentEzXmlToDocbookXsltConverter with the default stylesheet from
 * Welsh.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzXmlToDocbookConverter extends ezcDocumentElementVisitorConverter
{
    /**
     * Deafult document namespace
     *
     * If no namespace has been explicitely declared in the source document
     * assume this as the defalt namespace.
     * 
     * @var string
     */
    protected $defaultNamespace = 'ezxml';

    /**
     * Construct converter
     *
     * Construct converter from XSLT file, which is used for the actual
     * 
     * @param ezcDocumentEzXmlToDocbookConverterOptions $options
     * @return void
     */
    public function __construct( ezcDocumentEzXmlToDocbookConverterOptions $options = null )
    {
        parent::__construct( 
            $options === null ?
                new ezcDocumentEzXmlToDocbookConverterOptions() :
                $options
        );

        // Initlize common element handlers
        $this->visitorElementHandler = array(
            'ezxml' => array(
                'section'           => $mapper = new ezcDocumentEzXmlToDocbookMappingHandler(),
            )
        );
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
    protected function initializeDocument()
    {
        $imp = new DOMImplementation();
        $dtd = $imp->createDocumentType( 'article', '-//OASIS//DTD DocBook XML V4.5//EN', 'http://www.oasis-open.org/docbook/xml/4.5/docbookx.dtd' );
        $docbook = $imp->createDocument( 'http://docbook.org/ns/docbook', '', $dtd );
        $docbook->formatOutput = true;

        $root = $docbook->createElementNs( 'http://docbook.org/ns/docbook', 'article' );
        $docbook->appendChild( $root );

        return $root;
    }

    /**
     * Create document from structure
     *
     * Build a ezcDocumentDocument object from the structure created during the
     * visiting process.
     *
     * @param mixed $content 
     * @return ezcDocumentDocument
     */
    protected function createDocument( $content )
    {
        $document = $content->ownerDocument;

        $ezxml = new ezcDocumentEzXml();
        $ezxml->setDomDocument( $document );
        return $ezxml;
    }

    /**
     * Visit text node.
     *
     * Visit a text node in the source document and transform it to the
     * destination result
     * 
     * @param DOMText $node 
     * @param mixed $root 
     * @return mixed
     */
    protected function visitText( DOMText $node, $root )
    {
        if ( trim( $wholeText = $node->data ) !== '' )
        {
            $text = new DOMText( $wholeText );
            $root->appendChild( $text );
        }

        return $root;
    }
}

?>
