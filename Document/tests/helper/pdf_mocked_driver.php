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
 * Test implemenation of PDF driver mocking actual driver behaviour
 */
abstract class ezcTextDocumentPdfMockDriver extends ezcDocumentPdfDriver
{
    protected $style;
    protected $size;

    /**
     * Create a new page
     *
     * Create a new page in the PDF document with the given width and height.
     * 
     * @param float $width 
     * @param float $height 
     * @return void
     */
    public function createPage( $width, $height )
    {
        // Do nothing
    }

    /**
     * Set text formatting option
     *
     * Set a text formatting option. The names of the options are the same used
     * in the PCSS files and need to be translated by the driver to the proper
     * backend calls.
     *
     *
     * @param string $type 
     * @param mixed $value 
     * @return void
     */
    public function setTextFormatting( $type, $value )
    {
        switch ( $type )
        {
            case 'font-style':
                if ( ( $value === 'oblique' ) ||
                     ( $value === 'italic' ) )
                {
                    $this->style |= self::FONT_OBLIQUE;
                }
                else
                {
                    $this->style &= ~self::FONT_OBLIQUE;
                }
                break;

            case 'font-weight':
                if ( ( $value === 'bold' ) ||
                     ( $value === 'bolder' ) )
                {
                    $this->style |= self::FONT_BOLD;
                }
                else
                {
                    $this->style &= ~self::FONT_BOLD;
                }
                break;

            case 'font-size':
                $this->size = (float) $value;
                break;
        }
    }

    /**
     * Calculate the rendered width of the current word
     *
     * Calculate the width of the passed word, using the currently set text
     * formatting options.
     * 
     * @param string $word 
     * @return float
     */
    public function calculateWordWidth( $word )
    {
        return iconv_strlen( $word, 'UTF-8' ) * $this->size * .5 *
            ( $this->style & self::FONT_BOLD ? 1.5 : 1 ) *
            ( $this->style & self::FONT_OBLIQUE ? 1.2 : 1 );
    }

    /**
     * Get current line height
     *
     * Return the current line height in millimeter based on the current font
     * and text rendering settings.
     * 
     * @return float
     */
    public function getCurrentLineHeight()
    {
        return $this->size;
    }

    // This one should be mocked, keep it abstract.
    // abstract public function drawWord( $x, $y, $word );

    /**
     * Generate and return PDF
     *
     * Return the generated binary PDF content as a string.
     * 
     * @return string
     */
    public function save()
    {
        // Do nothing
    }
}
?>
