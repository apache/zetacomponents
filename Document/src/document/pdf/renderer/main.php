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
     * Get next rendering position
     *
     * If the current space has been exceeded this method calculates
     * a new rendering position, optionally creates a new page for
     * this, or switches to the next column. The new rendering
     * position is set on the returned page object.
     *
     * As the parameter you need to pass the required width for the object to
     * place on the page.
     * 
     * @param float $width
     * @return ezcDocumentPdfPage
     */
    public function getNextRenderingPosition( $width )
    {
        // Then move paragraph into next column / page
        $trans = $this->driver->startTransaction();
        $page  = end( $this->pages );
        if ( ( ( $newX = $page->x + $width ) < $page->innerWidth ) &&
             ( ( $space = $page->testFitRectangle( $newX, null, $width, 2 ) ) !== false ) )
        {
            // Another column fits on the current page, find starting Y
            // position
            $page->x = $space->x;
            $page->y = $space->y;

            return $page;
        }

        // If there is no space for a new column, create a new page
        return $this->createPage();
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
     * @return ezcDocumentPdfPage
     */
    protected function createPage()
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

        return $page;
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
        $this->createPage();

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
        $page     = end( $this->pages );

        // Just try to render at current position first
        $trans = $this->driver->startTransaction();
        if ( $renderer->render( $page, $this->hypenator, $element, $this ) )
        {
            return true;
        }
        $this->driver->revert( $trans );

        // If that did not work, switch to the next possible location and start
        // there.
        // @TODO: Implement
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
        $page     = end( $this->pages );

        // Just try to render at current position first
        $trans = $this->driver->startTransaction();
        if ( $renderer->render( $page, $this->hypenator, $element, $this ) )
        {
            return true;
        }
        $this->driver->revert( $trans );

        // Then move paragraph into next column / page
        $trans = $this->driver->startTransaction();
        if ( ( $newX = $renderer->getNextColumnPosition( $page, $element, $page->x ) ) !== false )
        {
            $page->showCoveredAreas( $this->driver );

            // Find new y position
            $space = $page->testFitRectangle( $newX, null, 1, 1 );
            $page->x = $space->x;
            $page->y = $space->y;

            return $this->renderParagraph( $element );
        }
        $this->driver->revert( $trans );

        // If there is no space for a new column, create a new page
        $this->createPage();
        $this->renderTitle( $element );
    }
}

?>
