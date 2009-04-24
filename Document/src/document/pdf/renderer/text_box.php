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
 * Paragraph renderer
 *
 * Renders a single paragraph including its inline markup.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
abstract class ezcDocumentPdfTextBoxRenderer extends ezcDocumentPdfRenderer
{
    /**
     * Render text box
     *
     * Render a single text box, specified by the given lines array,
     * containing tokens and their styles, the available space and
     * the styles array for the currently rendered element.
     *
     * Returns false, if the box size was not sufficant for the
     * given text, and the covered vertical area otherwise.
     * 
     * @param array $lines 
     * @param ezcDocumentPdfBoundingBox $space 
     * @param array $styles 
     * @return boolean
     */
    protected function renderTextBox( array $lines, ezcDocumentPdfBoundingBox $space, array $styles )
    {
        // Evaluate horizontal starting position
        $yPos = $space->y + $styles['margin']->value['top'];
        $spaceWidth = $this->driver->calculateWordWidth( ' ' );
        foreach ( $lines as $nr => $line )
        {
            $lineWidth = 0;
            foreach ( $line['tokens'] as $token )
            {
                $lineWidth += $token['width'];
            }

            switch ( $styles['text-align']->value )
            {
                case 'center':
                    $offset     = ( $space->width - $lineWidth - ( count( $line['tokens'] ) * $spaceWidth ) ) / 2;
                    break;
                case 'right':
                    $offset     = $space->width - $lineWidth - ( count( $line['tokens'] ) * $spaceWidth );
                    break;
                case 'justify':
                    $offset     = 0;
                    switch ( true )
                    {
                        case $nr === ( count( $lines ) - 1 ):
                            // Just default space width in last line of a
                            // paragraph
                            $spaceWidth = $this->driver->calculateWordWidth( ' ' );
                            break;
                        case count( $line['tokens'] ) <= 1:
                            // Space width is irrelevant, if only one token is
                            // in the line
                            break;
                        default:
                            $spaceWidth = ( $space->width - $lineWidth ) / ( count( $line['tokens'] ) - 1 );
                    }
                default:
                    $offset     = 0;
            }

            // Default to left alignement
            $xPos = $space->x + $offset;
            foreach ( $line['tokens'] as $token )
            {
                // Apply current styles
                foreach ( $token['style'] as $style => $value )
                {
                    $this->driver->setTextFormatting( $style, $value->value );
                }

                // Render word 
                // @TODO: Align text baseline, if different font sizes are given
                $this->driver->drawWord( $xPos, $yPos, $token['word'] );
                $xPos += $token['width'] + $spaceWidth;
            }

            $yPos += $line['height'];

            // Check if we run out of vertical space
            if ( $yPos > ( $space->y + $space->height ) )
            {
                return false;
            }
        }

        return $yPos - $space->y;
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
                    $words = preg_split( '(\\s+)', trim( $child->textContent ) );
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
        while ( $token = array_shift( $tokens ) )
        {
            // Apply current styles
            foreach ( $token['style'] as $style => $value )
            {
                $this->driver->setTextFormatting( $style, $value->value );
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
            $hyphens = array_reverse( $hyphenator->splitWord( $token['word'] ) );
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
                    continue 2;
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
