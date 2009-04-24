<?php
/**
 * File containing the ezcDocumentPdfMainRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Main PDF renderer class, dispatching to sub renderer, maintaining page
 * contextes and transactions.
 *
 * Implements the basic page layouting backtracking algorithm.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfMainRenderer extends ezcDocumentPdfRenderer
{
    /**
     * Pages of the rendered document
     * 
     * @var array
     */
    protected $pages;

    /**
     * Hyphenator used to split up words
     * 
     * @var ezcDocumentPdfHyphenator
     */
    protected $hyphenator;

    /**
     * Document to render
     * 
     * @var ezcDocumentDocbook
     */
    protected $document;

    /**
     * Maps document elements to handler functions
     *
     * Maps each document element of the associated namespace to its handler
     * method in the current class.
     * 
     * @var array
     */
    protected $handlerMapping = array(
        'http://docbook.org/ns/docbook' => array(
            'article'     => 'initializeDocument',
            'section'     => 'process',
            'para'        => 'renderParagraph',
            'title'       => 'renderTitle',
            'sectioninfo' => 'ignore',
        ),
    );

    /**
     * Construct renderer from driver to use
     * 
     * @param ezcDocumentPdfDriver $driver 
     * @return void
     */
    public function __construct( ezcDocumentPdfDriver $driver, ezcDocumentPdfStyleInferencer $styles )
    {
        $this->driver = new ezcDocumentPdfTransactionalDriverProxy();
        $this->driver->setDriver( $driver );
        $this->styles = $styles;
        $this->pages  = array();
    }

    /**
     * Render given document
     *
     * Returns the rendered PDF as string
     *
     * @param ezcDocumentDocbook $document 
     * @param ezcDocumentPdfHyphenator $hypenator 
     * @return string
     */
    public function render( ezcDocumentDocbook $document, ezcDocumentPdfHyphenator $hypenator = null )
    {
        $this->hypenator = $hypenator !== null ? $hypenator : new ezcDocumentPdfDefaultHyphenator();
        $this->document  = $document;

        // Inject custom element class, for style inferencing
        $this->document = $document->getDomDocument();
        $this->document->registerNodeClass( 'DOMElement', 'ezcDocumentPdfInferencableDomElement' );

        $this->process( $this->document );
        return $this->driver->save();
    }

    /**
     * Recurse into DOMDocument tree and call appropriate element handlers
     * 
     * @param DOMNode $element 
     * @return void
     */
    protected function process( DOMNode $element )
    {
        foreach ( $element->childNodes as $child )
        {
            if ( $child->nodeType !== XML_ELEMENT_NODE )
            {
                continue;
            }

            if ( !isset( $this->handlerMapping[$child->namespaceURI] ) ||
                 !isset( $this->handlerMapping[$child->namespaceURI][$child->tagName] ) )
            {
                echo "Unknown: {$child->namespaceURI}:{$child->tagName}\n";
                continue;
            }

            $method = $this->handlerMapping[$child->namespaceURI][$child->tagName];
            $this->$method( $child );
        }
    }

    /**
     * Create a new page
     * 
     * @param ezcDocumentPdfInferencableDomElement $element 
     * @return void
     */
    protected function createPage( ezcDocumentPdfInferencableDomElement $element )
    {
        $styles = $this->styles->inferenceFormattingRules( new ezcDocumentPdfPage( 0, 0, 0, 0 ) );
        $this->pages[] = $page = ezcDocumentPdfPage::createFromSpecification(
            $styles['page-size']->value,
            $styles['page-orientation']->value,
            $styles['margin']->value,
            $styles['padding']->value
        );

        // Tell driver about new page
        $this->driver->startTransaction();
        $this->driver->createPage( $page->width, $page->height );
    }

    /**
     * Ignore elements, which should not be rendered
     * 
     * @param ezcDocumentPdfInferencableDomElement $element 
     * @return void
     */
    protected function ignore( ezcDocumentPdfInferencableDomElement $element )
    {
        // Just do nothing.
    }

    /**
     * Initialize document according to detected root node
     * 
     * @param ezcDocumentPdfInferencableDomElement $element 
     * @return void
     */
    protected function initializeDocument( ezcDocumentPdfInferencableDomElement $element )
    {
        $this->createPage( $element );

        // Continiue processing sub nodes
        $this->process( $element );
    }

    /**
     * Handle calls to paragraph renderer
     * 
     * @param ezcDocumentPdfInferencableDomElement $element 
     * @return void
     */
    protected function renderParagraph( ezcDocumentPdfInferencableDomElement $element )
    {
        $renderer = new ezcDocumentPdfParagraphRenderer( $this->driver, $this->styles );

        // Just try to render at current position first
        $trans = $this->driver->startTransaction();
        if ( !$renderer->render( end( $this->pages ), $this->hypenator, $element ) )
        {
            $this->driver->revert( $trans );
        }

        // Then try to move paragraph into next column

        // Then try to move paragraph to next page
    }

    /**
     * Handle calls to paragraph renderer
     * 
     * @param ezcDocumentPdfInferencableDomElement $element 
     * @return void
     */
    protected function renderTitle( ezcDocumentPdfInferencableDomElement $element )
    {
        $renderer = new ezcDocumentPdfTitleRenderer( $this->driver, $this->styles );

        // Just try to render at current position first
        $trans = $this->driver->startTransaction();
        if ( !$renderer->render( end( $this->pages ), $this->hypenator, $element ) )
        {
            $this->driver->revert( $trans );
        }

        // Then try to move paragraph into next column

        // Then try to move paragraph to next page
    }
}

?>
