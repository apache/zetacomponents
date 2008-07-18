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
        $this->document->loadXml( $string );

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
        $docbook = new DOMDocument();
        $docbook->preserveWhiteSpace = false;
        $docbook->formatOutput = true;

        $root = $docbook->createElementNs( 'http://docbook.org/ns/docbook', 'article' );
        $docbook->appendChild( $root );

        $this->transformToDocbook( $document->firstChild, $root );

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
                    $text = new DOMText( $child->wholeText );
                    $docbook->appendChild( $text );
                    break;
                
                case XML_CDATA_SECTION_NODE:
                    $data = new DOMCharacterData();
                    $data->appendData( $child->data );
                    $docbook->appendChild( $data );
                    break;

                case XML_ENTITY_NODE:
                    // @TODO: Implement
                    break;

                case XML_COMMENT_NODE:
                    $comment = new DOMComment( $child->data );
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
}

?>
