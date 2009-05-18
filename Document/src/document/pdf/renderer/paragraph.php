<?php
/**
 * File containing the ezcDocumentPdfParagraphRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Paragraph renderer
 *
 * Renders a single paragraph including its inline markup.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfParagraphRenderer extends ezcDocumentPdfTextBoxRenderer
{
    /**
     * Render a single text box
     *
     * All markup inside of the given string is considered inline markup (in
     * CSS terms). Inline markup should be given as common docbook inline
     * markup, like <emphasis>.
     *
     * Returns a boolean indicator whether the rendering of the full text
     * in the available space succeeded or not.
     *
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfInferencableDomElement $text 
     * @return bool
     */
    public function render( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfInferencableDomElement $text, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        // Inference page styles
        $styles = $this->styles->inferenceFormattingRules( $text );
        $width  = $page->innerWidth / $styles['text-columns']->value -
            ( $styles['text-column-spacing']->value * ( $styles['text-columns']->value - 1 ) );

        // Evaluate available space
        if ( ( $space = $this->evaluateAvailableBoundingBox( $page, $styles, $width ) ) === false )
        {
            return false;
        }

        // Iterate over tokens and try to fit them in the current line, use
        // hyphenator to split words.
        $tokens = $this->tokenize( $text );
        $lines  = $this->fitTokensInLines( $tokens, $hyphenator, $space->width );

        // Evaluate horizontal starting position
        $transactions[] = $this->driver->startTransaction();
        $rendered       = array();
        $current        = 0;
        $lineCount      = count( $lines );
        $lineLimit      = -1;
        $yPos           = $space->y + $styles['margin']->value['top'];
        for ( $line = 0; $line < $lineCount; ++$line )
        {
            // Check if we will run out of vertical space
            if ( ( $lineLimit === 0 ) ||
                 ( $yPos + $line['height'] ) > ( $space->y + $space->height ) )
            {
                // Check for orphans on the just closed paragraph part, if
                // orphans occur move paragraph part to next page.
                if ( $current < $styles['orphans']->value )
                {
                    if ( !$mainRenderer->checkSkipPrerequisites(
                            $this->calculateTextWidth( $page, $text ) +
                            $styles['text-column-spacing']->value
                       ) )
                    {
                        return false;
                    }
                    
                    $this->driver->revert( array_pop( $transactions ) );
                    $line     -= $current;
                    $current   = 0;
                    $lineLimit = -1;
                }

                // Start a new transaction for the next block
                $transactions[] = $this->driver->startTransaction();

                // Set already used space covered
                $page->setCovered(
                    new ezcDocumentPdfBoundingBox( $space->x, $space->y, $space->width, $yPos - $space->y )
                );

                // Evaluate new starting position
                $page = $mainRenderer->getNextRenderingPosition(
                    $this->calculateTextWidth( $page, $text ) +
                    $styles['text-column-spacing']->value
                );

                // Calculate newly available space
                $space      = $this->evaluateAvailableBoundingBox( $page, $styles, $width );
                $yPos       = $space->y + $styles['margin']->value['top'];
                $rendered[] = $current;
                $current    = 0;
                $lineLimit  = -1;
            }

            $yPos += $this->renderLine( $yPos, $lines[$line], $space, $styles );
            ++$current;
            --$lineLimit;

            // Check for widows
            if ( ( $line === ( $lineCount - 1 ) ) &&
                 ( $current < $styles['widows']->value ) &&
                 ( $lineCount > $styles['widows']->value ) )
            {
                // Revert two last rendering calls and limit number of rendered lines
                $line     -= $current + ( $lastParagraph = array_pop( $rendered ) );
                $lineLimit = $lastParagraph - ( $styles['widows']->value - $current );
                $current   = 0;

                // Revert the two last transactions
                array_pop( $transactions );
                $this->driver->revert( array_pop( $transactions ) );
                $space      = $this->evaluateAvailableBoundingBox( $page, $styles, $width );
                $yPos       = $space->y + $styles['margin']->value['top'];
            }
        }

        $page->setCovered(
            new ezcDocumentPdfBoundingBox( $space->x, $space->y, $space->width, $yPos - $space->y )
        );

        // Mark used space covered and exit with success return code
        $page->y = $yPos + $styles['margin']->value['bottom'];
        return true;
    }
}
?>
