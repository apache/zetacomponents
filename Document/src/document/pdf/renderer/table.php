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
     * Boxes for all currently drawn cells so their border can be renderer once 
     * the row baseline is known.
     * 
     * @var array
     */
    protected $cellBoxes = array();

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
        // @TODO: Implement
        // @TODO: This needs to implement the rendering of side borders on page 
        // wrapping (for cells and tables).
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
        $styles        = $this->styles->inferenceFormattingRules( $cell );
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

        // Evaluate available space for box
        $page->x = $space->x + $start * $space->width;
        $page->y = $space->y;

        $this->cellBoxes[] = array(
            'box'    => $box = $this->evaluateAvailableBoundingBox( $page, $styles, $width * $space->width ),
            'styles' => $styles,
        );
        $this->cellWidth = $box->width;
        $this->renderTopBorder( $styles, $box );

        // Render cell contents
        $page->x = $box->x;
        $page->y = $box->y;
        $this->process( $cell );
        $page->x = $space->x;

        foreach ( $this->covered as $nr => $id )
        {
            $page->uncover( $id );
            unset( $this->covered[$nr] );
        }

        return $page->y;
    }

    /**
     * Render top border
     *
     * Render the top border of the given space
     * 
     * @param array $styles 
     * @param ezcDocumentPdfBoundingBox $space 
     * @return void
     */
    protected function renderTopBorder( array $styles, ezcDocumentPdfBoundingBox $space )
    {
        $topLeft = array(
            $space->x -
                $styles['padding']->value['left'] -
                $styles['border']->value['left']['width'] / 2,
            $space->y -
                $styles['padding']->value['top'] -
                $styles['border']->value['top']['width'] / 2,
        );
        $topRight = array(
            $space->x +
                $styles['padding']->value['right'] +
                $styles['border']->value['right']['width'] / 2 +
                $space->width,
            $space->y -
                $styles['padding']->value['top'] -
                $styles['border']->value['top']['width'] / 2,
        );

        if ( $styles['border']->value['top']['width'] > 0 )
        {
            $this->driver->drawPolyline(
                array( $topLeft, $topRight ),
                $styles['border']->value['top']['color'],
                $styles['border']->value['top']['width']
            );
        }
    }

    /**
     * Render top border
     *
     * Render the top border of the given space
     * 
     * @param array $styles 
     * @param ezcDocumentPdfBoundingBox $space 
     * @return void
     */
    protected function renderBottomBorder( array $styles, ezcDocumentPdfBoundingBox $space )
    {
        $bottomRight = array(
            $space->x +
                $styles['padding']->value['right'] +
                $styles['border']->value['right']['width'] / 2 +
                $space->width,
            $space->y +
                $styles['padding']->value['bottom'] +
                $styles['border']->value['bottom']['width'] / 2 +
                $space->height,
        );
        $bottomLeft = array(
            $space->x -
                $styles['padding']->value['left'] -
                $styles['border']->value['left']['width'] / 2,
            $space->y +
                $styles['padding']->value['bottom'] +
                $styles['border']->value['bottom']['width'] / 2 +
                $space->height,
        );

        if ( $styles['border']->value['bottom']['width'] > 0 )
        {
            $this->driver->drawPolyline(
                array( $bottomRight, $bottomLeft ),
                $styles['border']->value['bottom']['color'],
                $styles['border']->value['bottom']['width']
            );
        }
    }

    /**
     * Set cell box covered
     *
     * Mark rendered space as convered on the page.
     *
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfBoundingBox $space 
     * @param array $styles 
     * @return void
     */
    protected function setCellCovered( ezcDocumentPdfPage $page, ezcDocumentPdfBoundingBox $space, array $styles )
    {
        // Apply bounding box modifications
        $space = clone $space;
        $space->x      -=
            $styles['padding']->value['left'] +
            $styles['border']->value['left']['width'] +
            $styles['margin']->value['left'];
        $space->width  +=
            $styles['padding']->value['left'] +
            $styles['padding']->value['right'] +
            $styles['border']->value['left']['width'] +
            $styles['border']->value['right']['width'] +
            $styles['margin']->value['left'] +
            $styles['margin']->value['right'];
        $space->y      -=
            $styles['padding']->value['top'] +
            $styles['border']->value['top']['width'] +
            $styles['margin']->value['top'];
        $space->height +=
            $styles['padding']->value['top'] +
            $styles['border']->value['top']['width'] +
            $styles['margin']->value['top'];
        $page->setCovered( $space );
        $page->y += $space->height;
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

        $space = $this->evaluateAvailableBoundingBox( $page, $styles, $renderWidth );
        $box   = clone $space;
        $this->renderTopBorder( $styles, $box );

        $xpath     = new DOMXPath( $block->ownerDocument );
        $xPosition = $page->x;
        foreach ( $xpath->query( './*/*/*[local-name() = "row"] | ./*/*[local-name() = "row"]', $block ) as $row )
        {
            $xOffset         = 0;
            $this->cellBoxes = array();
            $positions       = array();
            foreach ( $xpath->query( './*[local-name() = "entry"]', $row ) as $nr => $cell )
            {
                $positions[] = $this->renderCell( $page, $hyphenator, $tokenizer, $cell, $styles, $space, $xOffset, $tableColumnWidths[$nr] );
                $xOffset    += $tableColumnWidths[$nr];
            }

            $page->x = $xPosition;
            foreach ( $this->cellBoxes as $cell )
            {
                $cell['box']->height = max( $positions ) - $cell['box']->y;
                $this->renderBoxBorder( $cell['box'], $cell['styles'], false );
                $this->setCellCovered( $page, $cell['box'], $styles );
            }

            // Set page->y again, since setBoxCovered() increased it, which we 
            // do not want in this case.
            $page->y = max( $positions );

            $space->y = $page->y = $page->y +
                $cell['styles']['padding']->value['bottom'] +
                $cell['styles']['border']->value['bottom']['width'] +
                $cell['styles']['margin']->value['bottom'];
        }

        // @TODO: This does obviously not work for multi-page tables. In this 
        // case the page y offset needs to be assumed as the top of the box.
        $box->height = $space->y - $box->y;
        $this->renderBoxBorder( $box, $styles, false );
    }
}

?>
