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

        // Render token, respecting assigned styles
        $spaceWidth     = $this->driver->calculateWordWidth( ' ' );

        // Apply padding to title
        $space->x      += $styles['padding']->value['left'];
        $space->width  -= $styles['padding']->value['left'] + $styles['padding']->value['right'];
        $space->y      += $styles['padding']->value['top'];
        $space->height -= $styles['padding']->value['top'] + $styles['padding']->value['bottom'];

        return $space;
    }

    /**
     * Calculate text width
     *
     * Calculate the available horizontal space for texts depending on the
     * page layout settings.
     * 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfInferencableDomElement $text 
     * @return float
     */
    public function calculateTextWidth( ezcDocumentPdfPage $page, ezcDocumentPdfInferencableDomElement $text )
    {
        // Inference page styles
        $rules = $this->styles->inferenceFormattingRules( $text );

        return $page->innerWidth / $rules['text-columns']->value -
            ( $rules['text-column-spacing']->value * ( $rules['text-columns']->value - 1 ) );
    }

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
        foreach ( $lines as $nr => $line )
        {
            $yPos += $this->renderLine( $yPos, $line, $space, $styles );

            // Check if we run out of vertical space
            if ( $yPos > ( $space->y + $space->height ) )
            {
                return false;
            }
        }

        return $yPos - $space->y;
    }

    /**
     * Render a single line and return the used height
     * 
     * @param float $position 
     * @param int $number 
     * @param array $line 
     * @param ezcDocumentPdfBoundingBox $space 
     * @param array $styles 
     * @return void
     */
    protected function renderLine( $position, $number, array $line, ezcDocumentPdfBoundingBox $space, array $styles )
    {
        $spaceWidth = $this->driver->calculateWordWidth( ' ' );
        $lineWidth = 0;
        foreach ( $line['tokens'] as $token )
        {
            $lineWidth += $token['width'];
        }

        switch ( $styles['text-align']->value )
        {
            case 'center':
                $offset = ( $space->width - $lineWidth - ( count( $line['tokens'] ) * $spaceWidth ) ) / 2;
                break;
            case 'right':
                $offset = $space->width - $lineWidth - ( count( $line['tokens'] ) * $spaceWidth );
                break;
            case 'justify':
                $offset = 0;
                switch ( true )
                {
                    case $number === ( count( $line['tokens'] ) - 1 ):
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
            $this->driver->drawWord( $xPos, $position, $token['word'] );
            $xPos += $token['width'] + $spaceWidth;
        }

        return $line['height'];
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
