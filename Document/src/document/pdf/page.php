<?php
/**
 * File containing the ezcDocumentPdfPage class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * PDF page class
 *
 * Class containing context information about a single rendered page.
 *
 * It especially encodes information about already covered / blocked areas on
 * one PDF page, and offers methods to check if a new content block fits on the
 * page an, where it does fir on the page.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentPdfPage
{
    /**
     * Already covered areas, given as an arrays of ezcDocumentPdfPageRectangle
     * objects.
     * 
     * @var array
     */
    protected $covered = array();

    /**
     * Width of current page - given in millimeters?
     * 
     * @var float
     */
    protected $width;

    /**
     * Height of current page - given in millimeters?
     * 
     * @var float
     */
    protected $height;

    /**
     * Construct new fresh page from its dimensions
     * 
     * @param float $width 
     * @param float $height 
     * @return void
     */
    public function __construct( $width, $height )
    {
        $this->width  = (float) $width;
        $this->height = (float) $height;
    }

    /**
     * Set space covored
     *
     * Append a rectangle of already covered space. This space will then not be
     * reused for any other objects on the page.
     *
     * There is no check for overlapping of covered areas in here, so that you
     * can add bounding boxes wrapping multiple already existing rectangles.
     * 
     * @param ezcDocumentPdfPageRectangle $rectangle 
     * @return void
     */
    public function setCovered( ezcDocumentPdfPageRectangle $rectangle )
    {
        $this->covered[] = $rectangle;
    }

    /**
     * Try to fit specified rectangle on page
     *
     * Try to find place for the specified rectangle on the curernt page. Each
     * of the parameters may be set to null, which means that this parameter
     * can be varied in dimension or value.
     *
     * If all parameters are set to a fixed value, either false will be
     * returned, if the location is already (partly) covered, or a rectangle
     * will be returned if that space is still available.
     *
     * If, for example, the yPos parameter is set to null, but all other
     * parameters are set, the box will be moved down the page, until a
     * available location could be found.
     * 
     * @param mixed $xPos 
     * @param mixed $yPos 
     * @param mixed $width 
     * @param mixed $height 
     * @return mixed
     */
    public function testFitRectangle( $xPos = null, $yPos = null, $width = null, $height = null )
    {
        return false;
    }
}

