<?php
/**
 * File containing the ezcGraphDriverGD class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Extension of the basic Driver package to utilize the GDlib.
 *
 * @package Graph
 */
class ezcGraphGdDriver extends ezcGraphDriver
{

    /**
     * Image ressource
     * 
     * @var ressource
     */
    protected $image;

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphGdDriverOptions( $options );
    }

    protected function getImage()
    {
        if ( !isset( $this->image ) )
        {
            $this->image = imagecreatetruecolor( $this->options->width, $this->options->height );
            imagecolorallocate( $this->image, 255, 255, 255 );
        }

        return $this->image;
    }

    protected function allocate( ezcGraphColor $color )
    {
        $image = $this->getImage();

        if ( $color->alpha > 0 )
        {
            $fetched = imagecolorexactalpha( $image, $color->red, $color->green, $color->blue, $color->alpha / 2 );
            if ( $fetched < 0 )
            {
                $fetched = imagecolorallocatealpha( $image, $color->red, $color->green, $color->blue, $color->alpha / 2 );
            }
            return $fetched;
        }
        else
        {
            $fetched = imagecolorexact( $image, $color->red, $color->green, $color->blue );
            if ( $fetched < 0 )
            {
                $fetched = imagecolorallocate( $image, $color->red, $color->green, $color->blue );
            }
            return $fetched;
        }
    }

    protected function imageCreateFrom( $file )
    {
        $data = getimagesize( $file );

        switch( $data[2] )
        {
            case 1:
                return array(
                    'width' => $data[0],
                    'height' => $data[1],
                    'image' => imagecreatefromgif( $file )
                );
            case 2:
                return array(
                    'width' => $data[0],
                    'height' => $data[1],
                    'image' => imagecreatefromjpeg( $file )
                );
            case 3:
                return array(
                    'width' => $data[0],
                    'height' => $data[1],
                    'image' => imagecreatefrompng( $file )
                );
            default:
                throw new ezcGraphGdDriverUnsupportedImageFormatException( $data[2] );
        }
    }

    /**
     * Draws a single polygon 
     * 
     * @param mixed $points 
     * @param ezcGraphColor $color 
     * @param mixed $filled 
     * @return void
     */
    public function drawPolygon( array $points, ezcGraphColor $color, $filled = true )
    {
        $image = $this->getImage();

        $drawColor = $this->allocate( $color );

        // Create point array
        $pointCount = count( $points );
        $pointArray = array();
        for ( $i = 0; $i < $pointCount; ++$i )
        {
            $pointArray[] = $points[$i]->x;
            $pointArray[] = $points[$i]->y;
        }

        // Draw polygon
        if ( $filled )
        {
            imagefilledpolygon( $image, $pointArray, $pointCount, $drawColor );
        }
        else
        {
            imagepolygon( $image, $pointArray, $pointCount, $drawColor );
        }
    }
    
    /**
     * Draws a single line
     * 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param ezcGraphColor $color 
     * @return void
     */
    public function drawLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color )
    {
        $image = $this->getImage();

        $drawColor = $this->allocate( $color );

        imageline( $image, $start->x, $start->y, $end->x, $end->y, $drawColor );
    }
    
    /**
     * Wrties text in a box of desired size
     * 
     * @param mixed $string 
     * @param ezcGraphCoordinate $position 
     * @param mixed $width 
     * @param mixed $height 
     * @param ezcGraphColor $color 
     * @return void
     */
    public function drawTextBox( $string, ezcGraphCoordinate $position, $width, $height, $align )
    {
        
    }
    
    /**
     * Draws a sector of cirlce
     * 
     * @param ezcGraphCoordinate $center 
     * @param mixed $width
     * @param mixed $height
     * @param mixed $startAngle 
     * @param mixed $endAngle 
     * @param ezcGraphColor $color 
     * @return void
     */
    public function drawCircleSector( ezcGraphCoordinate $center, $width, $height, $startAngle, $endAngle, ezcGraphColor $color )
    {
        
    }
    
    /**
     * Draws a circular arc
     * 
     * @param ezcGraphCoordinate $center 
     * @param mixed $width 
     * @param mixed $height 
     * @param mixed $startAngle 
     * @param mixed $endAngle 
     * @param ezcGraphColor $color 
     * @return void
     */
    public function drawCircularArc( ezcGraphCoordinate $center, $width, $height, $startAngle, $endAngle, ezcGraphColor $color )
    {
        
    }
    
    /**
     * Draws a circle
     * 
     * @param ezcGraphCoordinate $center 
     * @param mixed $width
     * @param mixed $height
     * @param ezcGraphColor $color
     * @param bool $filled
     *
     * @return void
     */
    public function drawCircle( ezcGraphCoordinate $center, $width, $height, ezcGraphColor $color, $filled = true )
    {
        $image = $this->getImage();

        $drawColor = $this->allocate( $color );

        if ( $filled )
        {
            imagefilledellipse( $image, $center->x, $center->y, $width, $height, $drawColor );
        }
        else
        {
            imageellipse( $image, $center->x, $center->y, $width, $height, $drawColor );
        }
    }
    
    /**
     * Draws a imagemap of desired size
     * 
     * @param mixed $file 
     * @param ezcGraphCoordinate $position 
     * @param mixed $width 
     * @param mixed $height 
     * @return void
     */
    public function drawImage( $file, ezcGraphCoordinate $position, $width, $height )
    {
        $imageFile = $this->imageCreateFrom( $file );
        $image = $this->getImage();

        imagecopyresampled( 
            $image, 
            $imageFile['image'], 
            $position->x, $position->y,
            0, 0,
            $position->x + $width, $position->y + $height,
            $imageFile['width'], $imageFile['height']
        );
    }

    /**
     * Finally save image
     * 
     * @param mixed $file 
     * @return void
     */
    public function render ( $file )
    {
        $image = $this->getImage();

        switch ( $this->options->imageFormat )
        {
            case IMG_PNG:
                imagepng( $image, $file );
                break;
            case IMG_JPEG:
                imagejpeg( $image, $file, $this->options->quality );
                break;
        }
    }
}

?>
