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
 * Renders a literal block / code section
 *
 * Renders a code section / literal block, which especially means, that
 * whitespaces are not omitted or reduced, but preserved in the output.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfLiteralBlockRenderer extends ezcDocumentPdfWrappingTextBoxRenderer
{
    /**
     * Renders a literal block
     *
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentLocateableDomElement $text 
     * @param ezcDocumentPdfRendererWrappable $mainRenderer 
     * @return bool
     */
    public function render( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentLocateableDomElement $text, ezcDocumentPdfRendererWrappable $mainRenderer )
    {
        // Use a special tokenizer and hyphenator for literal blocks
        return parent::render(
            $page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfLiteralTokenizer(),
            $text,
            $mainRenderer
        );
    }
}
?>
