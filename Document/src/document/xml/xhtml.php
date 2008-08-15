<?php
/**
 * File containing the ezcDocumentXhtml class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The document handler for XHTML document markup.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentXhtml extends ezcDocumentXmlBase
{
    /**
     * Array with filter objects for the input HTML document.
     * 
     * @var array(ezcDocumentXhtmlFilter)
     */
    protected $filters;
    
    /**
     * Construct document xml base.
     * 
     * @ignore
     * @param ezcDocumentXhtmlOptions $options
     * @return void
     */
    public function __construct( ezcDocumentXhtmlOptions $options = null )
    {
        parent::__construct( $options === null ?
            new ezcDocumentXhtmlOptions() :
            $options );

        $this->filters = array(
            new ezcDocumentXhtmlElementFilter(),
            new ezcDocumentXhtmlMetadataFilter(),
        );
    }

    /**
     * Create document from input string
     * 
     * Create a document of the current type handler class and parse it into a
     * usable internal structure.
     *
     * @param string $string 
     * @return void
     */
    public function loadString( $string )
    {
        // Use internal error handling to handle XML errors manually.
        $oldXmlErrorHandling = libxml_use_internal_errors( true );
        libxml_clear_errors();

        // Load XML document
        $this->document = new DOMDocument();
        $this->document->registerNodeClass( 'DOMElement', 'ezcDocumentXhtmlDomElement' );

        // Use the loadHtml method here, as it for example convers tag names
        // and attribute names to lower case, and handles some more errors
        // common in HTML documents.
        $this->document->loadHtml( $string );

        $errors = ( $this->options->failOnError ?
            libxml_get_errors() :
            null );

        libxml_clear_errors();
        libxml_use_internal_errors( $oldXmlErrorHandling );

        // If there are errors and the error handling is activated throw an
        // exception with the occured errors.
        if ( $errors )
        {
            throw new ezcDocumentErrnousXmlException( $errors );
        }
    }

    /**
     * Set filters
     *
     * Set an array with filter objects, which extract the sematic
     * information from the given XHtml document.
     * 
     * @param array $filters 
     * @return void
     */
    public function setFilters( array $filters )
    {
        $this->filters = $filters;
    }

    /**
     * Build docbook document out of annotated XHtml document
     * 
     * @param DOMDocument $document 
     * @return DOMDocument
     */
    protected function buildDocbookDocument( DOMDocument $document )
    {
        $docbook = new DOMDocument( '1.0', 'utf-8' );
        $docbook->preserveWhiteSpace = false;
        $docbook->formatOutput = true;

        $root = $docbook->createElementNs( 'http://docbook.org/ns/docbook', 'article' );
        $docbook->appendChild( $root );

        $xpath = new DOMXPath( $document );
        $html = $xpath->query( '/*[local-name() = "html"]' )->item( 0 );
        $this->transformToDocbook( $html, $root );

        return $docbook;
    }

    /**
     * Recursively transform annotated XHtml elements to docbook
     * 
     * @param DOMElement $xhtml 
     * @param DOMElement $docbook 
     * @return void
     */
    protected function transformToDocbook( DOMElement $xhtml, DOMElement $docbook )
    {
        if ( ( $tagName = $xhtml->getProperty( 'type' ) ) !== false )
        {
            $node = new DOMElement( $tagName );
            $docbook->appendChild( $node );
            $docbook = $node;

            if ( ( $attributes = $xhtml->getProperty( 'attributes' ) ) !== false )
            {
                foreach ( $attributes as $name => $value )
                {
                    $node->setAttribute( $name, htmlspecialchars( $value ) );
                }
            }
        }

        foreach ( $xhtml->childNodes as $child )
        {
            switch ( $child->nodeType )
            {
                case XML_ELEMENT_NODE:
                    $this->transformToDocbook( $child, $docbook );
                    break;
                
                case XML_TEXT_NODE:
                    // Skip pure whitespace text nodes
                    if ( trim( $child->wholeText ) !== '' )
                    {
                        $text = new DOMText( $child->wholeText );
                        $docbook->appendChild( $text );
                    }
                    break;
                
                case XML_CDATA_SECTION_NODE:
//                    $data = new DOMCharacterData();
//                    $data->appendData( $child->data );
//                    $docbook->appendChild( $data );
                    break;

                case XML_ENTITY_NODE:
                    // Seems not required, as entities in the source document
                    // are automatically transformed back to their text
                    // targets.
                    break;

                case XML_COMMENT_NODE:
                    // Ignore comments
                    break;

                    $comment = new DOMElement( 'comment', $child->data );
                    $docbook->appendChild( $comment );
                    break;
            }
        }
    }

    /**
     * Return document compiled to the docbook format
     * 
     * The internal document structure is compiled to the docbook format and
     * the resulting docbook document is returned.
     *
     * This method is required for all formats to have one central format, so
     * that each format can be compiled into each other format using docbook as
     * an intermediate format.
     *
     * You may of course just call an existing converter for this conversion.
     *
     * @return ezcDocumentDocbook
     */
    public function getAsDocbook()
    {
        foreach ( $this->filters as $filter )
        {
            $filter->filter( $this->document );
        }

        $docbook = new ezcDocumentDocbook();
        $docbook->setDomDocument(
            $this->buildDocbookDocument( $this->document )
        );
        return $docbook;
    }

    /**
     * Create document from docbook document
     *
     * A document of the docbook format is provided and the internal document
     * structure should be created out of this.
     *
     * This method is required for all formats to have one central format, so
     * that each format can be compiled into each other format using docbook as
     * an intermediate format.
     *
     * You may of course just call an existing converter for this conversion.
     * 
     * @param ezcDocumentDocbook $document 
     * @return void
     */
    public function createFromDocbook( ezcDocumentDocbook $document )
    {
        // @TODO: Implement
    }

    /**
     * Return document as string
     * 
     * Serialize the document to a string an return it.
     *
     * @return string
     */
    public function save()
    {
        $source = $this->document->saveXml( $this->document, LIBXML_NOEMPTYTAG );

        // Append DOCTYPE to document, as this is not possible using the DOM
        // API we do this with a regular expression hack.
        return preg_replace( 
            '(^<\\?xml[^>]*>(?:\r\n|\r|\n)?)', 
            ( $this->options->xmlHeader ? "\\0" : '' ) .
            ( $this->options->doctype ? $this->options->doctype . "\n" : '' ),
            $source
        );
    }
}

?>
