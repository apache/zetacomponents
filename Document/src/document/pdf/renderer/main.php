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
     * Last transactions started before rendering a new title. This is used to
     * determine, if a title is positioned as a single item in a column or on a
     * page and switch it to the next page in this case.
     * 
     * @var mixed
     */
    protected $titleTransaction = null;

    /**
     * Indicator to restart rendering with an earlier item on the same level in
     * the DOM document tree.
     * 
     * @var mixed
     */
    protected $restart = false;

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
        $this->driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $this->driver->setDriver( $driver );
        $this->styles = $styles;
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
     * Check column or page skip prerequisite
     *
     * If no content has been rendered any more in the current column, this
     * method should be called to check prerequisite for the skip, which is
     * especially important for already rendered items, which impose
     * assumptions on following contents.
     *
     * One example for this are titles, which should always be followed by at
     * least some content in the same column.
     *
     * Returns false, if prerequisite are not fulfileld and rendering should be
     * aborted.
     * 
     * @param float $width
     * @return bool
     */
    public function checkSkipPrerequisites( $width )
    {
        // Ensure the paragraph is on the same page / in the same column
        // like a title, of it is the first paragraph
        if ( $this->titleTransaction === null )
        {
            return true;
        }

        $this->driver->revert( $this->titleTransaction['transaction'] );

        // The rendering should now start again with the title on the
        // next column / page.
        $this->getNextRenderingPosition( $width );
        $this->restart = $this->titleTransaction['position'] - 1;

        $this->titleTransaction = null;
        return false;
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
        // Then move paragraph into next column / page;
        $trans = $this->driver->startTransaction();
        $page  = $this->driver->currentPage();
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
        return $this->driver->appendPage( $this->styles );
    }

    /**
     * Recurse into DOMDocument tree and call appropriate element handlers
     * 
     * @param DOMNode $element 
     * @return void
     */
    protected function process( DOMNode $element )
    {
        $childNodes = $element->childNodes;
        $nodeCount  = $childNodes->length;

        for ( $i = 0; $i < $nodeCount; ++$i )
        {
            $child = $childNodes->item( $i );
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
            $this->$method( $child, $i );

            // Check if the rendering process should be restarted at an earlier
            // point
            if ( $this->restart !== false )
            {
                $i = $this->restart;
                $this->restart = false;
            }
        }
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
        $this->driver->appendPage( $this->styles );

        // Continue processing sub nodes
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
        $page     = $this->driver->currentPage();

        // Just try to render at current position first
        $trans = $this->driver->startTransaction();
        if ( $renderer->render( $page, $this->hypenator, $element, $this ) )
        {
            return true;
        }
        $this->driver->revert( $trans );

        // Check if something requested a rendering restart at a prior point,
        // only continue otherwise.
        if ( ( $this->restart !== false ) ||
             ( !$this->checkSkipPrerequisites( $renderer->calculateTextWidth( $page, $element ) ) ) )
        {
            return false;
        }

        // If that did not work, switch to the next possible location and start
        // there.
        $this->getNextRenderingPosition( $renderer->calculateTextWidth( $page, $element ) );
        return $this->renderParagraph( $element );
    }

    /**
     * Handle calls to paragraph renderer
     * 
     * @param ezcDocumentPdfInferencableDomElement $element 
     * @return void
     */
    protected function renderTitle( ezcDocumentPdfInferencableDomElement $element, $position )
    {
        $renderer = new ezcDocumentPdfTitleRenderer( $this->driver, $this->styles );
        $page     = $this->driver->currentPage();

        // Just try to render at current position first
        $this->titleTransaction = array(
            'transaction' => $this->driver->startTransaction(),
            'page'        => $page,
            'xPos'        => $page->x,
            'position'    => $position,
        );
        if ( $renderer->render( $page, $this->hypenator, $element, $this ) )
        {
            return true;
        }
        $this->driver->revert( $this->titleTransaction['transaction'] );

        $this->getNextRenderingPosition( $renderer->calculateTextWidth( $page, $element ) );
        return $this->renderTitle( $element, $position );
    }
}

?>
