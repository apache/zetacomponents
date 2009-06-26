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
class ezcDocumentPdfMainRenderer extends ezcDocumentPdfRenderer implements ezcDocumentErrorReporting
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
     * Errors occured during the conversion process
     * 
     * @var array
     */
    protected $errors = array();

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
            'mediaobject' => 'renderMediaObject',
            'sectioninfo' => 'ignore',
        ),
    );

    /**
     * Additional PDF parts.
     *
     * @var array
     */
    protected $parts = array();

    /**
     * Error reporting level
     * 
     * @var int
     */
    protected $errorReporting = 15;

    /**
     * Construct renderer from driver to use
     *
     * @param ezcDocumentPdfDriver $driver
     * @return void
     */
    public function __construct( ezcDocumentPdfDriver $driver, ezcDocumentPdfStyleInferencer $styles, $errorReporting = 15 )
    {
        $this->driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $this->driver->setDriver( $driver );
        $this->styles = $styles;
        $this->errorReporting = $errorReporting;
    }

    /**
     * Trigger visitor error
     *
     * Emit a vistitor error, and convert it to an exception depending on the
     * error reporting settings.
     *
     * @param int $level
     * @param string $message
     * @param string $file
     * @param int $line
     * @param int $position
     * @return void
     */
    public function triggerError( $level, $message, $file = null, $line = null, $position = null )
    {
        if ( $level & $this->errorReporting )
        {
            throw new ezcDocumentVisitException( $level, $message, $file, $line, $position );
        }
        else
        {
            // If the error should not been reported, we aggregate it to maybe
            // display it later.
            $this->errors[] = new ezcDocumentVisitException( $level, $message, $file, $line, $position );
        }
    }

    /**
     * Return list of errors occured during visiting the document.
     *
     * May be an empty array, if on errors occured, or a list of
     * ezcDocumentVisitException objects.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Tries to locate a file
     *
     * Tries to locate a file, referenced in a docbook document. If available
     * the document path is used a base for relative paths.
     *
     * @param string $file
     * @return string
     */
    public function locateFile( $file )
    {
        if ( !ezcBaseFile::isAbsolutePath( $file ) )
        {
            $file = $this->document->getPath() . $file;
        }

        if ( !is_file( $file ) )
        {
            throw new ezcBaseFileNotFoundException( $file );
        }

        return $file;
    }

    /**
     * Register an additional PDF part
     *
     * Register additional parts, like footnotes, headers or title pages.
     *
     * @param ezcDocumentPdfPart $part
     * @return void
     */
    public function registerPdfPart( ezcDocumentPdfPart $part )
    {
        $this->parts[] = $part;
        $part->registerContext( $this, $this->driver, $this->styles );
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
        $dom = $document->getDomDocument();

        // Reload the XML document with to a DOMDocument with a custom element
        // class. Just registering it on the existing document seems not to
        // work in all cases.
        $reloaded = new DOMDocument();
        $reloaded->registerNodeClass( 'DOMElement', 'ezcDocumentPdfInferencableDomElement' );
        $reloaded->loadXml( $dom->saveXml() );

        $this->process( $reloaded );
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
     * @param float $move
     * @param float $width
     * @return bool
     */
    public function checkSkipPrerequisites( $move, $width )
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
        $this->getNextRenderingPosition( $move, $width );
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
     * @param float $move
     * @param float $width
     * @return ezcDocumentPdfPage
     */
    public function getNextRenderingPosition( $move, $width )
    {
        // Then move paragraph into next column / page;
        $trans = $this->driver->startTransaction();
        $page  = $this->driver->currentPage();
        if ( ( ( $newX = $page->x + $move ) < ( $page->startX + $page->innerWidth ) ) &&
             ( ( $space = $page->testFitRectangle( $newX, null, $width, 2 ) ) !== false ) )
        {
            // Another column fits on the current page, find starting Y
            // position
            $page->x = $space->x;
            $page->y = $space->y;

            return $page;
        }

        // If there is no space for a new column, create a new page
        $page = $this->driver->appendPage( $this->styles );
        foreach ( $this->parts as $part )
        {
            $part->hookPageCreation( $page );
        }
        return $page;
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

            // Default to docbook namespace, if no namespace is defined
            $namespace = $child->namespaceURI === null ? 'http://docbook.org/ns/docbook' : $child->namespaceURI;

            if ( !isset( $this->handlerMapping[$namespace] ) ||
                 !isset( $this->handlerMapping[$namespace][$child->tagName] ) )
            {
                $this->triggerError(
                    E_NOTICE,
                    "Unknown and unhandled element: {$namespace}:{$child->tagName}."
                );
                continue;
            }

            $method = $this->handlerMapping[$namespace][$child->tagName];
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
        // Call hooks for started document
        foreach ( $this->parts as $part )
        {
            $part->hookDocumentCreation( $element );
        }

        $page = $this->driver->appendPage( $this->styles );
        // Call hooks for fresh new first page
        foreach ( $this->parts as $part )
        {
            $part->hookPageCreation( $page );
        }

        // Continue processing sub nodes
        $this->process( $element );

        // Call hooks for finished document
        foreach ( $this->parts as $part )
        {
            $part->hookDocumentRendering( $element );
        }
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
        $styles   = $this->styles->inferenceFormattingRules( $element );

        // Just try to render at current position first
        $trans = $this->driver->startTransaction();
        if ( $renderer->render( $page, $this->hypenator, $element, $this ) )
        {
            $this->titleTransaction = null;
            return true;
        }

        // Check if something requested a rendering restart at a prior point,
        // only continue otherwise.
        if ( ( $this->restart !== false ) ||
             ( !$this->checkSkipPrerequisites(
                    ( $pWidth = $renderer->calculateTextWidth( $page, $element ) ) +
                    $styles['text-column-spacing']->value,
                    $pWidth
                ) ) )
        {
            return false;
        }

        // If that did not work, switch to the next possible location and start
        // there.
        $this->driver->revert( $trans );
        $this->getNextRenderingPosition(
            ( $pWidth = $renderer->calculateTextWidth( $page, $element ) ) +
            $styles['text-column-spacing']->value,
            $pWidth
        );
        return $this->renderParagraph( $element );
    }

    /**
     * Handle calls to title renderer
     *
     * @param ezcDocumentPdfInferencableDomElement $element
     * @return void
     */
    protected function renderTitle( ezcDocumentPdfInferencableDomElement $element, $position )
    {
        $styles   = $this->styles->inferenceFormattingRules( $element );
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

        $this->getNextRenderingPosition(
            ( $pWidth = $renderer->calculateTextWidth( $page, $element ) ) +
            $styles['text-column-spacing']->value,
            $pWidth
        );
        return $this->renderTitle( $element, $position );
    }

    /**
     * Handle calls to media object renderer
     *
     * @param ezcDocumentPdfInferencableDomElement $element
     * @return void
     */
    protected function renderMediaObject( ezcDocumentPdfInferencableDomElement $element )
    {
        $renderer = new ezcDocumentPdfMediaObjectRenderer( $this->driver, $this->styles );
        $page     = $this->driver->currentPage();

        // Just try to render at current position first
        $trans = $this->driver->startTransaction();
        $renderer->render( $page, $this->hypenator, $element, $this );
    }
}

?>
