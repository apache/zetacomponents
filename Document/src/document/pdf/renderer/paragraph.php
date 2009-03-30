<?php
/**
 * File containing the ezcDocumentPdfDriver class
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
class ezcDocumentPdfParagraphRenderer extends ezcDocumentPdfRenderer
{
    /**
     * Render a single paragraph
     *
     * All markup inside of the given string is considered inline markup (in
     * CSS terms). Inline markup should be given as common docbook inline
     * markup, like <emphasis>.
     * 
     * @param ezcDocumentPdfPage $page 
     * @param string $paragraph 
     * @return void
     */
    public function render( ezcDocumentPdfPage $page, $paragraph )
    {
        $tokens = $this->tokenize( $paragraph );

        // Calculate paragraph width from page layout settings

        // Iterate over tokens and try to fit them in the current line, use
        // hyphenator to split word.

        // If new line is required, check if fits maximum height, optionally
        // wrap, mind orphans and widows

        // Render token, respecting assigned styles
    }

    /**
     * Tokenize the input string
     *
     * For proper word wrapping in the paragraph the strng needs to be
     * tokenized, while each token has to maintain its stack of assigned
     * formats.
     *
     * This method should return an array of tokens, also maintaining the
     * included whitespace characters, each associated with its markup
     * elements.
     * 
     * @param string $string 
     * @return array
     */
    protected function tokenize( $string )
    {
        return array();
    }
}
?>
