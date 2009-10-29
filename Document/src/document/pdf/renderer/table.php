<?php
/**
 * File containing the ezcDocumentPdfTextBoxRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Renders a list
 *
 * Tries to render a table into the available space, and aborts if
 * not possible.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfTableRenderer extends ezcDocumentPdfMainRenderer
{
    /**
     * Reference to the main renderer
     * 
     * @var ezcDocumentPdfMainRenderer
     */
    protected $mainRenderer;

    /**
     * Width of current cell
     * 
     * @var flaot
     */
    protected $cellWidth;

    /**
     * Areas covored while rendering a single cell, so that the cell contents 
     * do not get in the way of other cells contents.
     * 
     * @var array
     */
    protected $covered = array();

    /**
     * Construct renderer from driver to use
     *
     * @param ezcDocumentPdfDriver $driver 
     * @param ezcDocumentPcssStyleInferencer $styles 
     * @param ezcDocumentPdfOptions $options 
     * @return void
     */
    public function __construct( ezcDocumentPdfDriver $driver, ezcDocumentPcssStyleInferencer $styles, ezcDocumentPdfOptions $options = null )
    {
        $this->driver         = $driver;
        $this->styles         = $styles;
        $this->options        = $options;
        $this->errorReporting = $options !== null ? $options->errorReporting : 15;
    }

    /**
     * Render a block level element
     *
     * Renders a block level element by applzing margin and padding and
     * recursing to all nested elements.
     *
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentLocateableDomElement $block 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return bool
     */
    public function renderNode( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentLocateableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        $this->hyphenator = $hyphenator;
        $this->tokenizer  = $tokenizer;

        // @TODO: Render border and background. This can be quite hard to
        // estimate, though.
        $styles         = $this->styles->inferenceFormattingRules( $block );
        $page->y       += $styles['padding']->value['top'] +
                          $styles['margin']->value['top'];
        $page->xOffset += $styles['padding']->value['left'] +
                          $styles['margin']->value['left'];
        $page->xReduce += $styles['padding']->value['right'] +
                          $styles['margin']->value['right'];

        $this->mainRenderer = $mainRenderer;
        $this->processTable( $page, $hyphenator, $tokenizer, $block, $mainRenderer );

        $page->y       += $styles['padding']->value['bottom'] +
                          $styles['margin']->value['bottom'];
        $page->xOffset -= $styles['padding']->value['left'] +
                          $styles['margin']->value['left'];
        $page->xReduce -= $styles['padding']->value['right'] +
                          $styles['margin']->value['right'];
        return true;
    }

    /**
     * Calculate text width
     *
     * Calculate the available horizontal space for texts depending on the
     * page layout settings.
     *
     * @param ezcDocumentPdfPage $page
     * @param ezcDocumentLocateableDomElement $text
     * @return float
     */
    public function calculateTextWidth( ezcDocumentPdfPage $page, ezcDocumentLocateableDomElement $text )
    {
        return $this->cellWidth;
    }

    /**
     * Get next rendering position
     *
     * If the current space has been exceeded this method calculates
     * a new rendering position, optionally creates a new page for
     * this, or switches to the next column. The new rendering;
     * position is set on the returned page object.
     *
     * As the parameter you need to pass the required width for the object to
     * place on the page.
     *
     * @param float $move
     * @param float $width
     * @return ezcDocumentPdfPage
     */
    public function _getNextRenderingPosition( $move, $width )
    {
        return $this->driver->currentPage();
    }

    /**
     * Render a single table cell
     * 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentLocateableDomElement $cell 
     * @param array $styles 
     * @param ezcDocumentPdfBoundingBox $space 
     * @param float $start 
     * @param float $width 
     * @return void
     */
    protected function renderCell( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentLocateableDomElement $cell, array $styles, ezcDocumentPdfBoundingBox $space, $start, $width )
    {
        $this->covered = array();

        // Mark space used, which will be covered by the other table cells
        if ( $start > 0 )
        {
            $this->covered[] = $page->setCovered( new ezcDocumentPdfBoundingBox(
                $space->x,
                $space->y,
                $space->width * $start,
                $page->height
            ) );
        }

        if ( $start + $width < 1 )
        {
            $this->covered[] = $page->setCovered( new ezcDocumentPdfBoundingBox(
                $space->x + $space->width * ( $start + $width ),
                $space->y,
                $space->width * ( 1 - ( $start + $width ) ),
                $page->height
            ) );
        }

        $page->x = $space->x + $start * $space->width;
        $page->y = $space->y;
        $this->cellWidth = $width * $space->width;
        $this->process( $cell );
        $page->x = $space->x;

        foreach ( $this->covered as $nr => $id )
        {
            $page->uncover( $id );
            unset( $this->covered[$nr] );
        }
    }

    /**
     * Process to render the table into its boundings
     * 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentLocateableDomElement $block 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return void
     */
    protected function processTable( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentLocateableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        $tableColumnWidths = $this->options->tableColumnWidthCalculator->estimateWidths( $block );
        $styles            = $this->styles->inferenceFormattingRules( $block );
        $renderWidth       = $mainRenderer->calculateTextWidth( $page, $block );

        $xpath = new DOMXPath( $block->ownerDocument );
        foreach ( $xpath->query( './*/*/*[local-name() = "row"] | ./*/*[local-name() = "row"]', $block ) as $row )
        {
            $space = $this->evaluateAvailableBoundingBox( $page, $styles, $renderWidth );

            $xPos = 0;
            foreach ( $xpath->query( './*[local-name() = "entry"]', $row ) as $nr => $cell )
            {
                $this->renderCell( $page, $hyphenator, $tokenizer, $cell, $styles, $space, $xPos, $tableColumnWidths[$nr] );
                $xPos += $tableColumnWidths[$nr];
            }
        }
    }
}

?>
