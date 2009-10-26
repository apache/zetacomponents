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
 * Renders a single text box
 *
 * Tries to render a single text box into the available space, and aborts if
 * not possible.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfBlockRenderer extends ezcDocumentPdfRenderer
{
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
    public function render( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentLocateableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        // @TODO: Render border and background. This can be quite hard to
        // estimate, though.
        $styles         = $this->styles->inferenceFormattingRules( $block );
        $page->y       += $styles['padding']->value['top'] +
                          $styles['margin']->value['top'];
        $page->xOffset += $styles['padding']->value['left'] +
                          $styles['margin']->value['left'];
        $page->xReduce += $styles['padding']->value['right'] +
                          $styles['margin']->value['right'];

        $this->process( $page, $hyphenator, $tokenizer, $block, $mainRenderer );

        $page->y       += $styles['padding']->value['bottom'] +
                          $styles['margin']->value['bottom'];
        $page->xOffset -= $styles['padding']->value['left'] +
                          $styles['margin']->value['left'];
        $page->xReduce -= $styles['padding']->value['right'] +
                          $styles['margin']->value['right'];
        return true;
    }

    /**
     * Process to render block contents
     * 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentLocateableDomElement $block 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return void
     */
    protected function process( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentLocateableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        $mainRenderer->process( $block );
    }

    /**
     * Render box background
     *
     * Render box background for the given bounding box with the given
     * styles.
     * 
     * @param ezcDocumentPdfBoundingBox $space 
     * @param array $styles 
     * @return void
     */
    protected function renderBoxBackground( ezcDocumentPdfBoundingBox $space, array $styles )
    {
        if ( isset( $styles['background-color'] ) &&
             ( $styles['background-color']->value['alpha'] < 1 ) )
        {
            $this->driver->drawPolygon(
                array(
                    array(
                        $space->x -
                            $styles['padding']->value['left'] -
                            $styles['border']->value['left']['width'],
                        $space->y -
                            $styles['padding']->value['top'] -
                            $styles['border']->value['top']['width'],
                    ),
                    array(
                        $space->x +
                            $styles['padding']->value['right'] +
                            $styles['border']->value['right']['width'] +
                            $space->width,
                        $space->y -
                            $styles['padding']->value['top'] -
                            $styles['border']->value['top']['width'],
                    ),
                    array(
                        $space->x +
                            $styles['padding']->value['right'] +
                            $styles['border']->value['right']['width'] +
                            $space->width,
                        $space->y +
                            $styles['padding']->value['bottom'] +
                            $styles['border']->value['bottom']['width'] +
                            $space->height,
                    ),
                    array(
                        $space->x -
                            $styles['padding']->value['left'] -
                            $styles['border']->value['left']['width'],
                        $space->y +
                            $styles['padding']->value['bottom'] +
                            $styles['border']->value['bottom']['width'] +
                            $space->height,
                    ),
                ),
                $styles['background-color']->value
            );
        }
    }

    /**
     * Render box border
     *
     * Render box border for the given bounding box with the given
     * styles.
     * 
     * @param ezcDocumentPdfBoundingBox $space 
     * @param array $styles 
     * @param bool $renderTop 
     * @param bool $renderBottom 
     * @return void
     */
    protected function renderBoxBorder( ezcDocumentPdfBoundingBox $space, array $styles, $renderTop = true, $renderBottom = true )
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

        if ( $styles['border']->value['left']['width'] > 0 )
        {
            $this->driver->drawPolyline(
                array( $topLeft, $bottomLeft ),
                $styles['border']->value['left']['color'],
                $styles['border']->value['left']['width']
            );
        }

        if ( $renderTop && $styles['border']->value['top']['width'] > 0 )
        {
            $this->driver->drawPolyline(
                array( $topLeft, $topRight ),
                $styles['border']->value['top']['color'],
                $styles['border']->value['top']['width']
            );
        }

        if ( $styles['border']->value['right']['width'] > 0 )
        {
            $this->driver->drawPolyline(
                array( $topRight, $bottomRight ),
                $styles['border']->value['right']['color'],
                $styles['border']->value['right']['width']
            );
        }

        if ( $renderBottom && $styles['border']->value['bottom']['width'] > 0 )
        {
            $this->driver->drawPolyline(
                array( $bottomRight, $bottomLeft ),
                $styles['border']->value['bottom']['color'],
                $styles['border']->value['bottom']['width']
            );
        }
    }

    /**
     * Set box covered
     *
     * Mark rendered space as convered on the page.
     *
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfBoundingBox $space 
     * @param array $styles 
     * @return void
     */
    protected function setBoxCovered( ezcDocumentPdfPage $page, ezcDocumentPdfBoundingBox $space, array $styles )
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
            $styles['padding']->value['bottom'] +
            $styles['border']->value['top']['width'] +
            $styles['border']->value['bottom']['width'] +
            $styles['margin']->value['top'] +
            $styles['margin']->value['bottom'];
        $page->setCovered( $space );
        $page->y += $space->height;
    }

    /**
     * Evaluate available bounding box
     *
     * Returns false, if not enough space is available on current
     * page, and a bounding box otherwise.
     *
     * @param ezcDocumentPdfPage $page
     * @param array $styles
     * @param float $width
     * @return mixed
     */
    protected function evaluateAvailableBoundingBox( ezcDocumentPdfPage $page, array $styles, $width )
    {
        // Grap the maximum available vertical space
        $space = $page->testFitRectangle( $page->x, $page->y, $width, null );
        if ( $space === false )
        {
            // Could not allocate space, required for even one line
            return false;
        }

        // Apply bounding box modifications
        $space->x      +=
            $styles['padding']->value['left'] +
            $styles['border']->value['left']['width'] +
            $styles['margin']->value['left'];
        $space->width  -=
            $styles['padding']->value['left'] +
            $styles['padding']->value['right'] +
            $styles['border']->value['left']['width'] +
            $styles['border']->value['right']['width'] +
            $styles['margin']->value['left'] +
            $styles['margin']->value['right'];
        $space->y      +=
            $styles['padding']->value['top'] +
            $styles['border']->value['top']['width'] +
            $styles['margin']->value['top'];
        $space->height -=
            $styles['padding']->value['top'] +
            $styles['padding']->value['bottom'] +
            $styles['border']->value['top']['width'] +
            $styles['border']->value['bottom']['width'] +
            $styles['margin']->value['top'] +
            $styles['margin']->value['bottom'];

        return $space;
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
        // Inference page styles
        $rules = $this->styles->inferenceFormattingRules( $text );

        return ( $page->innerWidth -
                ( $rules['text-column-spacing']->value * ( $rules['text-columns']->value - 1 ) )
            ) / $rules['text-columns']->value
            - $page->xOffset - $page->xReduce;
    }
}

?>
