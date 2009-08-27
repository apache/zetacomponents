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
 * Renders a list item
 *
 * Tries to render a list item into the available space, and aborts if
 * not possible.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfListItemRenderer extends ezcDocumentPdfRenderer
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
     * @param ezcDocumentPdfInferencableDomElement $block 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return bool
     */
    public function render( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentPdfInferencableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
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

        // @TODO: Detect required list item
        // @TODO: Render bullet.

        $mainRenderer->process( $block );

        $page->y       += $styles['padding']->value['bottom'] +
                          $styles['margin']->value['bottom'];
        $page->xOffset -= $styles['padding']->value['left'] +
                          $styles['margin']->value['left'];
        $page->xReduce -= $styles['padding']->value['right'] +
                          $styles['margin']->value['right'];
        return true;
    }

    /**
     * Get list item generator
     *
     * Get list item generator for the list generator.
     * 
     * @param ezcDocumentPdfInferencableDomElement $block 
     * @return void
     */
    protected function getListItemGenerator( ezcDocumentPdfInferencableDomElement $block )
    {

    }
}

?>
