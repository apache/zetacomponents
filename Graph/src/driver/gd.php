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
            $bgColor = imagecolorallocate( $this->image, 255, 255, 255 );
            // Default to a white background
            imagefill( $this->image, 1, 1, $bgColor );
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
    
    protected function testFitStringInTextBox( $string, ezcGraphCoordinate $position, $width, $height, $size )
    {
        // Tokenize String
        $tokens = preg_split( '/\s+/', $string );
        
        $lines = array( array() );
        $line = 0;
        foreach ( $tokens as $token )
        {
            // Add token to tested line
            $selectedLine = $lines[$line];
            $selectedLine[] = $token;

            $boundings = imagettfbbox( $size, 0, $this->options->font, implode( ' ', $selectedLine ) );

            // Check if line is too long
            if ( $boundings[2] > $width )
            {
                if ( count( $selectedLine ) == 1 )
                {
                    // Return false if one single word does not fit into one line
                    return false;
                }
                else
                {
                    // Put word in next line instead and reduce available height by used space
                    $lines[++$line][] = $token;
                    $height -= $size * ( 1 + $this->options->lineSpacing );
                }
            }
            else
            {
                // Everything is ok - put token in this line
                $lines[$line][] = $token;
            }
            
            // Return false if text exceeds vertical limit
            if ( $size > $height )
            {
                return false;
            }
        }

        // It seems to fit - return line array
        return $lines;
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
        $image = $this->getImage();
        $drawColor = $this->allocate( $this->options->fontColor );

        // Try to get a font size for the text to fit into the box
        $maxSize = min( $height, $this->options->maxFontSize );
        for ( $size = $maxSize; $size >= $this->options->minFontSize; --$size )
        {
            $result = $this->testFitStringInTextBox( $string, $position, $width, $height, $size );
            if ( $result !== false )
            {
                break;
            }
        }

        if ( is_array( $result ) )
        {
            // Render text with evaluated font size
            foreach ( $result as $line )
            {
                $string = implode( ' ', $line );
                $boundings = imagettfbbox( $size, 0, $this->options->font, $string );
                $position->y += $size;

                switch ( $align )
                {
                    case ezcGraph::LEFT:
                        imagettftext( $image, $size, 0, $position->x, $position->y, $drawColor, $this->options->font, $string );
                        break;
                    case ezcGraph::RIGHT:
                        imagettftext( $image, $size, 0, $position->x + ( $width - $boundings[2] ), $position->y, $drawColor, $this->options->font, $string );
                        break;
                    case ezcGraph::CENTER:
                        imagettftext( $image, $size, 0, $position->x + ( ( $width - $boundings[2] ) / 2 ), $position->y, $drawColor, $this->options->font, $string );
                        break;
                }

                $position->y += $size * $this->options->lineSpacing;
            }
        }
        else
        {
            // @TODO: Try to fit text in box with minimum font size
        }
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
        $image = $this->getImage();
        $drawColor = $this->allocate( $color );

        // Normalize angles
        if ( $startAngle > $endAngle )
        {
            $tmp = $startAngle;
            $startAngle = $endAngle;
            $endAngle = $tmp;
        }

        imagefilledarc( $image, $center->x, $center->y, $width, $height, $startAngle, $endAngle, $drawColor, IMG_ARC_PIE );
    }

    /**
     * Draws a single element of a circular arc
     * 
     * @param ezcGraphCoordinate $center Center of ellipse
     * @param integer $width Width of ellipse
     * @param integer $height Height of ellipse
     * @param integer $size Height of border
     * @param float $startAngle Starting angle of circle sector
     * @param float $endAngle Ending angle of circle sector
     * @param ezcGraphColor $color Color of Border
     * @return void
     */
    protected function drawCircularArcStep( ezcGraphCoordinate $center, $width, $height, $size, $startAngle, $endAngle, ezcGraphColor $color )
    {
        $this->drawPolygon(
            array(
                new ezcGraphCoordinate(
                    $center->x + ( ( cos( deg2rad( $startAngle ) ) * $width ) / 2 ),
                    $center->y + ( ( sin( deg2rad( $startAngle ) ) * $height ) / 2 )
                ),
                new ezcGraphCoordinate(
                    $center->x + ( ( cos( deg2rad( $startAngle ) ) * $width ) / 2 ),
                    $center->y + ( ( sin( deg2rad( $startAngle ) ) * $height + $size ) / 2 )
                ),
                new ezcGraphCoordinate(
                    $center->x + ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
                    $center->y + ( ( sin( deg2rad( $endAngle ) ) * $height + $size ) / 2 )
                ),
                new ezcGraphCoordinate(
                    $center->x + ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
                    $center->y + ( ( sin( deg2rad( $endAngle ) ) * $height ) / 2 )
                ),
            ),
            $color->darken( $this->options->shadeCircularArc * abs ( cos ( deg2rad( $startAngle ) ) ) ),
            true
        );
    }
 
    /**
     * Draws a circular arc
     * 
     * @param ezcGraphCoordinate $center Center of ellipse
     * @param integer $width Width of ellipse
     * @param integer $height Height of ellipse
     * @param integer $size Height of border
     * @param float $startAngle Starting angle of circle sector
     * @param float $endAngle Ending angle of circle sector
     * @param ezcGraphColor $color Color of Border
     * @return void
     */
    public function drawCircularArc( ezcGraphCoordinate $center, $width, $height, $size, $startAngle, $endAngle, ezcGraphColor $color )
    {
        $image = $this->getImage();
        $drawColor = $this->allocate( $color );

        // Normalize angles
        if ( $startAngle > $endAngle )
        {
            $tmp = $startAngle;
            $startAngle = $endAngle;
            $endAngle = $tmp;
        }
        
        $startIteration = ceil( $startAngle / $this->options->detail ) * $this->options->detail;
        $endIteration = floor( $endAngle / $this->options->detail ) * $this->options->detail;


        if ( $startAngle < $startIteration )
        {
            // Draw initial step
            $this->drawCircularArcStep( $center, $width, $height, $size, $startAngle, $startIteration, $color );
        }

        // Draw all steps
        for ( ; $startIteration < $endIteration; $startIteration += $this->options->detail )
        {
            $this->drawCircularArcStep( $center, $width, $height, $size, $startIteration, $startIteration + $this->options->detail, $color );
        }

        if ( $endIteration < $endAngle )
        {
            // Draw closing step
            $this->drawCircularArcStep( $center, $width, $height, $size, $endIteration, $endAngle, $color );
        }
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
