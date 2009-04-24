<?php
/**
 * File containing the ezcDocumentPdfTitleRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Title renderer
 *
 * Renders a single title including its inline markup.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfTitleRenderer extends ezcDocumentPdfTextBoxRenderer
{
    /**
     * Render a single title
     *
     * All markup inside of the given string is considered inline markup (in
     * CSS terms). Inline markup should be given as common docbook inline
     * markup, like <emphasis>.
     *
     * Returns a boolean indicator whether the rendering of the full title
     * in the available space succeeded or not.
     *
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfInferencableDomElement $title 
     * @return bool
     */
    public function render( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfInferencableDomElement $title )
    {
        // Inference page styles
        $styles = $this->styles->inferenceFormattingRules( $title );
        $width  = $page->innerWidth / $styles['text-columns']->value -
            ( $styles['text-column-spacing']->value * ( $styles['text-columns']->value - 1 ) );

        // Evaluate available space
        if ( ( $space = $this->evaluateAvailableBoundingBox( $page, $styles, $width ) ) === false )
        {
            return false;
        }

        // Iterate over tokens and try to fit them in the current line, use
        // hyphenator to split words.
        $tokens = $this->tokenize( $title );
        $lines  = $this->fitTokensInLines( $tokens, $hyphenator, $space->width );

        // Try to render text into evaluated box
        if ( ( $covered = $this->renderTextBox( $lines, $space, $styles ) ) === false )
        {
            return false;
        }

        // Mark used space covered and exit with success return code
        $page->setCovered(
            new ezcDocumentPdfBoundingBox( $space->x, $space->y, $space->width, $covered )
        );
        $page->y += $covered + $styles['margin']->value['bottom'];
        return true;
    }
}

?>
