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
        'itemizedlist'      => 'visitWithMapper',
        'orderedlist'       => 'visitWithMapper',
        'listitem'          => 'visitWithMapper',
        'note'              => 'visitSpecialParagraphs',
        'tip'               => 'visitSpecialParagraphs',
        'warning'           => 'visitSpecialParagraphs',
        'important'         => 'visitSpecialParagraphs',
        'caution'           => 'visitSpecialParagraphs',
        'literallayout'     => 'visitLiteralLayout',
        'footnote'          => 'visitFootnote',
        'comment'           => 'visitComment',
        'beginpage'         => 'visitWithMapper',
        'variablelist'      => 'visitWithMapper',
        'varlistentry'      => 'visitDefinitionListEntries',
        'entry'             => 'visitTableCells',
        'table'             => 'visitWithMapper',
        'tbody'             => 'visitWithMapper',
        'thead'             => 'visitWithMapper',
        'row'               => 'visitWithMapper',
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
        'literal'      => 'code',
        'itemizedlist' => 'ul',
        'orderedlist'  => 'ol',
        'listitem'     => 'li',
        'beginpage'    => 'hr',
        'variablelist' => 'dl',
        'table'        => 'table',
        'tbody'        => 'tbody',
        'thead'        => 'thead',
        'row'          => 'tr',
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
     * Array for footnotes aggregated during the processing of the document.
     * Will be rendered at the end of the HTML document.
     * 
     * @var array
     */
    protected $footnotes = array();

    /**
     * Autoincrementing number for footnotes.
     * 
     * @var int
     */
    protected $footnoteNumber = 0;

    /**
     * Element name mapping for meta information in the docbook document to
     * HTML meta element names.
     *
     * @TODO: Complete list.
     * 
     * @var array
     */
    protected $headerMapping = array(
        'abstract'    => 'description',
        'releaseinfo' => 'version',
        'pubdate'     => 'date',
        'date'        => 'date',
        'author'      => 'author',
        'publisher'   => 'author',
    );

    /**
     * Element name mapping for meta information in the docbook document to
     * HTML meta element names, using the dublin core extensions for meta
     * elements.
     *
     * @TODO: Complete list.
     * 
     * @var array
     */
    protected $dcHeaderMapping = array(
        'abstract'  => 'dc.description',
        'pubdate'   => 'dc.date',
        'date'      => 'dc.date',
        'author'    => 'dc.creator',
        'publisher' => 'dc.publisher',
        'contrib'   => 'dc.contributor',
        'copyright' => 'dc.rights',
    );

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
        $imp = new DOMImplementation();
        $dtd = $imp->createDocumentType( 'html', '-//W3C//DTD XHTML 1.0 Transitional//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd' );
        $this->html = $imp->createDocument( 'http://www.w3.org/1999/xhtml', '', $dtd );
        $this->html->formatOutput = true;

        $root = $this->html->createElementNs( 'http://www.w3.org/1999/xhtml', 'html' );
        $this->html->appendChild( $root );

        $this->head = $this->html->createElement( 'head' );
        $root->appendChild( $this->head );

        // Append generator
        $generator = $this->html->createElement( 'meta' );
        $generator->setAttribute( 'name', 'generator' );
        $generator->setAttribute( 'content', 'eZ Components; http://ezcomponents.org' );
        $this->head->appendChild( $generator );

        // Set content type and encoding
        $type = $this->html->createElement( 'meta' );
        $type->setAttribute( 'http-equiv', 'Content-Type' );
        $type->setAttribute( 'content', 'text/html; charset=utf-8' );
        $this->head->appendChild( $type );

        $this->addStylesheets( $this->head );

        $body = $this->html->createElement( 'body' );
        $root->appendChild( $body );

        $this->visitChilds( $doc->getDomDocument(), $body );
        $this->appendFootnotes( $body );

        // Ensure a title is set in the document header, as this is required by
        // XHtml
        $xpath = new DOMXPath( $this->html );
        $title = $xpath->query( '/*[local-name() = "html"]/*[local-name() = "head"]/*[local-name() = "title"]' );
        if ( $title->length < 1 )
        {
            $title = $this->html->createElement( 'title', 'Empty document' );
            $this->head->appendChild( $title );
        }

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
     * Add stylesheets to header
     * 
     * @param DOMElement $head 
     * @return void
     */
    protected function addStylesheets( DOMElement $head )
    {
        if ( $this->options->styleSheets !== null )
        {
            foreach ( $this->options->styleSheets as $styleSheet )
            {
                $link = $this->html->createElement( 'link' );
                $link->setAttribute( 'rel', 'Stylesheet' );
                $link->setAttribute( 'type', 'text/css' );
                $link->setAttribute( 'href', htmlspecialchars( $styleSheet ) );
                $head->appendChild( $link );
            }
        }
        else
        {
            $style = $this->html->createElement( 'style' );
            $style->setAttribute( 'type', 'text/css' );
            $head->appendChild( $style );
            
            $cdata = $this->html->createCDATASection( $this->options->styleSheet );
            $style->appendChild( $cdata );
        }
    }

    /**
     * Append footnotes
     *
     * Append the footnotes to the end of the document. The footnotes are
     * embedded directly in the text in docbook, aggregated during the
     * processing of the document, and displayed at the bottom of the HTML
     * document.
     * 
     * @param DOMElement $root 
     * @return void
     */
    protected function appendFootnotes( DOMElement $root )
    {
        if ( !count( $this->footnotes ) )
        {
            // Do not do anything, if there aren't any footnotes.
            return;
        }

        $footnoteContainer = $this->html->createElement( 'ul' );
        $footnoteContainer->setAttribute( 'class', 'footnotes' );
        $root->appendChild( $footnoteContainer );

        foreach ( $this->footnotes as $nr => $element )
        {
            $li = $this->html->createElement( 'li' );
            $footnoteContainer->appendChild( $li );

            $reference = $this->html->createElement( 'a', $nr );
            $reference->setAttribute( 'name', 'footnote_' . $nr );
            $li->appendChild( $reference );

            // Visit actual footnote contents and append to the footnote.
            $this->visitChilds( $element, $li );
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
        $headerMapping = $this->options->dublinCoreMetadata ? $this->dcHeaderMapping : $this->headerMapping;
       
        foreach ( $headerMapping as $tagName => $metaName )
        {
            if ( ( $nodes = $element->getElementsBytagName( $tagName ) ) &&
                 ( $nodes->length > 0 ) )
            {
                foreach ( $nodes as $node )
                {
                    $meta = $this->html->createElement( 'meta' );
                    $meta->setAttribute( 'name', $metaName );
                    $meta->setAttribute( 'content', htmlspecialchars( trim( $node->textContent ) ) );
                    $this->head->appendChild( $meta );
                }
            }
        }
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
        // Do not stack paragraphs
        if ( $root->tagName !== 'p' )
        {
            $paragraph = $this->html->createElement( 'p' );
            $root->appendChild( $paragraph );
            $this->visitChilds( $element, $paragraph );
        }
        else
        {
            $this->visitChilds( $element, $root );
        }
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
        $link->setAttribute( 'href', urlencode( $element->getAttribute( 'url' ) ) );
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
        $link->setAttribute( 'href', '#' . $element->getAttribute( 'linked' ) );
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

            $cite = $this->html->createElement( 'cite', htmlspecialchars( $attribution->textContent ) );
            $div->appendChild( $cite );
//            $this->visitChilds( $this->html->importNode( $attribution, true ), $cite );
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
        // Get image resource
        $resource = $element->getElementsBytagName( 'imagedata' )->item( 0 );
        
        $image = $this->html->createElement( 'img' );

        // Transform attributes
        $attributes = array(
            'width'   => 'width',
            'depth'   => 'height',
            'fileref' => 'src',
        );
        foreach ( $attributes as $src => $dst )
        {
            if ( $resource->hasAttribute( $src ) )
            {
                $image->setAttribute( $dst, htmlspecialchars( $resource->getAttribute( $src ) ) );
            }
        }

        // Check if the image has a description
        if ( ( $textobject = $element->getElementsBytagName( 'textobject' ) ) &&
               ( $textobject->length > 0 ) )
        {
            $image->setAttribute( 'alt', htmlspecialchars( trim( $textobject->item( 0 )->textContent ) ) );
        }
        else
        {
            // Always set some alt value, as this is required by XHtml
            $image->setAttribute( 'alt', htmlspecialchars( $resource->getAttribute( 'src' ) ) );
        }

        // Check if the image has additional description assigned. In such a
        // case we wrap the image and the text inside another block.
        if ( ( $textobject = $element->getElementsBytagName( 'caption' ) ) &&
               ( $textobject->length > 0 ) )
        {
            $textobject = $textobject->item( 0 );
            $wrapper = $this->html->createElement( 'div' );
            $wrapper->setAttribute( 'class', 'image' );
            $wrapper->appendChild( $image );

            // Decorate the childs of the caption node recursively, as it might
            // contain additional markup.
            $this->visitChilds( $textobject, $wrapper );
            $image = $wrapper;
        }

        $root->appendChild( $image );
    }

    /**
     * Visit special paragraphs
     *
     * Transform the paragraphs with special annotations like <note> and
     * <caution> to paragraphs inside the HTML document with a class
     * representing the meaning of the docbook elements. The mapping which is
     * used inside this method is used throughout the document comoponent and
     * compatible with the RTS mapping.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitSpecialParagraphs( DOMElement $element, DOMElement $root )
    {
        $types = array(
            'note'      => 'note',
            'tip'       => 'notice',
            'warning'   => 'warning',
            'important' => 'attention',
            'caution'   => 'danger',
        );

        $type = $types[$element->tagName];
        $paragraph = $this->html->createElement( 'p' );
        $paragraph->setAttribute( 'class', $type );
        $root->appendChild( $paragraph );
        $this->visitChilds( $element, $paragraph );
    }

    /**
     * Visit footnotes
     *
     * Footnotes in docbook are emebdded at the position, the reference should
     * occur. We store the contents, to be rendered at the end of the HTML
     * document, and only render a number referencing the actual footnote at
     * the position of the footnote in the docbook document.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitFootnote( DOMElement $element, DOMElement $root )
    {
        $this->footnotes[++$this->footnoteNumber] = $element->cloneNode( true );

        $footnoteReference = $this->html->createElement( 'a', $this->footnoteNumber );
        $footnoteReference->setAttribute( 'class', 'footnote' );
        $footnoteReference->setAttribute( 'href', '#footnote_' . $this->footnoteNumber );
        $root->appendChild( $footnoteReference );
    }

    /**
     * Visit docbook comment
     *
     * Transform docbook comments into HTML ( / XML ) comments.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitComment( DOMElement $element, DOMElement $root )
    {
        $comment = new DOMComment( htmlspecialchars( $element->textContent ) );
        $root->appendChild( $comment );
    }

    /**
     * Visit definition list entries
     *
     * Definition list entries are encapsulated in docbook, while the HTML
     * variant only consists of a list of terms and their description. This
     * method transforms the elements accordingly.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitDefinitionListEntries( DOMElement $element, DOMElement $root )
    {
        foreach ( $element->childNodes as $child )
        {
            if ( ( $child->nodeType === XML_ELEMENT_NODE ) &&
                 ( ( $child->tagName === 'term' ) || 
                   ( $child->tagName === 'listitem' ) ) )
            {
                $node = $this->html->createElement( $child->tagName === 'term' ? 'dt' : 'dd' );
                $root->appendChild( $node );
                $this->visitChilds( $child, $node );
            }
        }
    }

    /**
     * Visit literallayout elements
     *
     * Literallayout elements are used for code blocks in docbook, where
     * normally some fixed width font is used, but also for poems or simliarly
     * formatted texts. In HTML those are represented by entirely different
     * structures. Code blocks will be transformed into <pre> elements, while
     * poem like texts will be handled by a <p> element, in which each line is
     * seperated by <br> elements.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitLiteralLayout( DOMElement $element, DOMElement $root )
    {
        if ( !$element->hasAttribute( 'class' ) ||
             ( $element->getAttribute( 'class' ) !== 'Normal' ) )
        {
            // This is "just" a code block
            $code = $this->html->createElement( 'pre' );
            $root->appendChild( $code );
            $this->visitChilds( $element, $code );
        }
        else
        {
            $paragraph = $this->html->createElement( 'p' );
            $paragraph->setAttribute( 'class', 'lineblock' );

            $textLines = preg_split( '(\r\n|\r|\n)', $element->textContent );
            foreach ( $textLines as $line )
            {
                // Replace space by non-breaking spaces, as this is how it is
                // supposed to be rendered.
                $line = new DOMText( str_replace( ' ', "\xc2\xa0", $line ) );
                $paragraph->appendChild( $line );

                $break = $this->html->createElement( 'br' );
                $paragraph->appendChild( $break );
            }

            $root->appendChild( $paragraph );
        }
    }

    /**
     * Visit table cells
     *
     * Table cells are quite trivial to transform, but some attributes need to
     * be converted, like rowspan.
     * 
     * @param DOMElement $element 
     * @param DOMElement $root 
     * @return void
     */
    protected function visitTableCells( DOMElement $element, DOMElement $root )
    {
        $cell = $this->html->createElement( 'td' );

        if ( $element->hasAttribute( 'morerows' ) )
        {
            $cell->setAttribute( 'rowspan', $element->getAttribute( 'morerows' ) + 1 );
        }

        $root->appendChild( $cell );
        $this->visitChilds( $element, $cell );
    }
}

?>
