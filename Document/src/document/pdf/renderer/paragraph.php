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
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfInferencableDomElement $paragraph 
     * @return void
     */
    public function render( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfInferencableDomElement $paragraph )
    {
        // Calculate paragraph width from page layout settings
        $width = $this->calculateParagraphWidth( $page );

        // Iterate over tokens and try to fit them in the current line, use
        // hyphenator to split words.
        $tokens = $this->tokenize( $paragraph );
        $lines  = $this->fitTokensInLines( $tokens, $hyphenator, $width );

        // Ensure a current rendering position on page
        if ( ( $page->x === null ) ||
             ( $page->y === null ) )
        {
            $space = $page->testFitRectangle( null, null, $width, $tokens[0]['style']['font-size'] );
            $page->x = $space->x;
            $page->y = $space->y;
        }

        // Grap the maximum available vertical space
        $space  = $page->testFitRectangle( $page->x, $page->y, $width, null );

        // Render token, respecting assigned styles
        // @TODO: Mind orphans and widows here.
        $spaceWidth = $this->driver->calculateWordWidth( ' ' );
        $style      = $this->styles->inferenceFormattingRules( $paragraph );
        $yPos       = $space->y;
        foreach ( $lines as $line )
        {
            $lineWidth = 0;
            foreach ( $line['tokens'] as $token )
            {
                $lineWidth += $token['width'];
            }

            // @TODO: Mind margin and padding
            switch ( $style['text-align'] )
            {
                case 'center':
                    // @TODO: Implement
                    break;
                case 'right':
                    // @TODO: Implement
                    break;
                case 'justify':
                    $spaceWidth = ( $width - $lineWidth ) / ( count( $line['tokens'] ) - 1 );
                default:
                    // Default to left alignement
                    $xPos = $space->x;
                    foreach ( $line['tokens'] as $token )
                    {
                        // Apply current styles
                        foreach ( $token['style'] as $style => $value )
                        {
                            $this->driver->setTextFormatting( $style, $value );
                        }

                        // Render word 
                        // @TODO: Align text baseline, if different font sizes are given
                        $this->driver->drawWord( $xPos, $yPos, $token['word'] );
                        $xPos += $token['width'] + $spaceWidth;
                    }
            }

            // @TODO: Check four exceeding available space.
            // -> Break to next column / page
            $yPos += $line['height'];
        }
    }

    /**
     * Calculate paragraph width
     *
     * Calculate the available horizontal space for paragraphs depending on the
     * page layout settings.
     */
    protected function calculateParagraphWidth( ezcDocumentPdfPage $page )
    {
        // Inference page styles
        $rules = $this->styles->inferenceFormattingRules( $page );

        return $page->innerWidth() / $rules['text-columns'] -
            ( $rules['text-column-spacing'] * ( $rules['text-columns'] - 1 ) );
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
     * @param ezcDocumentPdfInferencableDomElement $element 
     * @return array
     */
    protected function tokenize( ezcDocumentPdfInferencableDomElement $element )
    {
        $tokens = array();
        $rules  = $this->styles->inferenceFormattingRules( $element );
        foreach ( $element->childNodes as $child )
        {
            switch ( $child->nodeType )
            {
                // case XML_CDATA_SECTION_NODE:
                case XML_TEXT_NODE:
                    $words = preg_split( '(\\s+)', $child->textContent );
                    foreach ( $words as $word )
                    {
                        $tokens[] = array(
                            'word'  => $word,
                            'style' => $rules,
                        );
                    }
                    break;

                case XML_ELEMENT_NODE:
                    $tokens = array_merge(
                        $tokens,
                        $this->tokenize( $child )
                    );
                    break;
            }
        }

        return $tokens;
    }

    /**
     * Try to match tokens into lines
     *
     * Try to match tokens into lines of the given width. Returns an array with
     * words for each line. The words might already be split up by the
     * hyphenator.
     * 
     * @param array $tokens 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param float $width 
     * @return array
     */
    protected function fitTokensInLines( array $tokens, ezcDocumentPdfHyphenator $hyphenator, $available )
    {
        $lines    = array( array(
            'tokens' => array(),
            'height' => 0,
        ) );
        $line     = 0;
        $consumed = 0;
        foreach ( $tokens as $token )
        {
            // Apply current styles
            foreach ( $token['style'] as $style => $value )
            {
                $this->driver->setTextFormatting( $style, $value );
            }
            
            if ( ( $consumed + ( $width = $this->driver->calculateWordWidth( $token['word'] ) ) ) < $available )
            {
                // The word just fits into the current line
                $token['width']           = $width;
                $lines[$line]['tokens'][] = $token;
                $lines[$line]['height']   = max( $lines[$line]['height'], $this->driver->getCurrentLineHeight() );
                $consumed                += $width + $this->driver->calculateWordWidth( ' ' );
                continue;
            }

            // Try to hyphenate the current word
            $hyphens = $hyphenator->splitWord( $token['word'] );
            foreach ( $hyphens as $hyphen )
            {
                if ( ( $consumed + ( $width = $this->driver->calculateWordWidth( $hyphen[0] ) ) ) < $available )
                {
                    $second         = $token;
                    $second['word'] = $hyphen[1];
                    array_unshift( $tokens, $second );

                    $token['width']           = $width;
                    $token['word']            = $hyphen[0];
                    $lines[$line]['tokens'][] = $token;
                    $lines[$line]['height']   = max( $lines[$line]['height'], $this->driver->getCurrentLineHeight() );
                    $consumed                += $width + $this->driver->calculateWordWidth( ' ' );
                    continue;
                }
            }

            // Word did not even fit into the line hyphenated, switch to next line.
            $token['width'] = $width = $this->driver->calculateWordWidth( $token['word'] );
            $lines[++$line] = array(
                'tokens' => array( $token ),
                'height' => $this->driver->getCurrentLineHeight(),
            );
            $consumed       = $width + $this->driver->calculateWordWidth( ' ' );
        }

        return $lines;
    }
}
?>
