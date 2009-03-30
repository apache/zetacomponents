<?php
/**
 * File containing the ezcDocumentPdfPageRectangle class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * PDF page rectangle class
 *
 * Specifies some horizontal rectangle on PDF pages.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfPageRectangle
{
    /**
     * Horizontal position of rectangle
     * 
     * @var float
     */
    public $xPos;

    /**
     * Vertical position of rectangle
     * 
     * @var float
     */
    public $yPos;

    /**
     * Width of current page - given in millimeters?
     * 
     * @var float
     */
    public $width;

    /**
     * Height of current page - given in millimeters?
     * 
     * @var float
     */
    public $height;

    /**
     * Construct new rectangle from its dimensions
     * 
     * @param float $xPos 
     * @param float $yPos 
     * @param float $width 
     * @param float $height 
     * @return void
     */
    public function __construct( $xPos, $yPos, $width, $height )
    {
        $this->xPos   = (float) $xPos;
        $this->yPos   = (float) $yPos;
        $this->width  = (float) $width;
        $this->height = (float) $height;
    }

    /**
     * Test if two rectangles intersect
     *
     * Intersection test for two horizontal rectangles. Returns true, if the
     * given rectangles intersect, and false if no intersection could be found.
     * 
     * @param ezcDocumentPdfPageRectangle $rectangle
     * @return bool
     */
    public function testIntersection( ezcDocumentPdfPageRectangle $rectangle )
    {
        return true;
    }
}
?>
