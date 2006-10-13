<?php
/**
 * File containing the ezcGraphMingDriver class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Driver to create Flash4 (SWF) files as graph output.
 *
 * @package Graph
 */

class ezcGraphMingDriver extends ezcGraphDriver
{
    /**
     * Flash movie
     * 
     * @var SWFMovie
     */
    protected $movie;

    /**
     * Unique element id
     * 
     * @var int
     */
    protected $id = 1;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphMingDriverOptions( $options );
    }

    public function getDocument()
    {
        if ( $this->movie === null )
        {
            $this->movie = new SWFMovie();
            $this->movie->setDimension( $this->modifyCoordinate( $this->options->width ), $this->modifyCoordinate( $this->options->height ) );
            $this->movie->setRate( 1 );
            $this->movie->setBackground( 255, 255, 255 );
        }

        return $this->movie;
    }

    protected function setShapeColor( SWFShape $shape, ezcGraphColor $color, $thickness, $filled )
    {
        // @TODO: respect gradients
        if ( $filled === false )
        {
            $shape->setLine( $this->modifyCoordinate( $thickness ), $color->red, $color->green, $color->blue, 255 - $color->alpha );
        }
        else
        {
            $fill = $shape->addFill( $color->red, $color->green, $color->blue );
            $shape->setLeftFill( $fill );
        }
    }

    protected function modifyCoordinate( $pointValue )
    {
        return $pointValue * 10;
    }

    /**
     * Draws a single polygon. 
     * 
     * @param array $points Point array
     * @param ezcGraphColor $color Polygon color
     * @param mixed $filled Filled
     * @param float $thickness Line thickness
     * @return void
     */
    public function drawPolygon( array $points, ezcGraphColor $color, $filled = true, $thickness = 1 )
    {
        $movie = $this->getDocument();

        $shape = new SWFShape();

        $this->setShapeColor( $shape, $color, $thickness, $filled );

        $lastPoint = end( $points );
        $shape->movePenTo( $this->modifyCoordinate( $lastPoint->x ), $this->modifyCoordinate( $lastPoint->y ) );

        foreach( $points as $point )
        {
            $shape->drawLineTo( $this->modifyCoordinate( $point->x ), $this->modifyCoordinate( $point->y ) );
        }

        $object = $movie->add( $shape );
        $object->setName( $id = 'ezcGraphPolygon_' . $this->id++ );

        return $id;
    }
    
    /**
     * Draws a line 
     * 
     * @param ezcGraphCoordinate $start Start point
     * @param ezcGraphCoordinate $end End point
     * @param ezcGraphColor $color Line color
     * @param float $thickness Line thickness
     * @return void
     */
    public function drawLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color, $thickness = 1 )
    {
        $movie = $this->getDocument();

        $shape = new SWFShape();

        $this->setShapeColor( $shape, $color, $thickness, false );

        $shape->movePenTo( $this->modifyCoordinate( $start->x ), $this->modifyCoordinate( $start->y ) );
        $shape->drawLineTo( $this->modifyCoordinate( $end->x ), $this->modifyCoordinate( $end->y ) );

        $object = $movie->add( $shape );
        $object->setName( $id = 'ezcGraphLine_' . $this->id++ );

        return $id;
    }

    /**
     * Returns boundings of text depending on the available font extension
     * 
     * @param float $size Textsize
     * @param ezcGraphFontOptions $font Font
     * @param string $text Text
     * @return ezcGraphBoundings Boundings of text
     */
    protected function getTextBoundings( $size, ezcGraphFontOptions $font, $text )
    {
        $t = new SWFText();
        $t->addString( $text );
        $t->setHeight( $size );
        $t->setFont( $font->path );

        $boundings = new ezcGraphBoundings( 0, 0, $t->getWidth(), $size );

        return $boundings;
    }

    /**
     * Test if string fits in a box with given font size
     *
     * This method splits the text up into tokens and tries to wrap the text
     * in an optimal way to fit in the Box defined by width and height.
     * 
     * If the text fits into the box an array with lines is returned, which 
     * can be used to render the text later:
     *  array(
     *      // Lines
     *      array( 'word', 'word', .. ),
     *  )
     * Otherwise the function will return false.
     *
     * @param string $string Text
     * @param ezcGraphCoordinate $position Topleft position of the text box
     * @param float $width Width of textbox
     * @param float $height Height of textbox
     * @param int $size Fontsize
     * @return mixed Array with lines or false on failure
     */
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

            $boundings = $this->getTextBoundings( $size, $this->options->font, implode( ' ', $selectedLine ) );

            // Check if line is too long
            if ( $boundings->width > $width )
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

        // Check width of last line
        $boundings = $this->getTextBoundings( $size, $this->options->font, implode( ' ', $lines[$line] ) );
        if ( $boundings->width > $width )
        {
            return false;
        }

        // It seems to fit - return line array
        return $lines;
    }
    
    /**
     * Writes text in a box of desired size
     * 
     * @param string $string Text
     * @param ezcGraphCoordinate $position Top left position
     * @param float $width Width of text box
     * @param float $height Height of text box
     * @param int $align Alignement of text
     * @return void
     */
    public function drawTextBox( $string, ezcGraphCoordinate $position, $width, $height, $align )
    {
        if ( $this->options->font->type !== ezcGraph::PALM_FONT )
        {
            throw new ezcGraphInvalidFontTypeException( $this->options->font->type, __CLASS__ );
        }

        $padding = $this->options->font->padding + ( $this->options->font->border !== false ? $this->options->font->borderWidth : 0 );

        $width -= $padding * 2;
        $height -= $padding * 2;
        $position->x += $padding;
        $position->y += $padding;

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
                'id' => $id = 'ezcGraphText_' . $this->id++,
                'position' => $position,
                'width' => $width,
                'height' => $height,
                'align' => $align,
                'font' => $this->options->font,
            );
        }
        else
        {
            throw new ezcGraphFontRenderingException( $string, $this->options->font->minFontSize, $width, $height );
        }

        return $id;
    }

    /**
     * Draws a sector of cirlce
     * 
     * @param ezcGraphCoordinate $center Center of circle
     * @param mixed $width Width
     * @param mixed $height Height
     * @param mixed $startAngle Start angle of circle sector
     * @param mixed $endAngle End angle of circle sector
     * @param ezcGraphColor $color Color
     * @param mixed $filled Filled
     * @return void
     */
    public function drawCircleSector( ezcGraphCoordinate $center, $width, $height, $startAngle, $endAngle, ezcGraphColor $color, $filled = true )
    {
        if ( $startAngle > $endAngle )
        {
            $tmp = $startAngle;
            $startAngle = $endAngle;
            $endAngle = $tmp;
        }

        $movie = $this->getDocument();

        $shape = new SWFShape();
        $this->setShapeColor( $shape, $color, 1, $filled );

        $shape->movePenTo( $this->modifyCoordinate( $center->x ), $this->modifyCoordinate( $center->y ) );

        // @TODO: User SWFShape::curveTo
        for ( $angle = $startAngle; $angle <= $endAngle; $angle += $this->options->circleResolution )
        {
            $angle = min(
                $angle,
                $endAngle
            );

            $shape->drawLineTo( 
                $this->modifyCoordinate( $center->x + cos( deg2rad( $angle ) ) * $width / 2 ), 
                $this->modifyCoordinate( $center->y + sin( deg2rad( $angle ) ) * $height / 2 )
            );
        }

        $shape->drawLineTo( 
            $this->modifyCoordinate( $center->x ), 
            $this->modifyCoordinate( $center->y ) 
        );

        $object = $movie->add( $shape );
        $object->setName( $id = 'ezcGraphCircleSector_' . $this->id++ );

        return $id;
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
    public function drawCircularArc( ezcGraphCoordinate $center, $width, $height, $size, $startAngle, $endAngle, ezcGraphColor $color, $filled = true )
    {
        if ( $startAngle > $endAngle )
        {
            $tmp = $startAngle;
            $startAngle = $endAngle;
            $endAngle = $tmp;
        }

        $movie = $this->getDocument();

        $shape = new SWFShape();
        $this->setShapeColor( $shape, $color, 1, $filled );

        $shape->movePenTo( 
            $this->modifyCoordinate( $center->x + cos( deg2rad( $startAngle ) ) * $width / 2 ), 
            $this->modifyCoordinate( $center->y + sin( deg2rad( $startAngle ) ) * $height / 2 )
        );

        // @TODO: User SWFShape::curveTo
        for ( $angle = $startAngle; $angle <= $endAngle; $angle += $this->options->circleResolution )
        {
            $angle = min(
                $angle,
                $endAngle
            );

            $shape->drawLineTo( 
                $this->modifyCoordinate( $center->x + cos( deg2rad( $angle ) ) * $width / 2 ), 
                $this->modifyCoordinate( $center->y + sin( deg2rad( $angle ) ) * $height / 2 + $size )
            );
        }

        for ( $angle = $endAngle; $angle > $startAngle; $angle -= $this->options->circleResolution )
        {
            $angle = max(
                $angle,
                $startAngle
            );

            $shape->drawLineTo( 
                $this->modifyCoordinate( $center->x + cos( deg2rad( $angle ) ) * $width / 2 ), 
                $this->modifyCoordinate( $center->y + sin( deg2rad( $angle ) ) * $height / 2 )
            );
        }

        $object = $movie->add( $shape );
        $object->setName( $id = 'ezcGraphCircularArc_' . $this->id++ );

        return $id;
    }

    /**
     * Draw circle 
     * 
     * @param ezcGraphCoordinate $center Center of ellipse
     * @param mixed $width Width of ellipse
     * @param mixed $height height of ellipse
     * @param ezcGraphColor $color Color
     * @param mixed $filled Filled
     * @return void
     */
    public function drawCircle( ezcGraphCoordinate $center, $width, $height, ezcGraphColor $color, $filled = true )
    {
        $movie = $this->getDocument();

        $shape = new SWFShape();
        $this->setShapeColor( $shape, $color, 1, $filled );

        $shape->movePenTo( 
            $this->modifyCoordinate( $center->x + $width / 2 ), 
            $this->modifyCoordinate( $center->y )
        );

        // @TODO: User SWFShape::curveTo
        for ( $angle = $this->options->circleResolution; $angle <= 360; $angle += $this->options->circleResolution )
        {
            $shape->drawLineTo( 
                $this->modifyCoordinate( $center->x + cos( deg2rad( $angle ) ) * $width / 2 ), 
                $this->modifyCoordinate( $center->y + sin( deg2rad( $angle ) ) * $height / 2 )
            );
        }

        $object = $movie->add( $shape );
        $object->setName( $id = 'ezcGraphCircle_' . $this->id++ );

        return $id;
    }

    /**
     * Draw an image 
     *
     * The image will be inlined in the SVG document using data URL scheme. For
     * this the mime type and base64 encoded file content will be merged to 
     * URL.
     * 
     * @param mixed $file Image file
     * @param ezcGraphCoordinate $position Top left position
     * @param mixed $width Width of image in destination image
     * @param mixed $height Height of image in destination image
     * @return void
     */
    public function drawImage( $file, ezcGraphCoordinate $position, $width, $height )
    {
        $movie = $this->getDocument();

        $imageData = getimagesize( $file );
        if ( $imageData[0] !== $width || $imageData[1] !== $height )
        {
            throw new ezcGraphMingBitmapBoundingsException( $imageData[0], $imageData[1], $width, $height );
        }

        if ( $imageData[2] !== 2 )
        {
            throw new ezcGraphMingBitmapTypeException( $imageData[2] );
        }

        $image = new SWFBitmap( file_get_contents( 'http://kore.phpugdo.de/jpg.jpeg' ) );
        $object = $movie->add( $image );

        $object->moveTo( 
            $this->modifyCoordinate( $position->x ),
            $this->modifyCoordinate( $position->y )
        ); 
        $object->setName( $id = 'ezcGraphImage_'. $this->id++ );

        return $id;
    }

    /**
     * Finally save image
     * 
     * @param string $file Destination filename
     * @return void
     */
    public function render ( $file )
    {
        $movie = $this->getDocument();
        $movie->save( $file, $this->options->compression );
    }
}

?>
