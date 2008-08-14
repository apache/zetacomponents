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
 * Converter for docbook to XHtml with a PHP callback based mechanism, for fast
 * and easy PHP based extensible transformations.
 *
 * This converter does not support the full docbook standard, but only a subset
 * commonly used in the document component. If you need to transform documents
 * using the full docbook you might prefer to use the
 * ezcDocumentDocbookToHtmlXsltConverter with the default stylesheet from
 * Welsh.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToHtmlConverter extends ezcDocumentConverter
{
    /**
     * Element callbacks
     *
     * Array with local method names assigned to the names of the docbook
     * elements, defining the respective visitor for the docbook elements.;
     * 
     * @var array
     */
    protected $visitorCallback = array(
        'sect1info'         => 'visitHead',
        'sect2info'         => 'visitHead',
        'sect3info'         => 'visitHead',
        'sect4info'         => 'visitHead',
        'sect5info'         => 'visitHead',
        'sectioninfo'       => 'visitHead',
        'sect1'             => 'visitSection',
        'sect2'             => 'visitSection',
        'sect3'             => 'visitSection',
        'sect4'             => 'visitSection',
        'sect5'             => 'visitSection',
        'section'           => 'visitSection',
        'title'             => 'visitTitle',
        'para'              => 'visitParagraph',
        'emphasis'          => 'visitEmphasis',
        'literal'           => 'visitWithMapper',
        'ulink'             => 'visitExternalLink',
        'link'              => 'visitInternalLink',
        'anchor'            => 'visitLinkTarget',
        'inlinemediaobject' => 'visitMediaObject',
        'mediaobject'       => 'visitMediaObject',
        'blockquote'        => 'visitBlockquote',
    );

    /**
     * Mapping of element names.
     *
     * Element tag name mapping for elements, which just require trivial
     * mapping used by the visitWithMapper() method.
     * 
     * @var array
     */
    protected $mapping = array(
        'literal' => 'code',
    );


    /**
     * Reference to the HTML document node
     * 
     * @var DOMDocument
     */
    protected $html;

    /**
     * Reference to the HTML header section
     * 
     * @var DOMElement
     */
    protected $head;

    /**
     * Current level of indentation in the docbook document.
     * 
     * @var int
     */
    protected $level = 0;

    /**
     * Construct converter
     *
     * Construct converter from XSLT file, which is used for the actual
     * 
     * @param string $xslt 
     * @return void
     */
    public function __construct( ezcDocumentDocbookToHtmlConverterOptions $options = null )
    {
        $this->options = ( $options === null ?
            new ezcDocumentDocbookToHtmlConverterOptions() :
            $options );
    }

    /**
     * Convert documents between two formats
     * 
     * Convert documents of the given type to the requested type.
     *
     * @param ezcDocumentXmlBase $doc 
     * @return ezcDocumentXhtml
     */
    public function convert( $doc )
    {
        $this->html = new DOMDocument();

        $root = $this->html->createElementNs( 'http://www.w3.org/1999/xhtml', 'html' );
        $this->html->appendChild( $root );

        $this->head = $this->html->createElement( 'head' );
        $root->appendChild( $this->head );

        $generator = $this->html->createElement( 'meta' );
        $generator->setAttribute( 'name', 'generator' );
        $generator->setAttribute( 'content', 'eZ Components; http://ezcomponents.org' );
        $this->head->appendChild( $generator );

        $body = $this->html->createElement( 'body' );
        $root->appendChild( $body );

        $this->visitChilds( $doc->getDomDocument(), $body );

        $html = new ezcDocumentXhtml();
        $html->setDomDocument( $this->html );
        return $html;
    }

    /**
     * Recursively visit childs of a document node.
     * 
     * Recurse through the whole document tree and call the defined callbacks
     * for node transformations, defined in the class property
     * $visitorCallback.
     *
     * @param DOMNode $node 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitChilds( DOMNode $node, DOMElement $root )
    {
        // Recurse into child elements
        foreach ( $node->childNodes as $child )
        {
            switch ( $child->nodeType )
            {
                case XML_ELEMENT_NODE:
                    if ( isset( $this->visitorCallback[$child->tagName] ) )
                    {
                        $callback = $this->visitorCallback[$child->tagName];
                        $newRoot = $this->$callback( $child, $root );
                    }
                    else
                    {
                        // Recurse into element childs
                        $this->visitChilds( $child, $root );
                    }
                    break;

                case XML_TEXT_NODE:
                    // Skip pure whitespace text nodes
                    if ( trim( $child->wholeText ) !== '' )
                    {
                        $text = new DOMText( $child->wholeText );
                        $root->appendChild( $text );
                    }
                    break;
            }
        }
    }

    /**
     * Simple mapping visito method
     *
     * Special visitor for elements which just need trivial mapping of element
     * tag names. It ignores all attributes of the input element and just
     * converts the tag name.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitWithMapper( DOMElement $element, DOMElement $root )
    {
        if ( isset( $this->mapping[$element->tagName] ) )
        {
            $new = $this->html->createElement( $this->mapping[$element->tagName] );
            $root->appendChild( $new );
            $this->visitChilds( $element, $new );
        }
    }

    /**
     * Visit docbook sectioninfo elements
     *
     * The sectioninfo elements contain metadata about the document or
     * sections, which are transformed into the respective metadata in the HTML
     * header.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitHead( DOMElement $element, DOMElement $root )
    {
        // @TODO: Implement
    }

    /**
     * Visit docbook sections
     *
     * Updates the docbook sections, which give us information about the depth
     * in the document, and may also be reference targets.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitSection( DOMElement $element, DOMElement $root )
    {
        ++$this->level;

        // Set internal cross reference target if section has an ID assigned
        if ( $element->hasAttribute( 'id' ) )
        {
            $target = $this->html->createElement( 'a' );
            $target->setAttribute( 'name', $element->getAttribute( 'id' ) );
            $root->appendChild( $target );
        }

        $this->visitChilds( $element, $root );
        --$this->level;
    }

    /**
     * Visit docbook title elements
     *
     * Title elements are commonly the first element in sections and define
     * sectionm titles, which are converted to HTML header elements of the
     * respective level of indentation
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitTitle( DOMElement $element, DOMElement $root )
    {
        // Also set the document title from the first heading
        if ( $this->level === 1 )
        {
            $title = $this->html->createElement( 'title', htmlspecialchars( trim( $element->textContent ) ) );
            $this->head->appendChild( $title );
        }

        // Create common HTML headers
        $header = $this->html->createElement( 'h' . min( 6, $this->level ) );
        if ( $this->level >= 6 )
        {
            $header->setAttribute( 'class', 'h' . $this->level );
        }
        $root->appendChild( $header );
        $this->visitChilds( $element, $header );
    }

    /**
     * Visit paragraphs
     *
     * Visit docbook paragraphs and transform them into HTML paragraphs.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitParagraph( DOMElement $element, DOMElement $root )
    {
        // Create common HTML headers
        $paragraph = $this->html->createElement( 'p' );
        $root->appendChild( $paragraph );
        $this->visitChilds( $element, $paragraph );
    }

    /**
     * Visit emphasis
     *
     * Emphasis markup is used to emphasize text inside a paragraph and is
     * rendered, depending on the assigned role, as strong or em tags in HTML.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitEmphasis( DOMElement $element, DOMElement $root )
    {
        if ( $element->hasAttribute( 'role' ) &&
             ( $element->getAttribute( 'role' ) === 'strong' ) )
        {
            $emphasis = $this->html->createElement( 'strong' );
        }
        else
        {
            $emphasis = $this->html->createElement( 'em' );
        }

        $root->appendChild( $emphasis );
        $this->visitChilds( $element, $emphasis );
    }

    /**
     * Visit external links
     *
     * Transform external docbook links (<ulink>) to common HTML links.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitExternalLink( DOMElement $element, DOMElement $root )
    {
        $link = $this->html->createElement( 'a' );
        $link->setAttribute( 'href', $element->getAttribute( 'url' ) );
        $root->appendChild( $link );
        $this->visitChilds( $element, $link );
    }

    /**
     * Visit internal links. 
     *
     * Internal links are transformed into local links in HTML, where the name
     * of the target is prefixed with a number sign.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitInternalLink( DOMElement $element, DOMElement $root )
    {
        $link = $this->html->createElement( 'a' );
        $link->setAttribute( 'href', '#' . $element->getAttribute( 'url' ) );
        $root->appendChild( $link );
        $this->visitChilds( $element, $link );
    }

    /**
     * Visit anchor elements
     *
     * Anchor elements are manually added targets inside paragraphs, which are
     * transformed to HTML <a> element targets.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitLinkTarget( DOMElement $element, DOMElement $root )
    {
        $link = $this->html->createElement( 'a' );
        $link->setAttribute( 'name', $element->getAttribute( 'id' ) );
        $root->appendChild( $link );
        $this->visitChilds( $element, $link );
    }

    /**
     * Visit blockquotes
     *
     * Visit blockquotes and transform them their respective HTML elements,
     * including custom markup for attributions, as there is no defined element
     * in HTML for them.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitBlockquote( DOMElement $element, DOMElement $root )
    {
        $quote = $this->html->createElement( 'blockquote' );
        $root->appendChild( $quote );
        
        // Locate optional attribution elements, and transform them below the
        // recursive quote visiting.
        $xpath = new DOMXPath( $element->ownerDocument );
        $attributionNodes = $xpath->query( '*[local-name() = "attribution"]', $element );
        $attributions = array();
        foreach ( $attributionNodes as $node )
        {
            $attributions[] = $node->cloneNode( true );
            $node->parentNode->removeChild( $node );
        }

        // Recursively decorate blockquote, after all attribution nodes are
        // removed
        $this->visitChilds( $element, $quote );

        // Append attribution nodes, if any
        foreach ( $attributions as $attribution )
        {
            $div = $this->html->createElement( 'div' );
            $div->setAttribute( 'class', 'attribution' );
            $quote->appendChild( $div );

            $cite = $this->html->createElement( 'cite' );
            $div->appendChild( $cite );
            $this->visitChilds( $this->html->importNode( $attribution, true ), $cite );
        }
    }

    /**
     * Visit anchor elements
     *
     * Anchor elements are manually added targets inside paragraphs, which are
     * transformed to HTML <a> element targets.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitMediaObject( DOMElement $element, DOMElement $root )
    {
        /*
        $link = $this->html->createElement( 'a' );
        $link->setAttribute( 'name', $element->getAttribute( 'id' ) );
        $root->appendChild( $link );
        $this->visitChilds( $element, $link );
        */
    }
}

?>
