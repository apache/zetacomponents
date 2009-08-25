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
class ezcTestDocumentPdfMockDriver extends ezcDocumentPdfSvgDriver
{
    protected $style;
    protected $size;

    public $calls = array();

    /**
     * Show a debug dump of all calls to the driver.
     * 
     * @return void
     */
    public function debugDump()
    {
        foreach ( $this->calls as $nr => $call )
        {
            echo $nr, ") ", $call[0], "( ", @implode( ", ", $call[1] ), " )\n";
        }
    }

    /**
     * Convert values
     *
     * Convert measure values from the PCSS input file into another unit. The
     * input unit is read from the passed value and defaults to milli meters.
     * The output unit can be specified as the second parameter and also
     * default to milli meters.
     *
     * Supported units currently are: mm, px, pt, in
     * 
     * @param mixed $input 
     * @param string $format 
     * @return void
     */
    public function convertValue( $input, $format = 'mm' )
    {
        return parent::convertValue( $input, $format );
    }

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
        $this->calls[] = array( __FUNCTION__, func_get_args() );
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

    /**
     * Draw word at given position
     *
     * Draw the given word at the given position using the currently set text
     * formatting options.
     * 
     * @param float $x 
     * @param float $y 
     * @param string $word 
     * @return void
     */
    public function drawWord( $x, $y, $word )
    {
        $this->calls[] = array( __FUNCTION__, func_get_args() );
    }

    /**
     * Draw a fileld polygon
     *
     * Draw any filled polygon, filled using the defined color. The color
     * should be passed as an array with the keys "red", "green", "blue" and
     * optionally "alpha". Each key should have a value between 0 and 1
     * associated.
     *
     * The polygon itself is specified as an array of two-tuples, specifying
     * the x and y coordinate of the point.
     * 
     * @param array $points 
     * @param array $color 
     * @return void
     */
    public function drawPolygon( array $points, array $color )
    {
        $this->calls[] = array( __FUNCTION__, func_get_args() );
    }

    /**
     * Draw a polyline
     *
     * Draw any non-filled polygon, filled using the defined color. The color
     * should be passed as an array with the keys "red", "green", "blue" and
     * optionally "alpha". Each key should have a value between 0 and 1
     * associated.
     *
     * The polyline itself is specified as an array of two-tuples, specifying
     * the x and y coordinate of the point.
     *
     * The thrid parameter defines the width of the border and the last
     * parameter may optionally be set to false to not close the polygon (draw
     * another line from the last point to the first one).
     * 
     * @param array $points 
     * @param array $color 
     * @param float $width 
     * @param bool $close 
     * @return void
     */
    public function drawPolyline( array $points, array $color, $width, $close = true )
    {
        $this->calls[] = array( __FUNCTION__, func_get_args() );
    }

    /**
     * Add an external link
     *
     * Add an external link to the rectangle specified by its top-left
     * position, width and height. The last parameter is the actual URL to link
     * to.
     * 
     * @param float $x 
     * @param float $y 
     * @param float $width 
     * @param float $height 
     * @param string $url 
     * @return void
     */
    public function addExternalLink( $x, $y, $width, $height, $url )
    {
        $this->calls[] = array( __FUNCTION__, func_get_args() );
    }

    /**
     * Add an internal link
     *
     * Add an internal link to the rectangle specified by its top-left
     * position, width and height. The last parameter is the target identifier
     * to link to.
     * 
     * @param float $x 
     * @param float $y 
     * @param float $width 
     * @param float $height 
     * @param string $target 
     * @return void
     */
    public function addInternalLink( $x, $y, $width, $height, $target )
    {
        $this->calls[] = array( __FUNCTION__, func_get_args() );
    }

    /**
     * Add an internal link target
     *
     * Add an internal link to the current page. The last parameter
     * is the target identifier.
     * 
     * @param string $id 
     * @return void
     */
    public function addInternalLinkTarget( $id )
    {
        $this->calls[] = array( __FUNCTION__, func_get_args() );
    }

    /**
     * Generate and return PDF
     *
     * Return the generated binary PDF content as a string.
     * 
     * @return string
     */
    public function save()
    {
        $this->calls[] = array( __FUNCTION__, func_get_args() );
    }
}
?>
