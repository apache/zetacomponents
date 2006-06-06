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

    /**
     * List of strings to draw
     * array ( array(
     *          'text' => array( 'strings' ),
     *          'options' => ezcGraphFontOptions,
     *      )
     * 
     * @var array
     */
    protected $strings = array();

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphGdDriverOptions( $options );
    }

    protected function getImage()
    {
        if ( !isset( $this->image ) )
        {
            $this->image = imagecreatetruecolor( 
                $this->options->width * $this->options->supersampling, 
                $this->options->height * $this->options->supersampling
            );
            $bgColor = imagecolorallocate( $this->image, 255, 255, 255 );
            // Default to a white background
            imagefill( $this->image, 1, 1, $bgColor );

            if ( $this->options->supersampling > 1 )
            {
                imagesetthickness( 
                    $this->image, 
                    $this->options->supersampling + 1
                );
            }
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

        switch ( $data[2] )
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
            $pointArray[] = $points[$i]->x * $this->options->supersampling;
            $pointArray[] = $points[$i]->y * $this->options->supersampling;
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

        imageline( 
            $image, 
            $start->x * $this->options->supersampling, 
            $start->y * $this->options->supersampling, 
            $end->x * $this->options->supersampling, 
            $end->y * $this->options->supersampling, 
            $drawColor
        );
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

            $boundings = imagettfbbox( $size, 0, $this->options->font->font, implode( ' ', $selectedLine ) );

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
        // Test font
        // @TODO: try to find font at standard locations if no path was provided
        if ( !is_file( $this->options->font->font ) || !is_readable( $this->options->font->font ) )
        {
            throw new ezcGraphGdDriverInvalidFontException( $this->options->font->font );
        }

        // Try to get a font size for the text to fit into the box
        $maxSize = min( $height, $this->options->font->maxFontSize );
        $result = false;
        for ( $size = $maxSize; $size >= $this->options->font->minFontSize; --$size )
        {
            $result = $this->testFitStringInTextBox( $string, $position, $width, $height, $size );
            if ( $result !== false )
            {
                break;
            }
        }

        if ( is_array( $result ) )
        {
            $this->options->font->minimalUsedFont = $size;

            $this->strings[] = array(
                'text' => $result,
                'position' => $position,
                'width' => $width,
                'height' => $height,
                'align' => $align,
                'options' => $this->options->font,
            );
        }
        else
        {
            // @TODO: Try to fit text in box with minimum font size
        }
    }
    
    protected function drawAllTexts()
    {
        $image = $this->getImage();

        foreach ( $this->strings as $text )
        {
            $size = $text['options']->minimalUsedFont;
            $font = $text['options']->font;
            $drawColor = $this->allocate( $text['options']->color );

            $completeHeight = count( $text['text'] ) * $size + ( count( $text['text'] ) - 1 ) * $this->options->lineSpacing;

            // Calculate y offset for vertical alignement
            switch ( true )
            {
                case ( $text['align'] & ezcGraph::BOTTOM ):
                    $yOffset = $text['height'] - $completeHeight;
                    break;
                case ( $text['align'] & ezcGraph::MIDDLE ):
                    $yOffset = ( $text['height'] - $completeHeight ) / 2;
                    break;
                case ( $text['align'] & ezcGraph::TOP ):
                default:
                    $yOffset = 0;
                    break;
            }

            // Render text with evaluated font size
            foreach ( $text['text'] as $line )
            {
                $string = implode( ' ', $line );
                $boundings = imagettfbbox( $size, 0, $font, $string );
                $text['position']->y += $size;

                switch ( true )
                {
                    case ( $text['align'] & ezcGraph::LEFT ):
                        imagettftext( 
                            $image, 
                            $size, 
                            0, 
                            $text['position']->x, 
                            $text['position']->y + $yOffset, 
                            $drawColor, 
                            $font, 
                            $string
                        );
                        break;
                    case ( $text['align'] & ezcGraph::RIGHT ):
                        imagettftext( 
                            $image, 
                            $size, 
                            0, 
                            $text['position']->x + ( $text['width'] - $boundings[2] ), 
                            $text['position']->y + $yOffset, 
                            $drawColor, 
                            $font, 
                            $string 
                        );
                        break;
                    case ( $text['align'] & ezcGraph::CENTER ):
                        imagettftext( 
                            $image, 
                            $size, 
                            0, 
                            $text['position']->x + ( ( $text['width'] - $boundings[2] ) / 2 ), 
                            $text['position']->y + $yOffset, 
                            $drawColor, 
                            $font, 
                            $string
                        );
                        break;
                }

                $text['position']->y += $size * $this->options->lineSpacing;
            }
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

        imagefilledarc( 
            $image, 
            $center->x * $this->options->supersampling, 
            $center->y * $this->options->supersampling, 
            $width * $this->options->supersampling, 
            $height * $this->options->supersampling, 
            $startAngle, 
            $endAngle, 
            $drawColor, 
            IMG_ARC_PIE 
        );
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
                    $center->x + 
                        ( ( cos( deg2rad( $startAngle ) ) * $width ) / 2 ),
                    $center->y + 
                        ( ( sin( deg2rad( $startAngle ) ) * $height ) / 2 )
                ),
                new ezcGraphCoordinate(
                    $center->x + 
                        ( ( cos( deg2rad( $startAngle ) ) * $width ) / 2 ),
                    $center->y + 
                        ( ( sin( deg2rad( $startAngle ) ) * $height + $size ) / 2 )
                ),
                new ezcGraphCoordinate(
                    $center->x + 
                        ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
                    $center->y + 
                        ( ( sin( deg2rad( $endAngle ) ) * $height + $size ) / 2 )
                ),
                new ezcGraphCoordinate(
                    $center->x + 
                        ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
                    $center->y + 
                        ( ( sin( deg2rad( $endAngle ) ) * $height ) / 2 )
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
            $this->drawCircularArcStep( 
                $center, 
                $width, 
                $height, 
                $size, 
                $startAngle, 
                $startIteration, 
                $color
            );
        }

        // Draw all steps
        for ( ; $startIteration < $endIteration; $startIteration += $this->options->detail )
        {
            $this->drawCircularArcStep( 
                $center, 
                $width, 
                $height, 
                $size, 
                $startIteration, 
                $startIteration + $this->options->detail, 
                $color 
            );
        }

        if ( $endIteration < $endAngle )
        {
            // Draw closing step
            $this->drawCircularArcStep( 
                $center, 
                $width, 
                $height, 
                $size, 
                $endIteration, 
                $endAngle, 
                $color 
            );
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
            imagefilledellipse( 
                $image, 
                $center->x * $this->options->supersampling, 
                $center->y * $this->options->supersampling, 
                $width * $this->options->supersampling, 
                $height * $this->options->supersampling, 
                $drawColor 
            );
        }
        else
        {
            imageellipse( 
                $image, 
                $center->x * $this->options->supersampling, 
                $center->y * $this->options->supersampling, 
                $width * $this->options->supersampling, 
                $height * $this->options->supersampling, 
                $drawColor 
            );
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
            $position->x * $this->options->supersampling, 
            $position->y * $this->options->supersampling,
            0, 
            0,
            ( $position->x + $width ) * $this->options->supersampling, 
            ( $position->y + $height ) * $this->options->supersampling,
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
        if ( ( $supersampling = $this->options->supersampling ) > 1 )
        {
            // Supersampling active, resample image
            $image = $this->getImage();
            $sampled = imagecreatetruecolor( $this->options->width, $this->options->height );
            imagecopyresampled(
                $sampled,
                $image,
                0, 0,
                0, 0,
                $this->options->width,
                $this->options->height,
                $this->options->width * $supersampling,
                $this->options->height * $supersampling
            );

            $this->image = $sampled;
            imagedestroy( $image );
        }

        // Draw all texts
        $this->drawAllTexts();

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
