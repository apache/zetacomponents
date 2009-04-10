<?php
/**
 * File containing the ezcDocumentPdfPage class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
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
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfPage implements ezcDocumentPdfLocateable
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
     * Return the inner width of the page
     *
     * Return the inner width of the page, calculated using the absolute page
     * width and the assigned padding.
     * 
     * @return float
     */
    public function innerWidth()
    {
        return $this->width;
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
     * @param ezcDocumentPdfBoundingBox $rectangle 
     * @return void
     */
    public function setCovered( ezcDocumentPdfBoundingBox $rectangle )
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
        // Ensure requested area is within the page boundings
        if ( ( $xPos < 0 ) ||
             ( $yPos < 0 ) ||
             ( ( $xPos + $width ) > $this->width ) ||
             ( ( $yPos + $height ) > $this->height ) )
        {
            return false;
        }

        // Store aspects of passed parameters
        $moveX        = ( $xPos === null );
        $moveY        = ( $yPos === null );
        $adjustWidth  = ( $width === null );
        $adjustHeight = ( $width === null );
        $boundings    = new ezcDocumentPdfBoundingBox( $xPos, $yPos, $width, $height );

        // Test all covered areas for intersections with the given bounding box
        foreach ( $this->covered as $covered )
        {
            $xOut = 0;
            $yOut = 0;
            if ( ( // Test for left coordinate in covering boundings
                   ( $xOut |= ( ( $boundings->x > $covered->x ) &&
                                ( $boundings->x < ( $covered->x + $covered->width ) ) ) << 1 ) ||
                   // Test for right coordinate in covering boundings
                   ( $xOut |= ( ( ( $boundings->x + $boundings->width ) > $covered->x ) &&
                                ( ( $boundings->x + $boundings->width ) < ( $covered->x + $covered->width ) ) ) << 2 ) ||
                   // Test if coordinates outer wrap coverings
                   ( $xOut |= ( ( $boundings->x <= $covered->x ) &&
                                ( ( $boundings->x + $boundings->width ) >= ( $covered->x + $covered->width ) ) ) << 3 )
                 ) &&
                 ( // Test for top coordinate in covering boundings
                   ( $yOut |= ( ( $boundings->y > $covered->y ) &&
                                ( $boundings->y < ( $covered->y + $covered->height ) ) ) << 1 ) ||
                   // Test for bottom coordinate in covering boundings
                   ( $yOut |= ( ( ( $boundings->y + $boundings->height ) > $covered->y ) &&
                                ( ( $boundings->y + $boundings->height ) < ( $covered->y + $covered->height ) ) ) << 2 ) ||
                   // Test if coordinates outer wrap coverings
                   ( $yOut |= ( ( $boundings->y <= $covered->y ) &&
                                ( ( $boundings->y + $boundings->height ) >= ( $covered->y + $covered->height ) ) ) << 3 )
                 ) )
            {
                if ( !$moveX && !$moveY )
                {
                    return false;
                }
                elseif ( $moveX && $moveY )
                {
                    // Move in the direction where less movement is required.
                    // This might be imporved by additionally checking already
                    // reached page boundings...
                    $xMovement = ( $covered->x + $covered->width  ) - $boundings->x;
                    $yMovement = ( $covered->y + $covered->height ) - $boundings->y;
                    $boundings->x += $xMovement > $yMovement ? 0 : $xMovement;
                    $boundings->y += $yMovement > $xMovement ? 0 : $yMovement;
                }
                elseif ( $moveX )
                {
                    $boundings->x = $covered->x + $covered->width;
                }
                elseif ( $moveY )
                {
                    $boundings->y = $covered->y + $covered->height;
                }
            }
        }

        // Recheck moved bounding box, to check if it still fits page
        // boundings, and has not been moved into any covered areas at the
        // bottom right side of the page.
        if ( $moveX || $moveY )
        {
            return $this->testFitRectangle( $boundings->x, $boundings->y, $boundings->width, $boundings->height );
        }

        return $boundings;
    }

    /**
     * Get elements location ID
     *
     * Return the elements location ID, based on the factors described in the
     * class header.
     * 
     * @return string
     */
    public function getLocationId()
    {
        // @TODO: Maybe include the page number or similar additional
        // information here.
        return '/page';
    }
}
?>
