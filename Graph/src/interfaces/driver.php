<?php
/**
 * File containing the abstract ezcGraphDriver class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Abstract class to be extended for ezcGraph output drivers.
 *
 * @package Graph
 */
abstract class ezcGraphDriver
{
    /**
     * Drveroptions
     * 
     * @var ezcDriverOptions
     */
    protected $options;
    
    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    abstract public function __construct( array $options = array() );
    
    /**
     * Options write access
     * 
     * @throws ezcBasePropertyNotFoundException
     *          If Option could not be found
     * @throws ezcBaseValueException
     *          If value is out of range
     * @param mixed $propertyName   Option name
     * @param mixed $propertyValue  Option value;
     * @return mixed
     * @ignore
     */
    public function __set( $propertyName, $propertyValue ) 
    {
        switch ( $propertyName ) {
            case 'options':
                if ( $propertyValue instanceof ezcGraphDriverOptions )
                {
                    $this->options = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( "options", $propertyValue, "instanceof ezcGraphOptions" );
                }
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }

    /**
     * __get 
     * 
     * @param mixed $propertyName 
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return mixed
     * @ignore
     */
    public function __get( $propertyName )
    {
        switch ( $propertyName )
        {
            case 'options':
                return $this->options;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
    }

    /**
     * Reduces the size of a polygon
     *
     * The method takes a polygon defined by a list of points and reduces its 
     * size by moving all lines to the middle by the given $size value.
     *
     * The detection of the inner side of the polygon depends on the angle at 
     * each edge point. This method will always work for 3 edged polygones, 
     * because the smaller angle will always be on the inner side. For 
     * polygons with more then 3 edges this method may fail. For ezcGraph this
     * is a valid simplification, because we do not have any polygones which 
     * have an inner angle >= 180 degrees.
     * 
     * @param array( ezcGraphCoordinate ) $points 
     * @param float $size 
     * @return array( ezcGraphCoordinate )
     */
    protected function reducePolygonSize( array $points, $size )
    {
        $pointCount = count( $points );

        // Build normalized vectors between polygon edge points
        $vectors = array();
        for ( $i = 0; $i < $pointCount; ++$i )
        {
            $nextPoint = ( $i + 1 ) % $pointCount;
            $vectors[$i] = ezcGraphVector::fromCoordinate( $points[$nextPoint] )
                            ->sub( $points[$i] )
                            ->unify();

            if ( ( $vectors[$i]->x == $vectors[$i]->y ) && ( $vectors[$i]->x == 0 ) )
            {
                // Remove point from list if it the same as the next point
                $pointCount--;
                if ( $i === 0 ) 
                {
                    $points = array_slice( $points, $i + 1 );
                }
                else
                {
                    $points = array_merge(
                        array_slice( $points, 0, $i ),
                        array_slice( $points, $i + 1 )
                    );
                }
                $i--;
            }
        }

        // No reducements for lines
        if ( $pointCount <= 2 )
        {
            return $points;
        }

        // Move points to center
        $newPoints = array();
        for ( $i = 0; $i < $pointCount; ++$i )
        {
            $last = $i;
            $next = ( $i + 1 ) % $pointCount;

            // Determine one of the angles - we need to know where the smaller
            // angle is, to determine if the inner side of the polygon is on
            // the left or right hand.
            //
            // This is a valid simplification for ezcGraph(, for now).
            //
            // The sign of the scalar products results indicates on which site
            // the smaller angle is, when comparing the orthogonale vector of 
            // one of the vectors with the other. Why? .. use pen and paper ..
            $sign = ( 
                    -$vectors[$last]->y * $vectors[$next]->x +
                    $vectors[$last]->x * $vectors[$next]->y 
                ) < 0 ? 1 : -1;
            
            // Orthogonal vector with direction based on the side of the inner
            // angle
            $v = clone $vectors[$next];
            if ( $sign > 0 )
            {
                $v->rotateCounterClockwise()->scalar( $size );
            }
            else
            {
                $v->rotateClockwise()->scalar( $size );
            }

            // get last vector not pointing in reverse direction
            $lastVector = clone $vectors[$last];
            $lastVector->scalar( -1 );

            // Calculate new point: Move point to the center site of the 
            // polygon using the normalized orthogonal vectors next to the 
            // point and the size as distance to move.
            // point + v + size / tan( angle / 2 ) * startVector
            $newPoint = clone $vectors[$next];
            $angle = $lastVector->angle( $vectors[$next] ) / 2;

            if ( $angle == 0 )
            {
                var_dump( $points, $vectors );
                debug_print_backtrace();
                die( 'Fin' );
            }
            $newPoints[$next] = 
                $v  ->add( 
                        $newPoint
                            ->scalar( 
                                $size / 
                                tan( 
                                    $lastVector->angle( $vectors[$next] ) / 2
                                ) 
                            ) 
                    )
                    ->add( $points[$next] );
        }

        return $newPoints;
    }

    /**
     * Reduce the size of an ellipse
     *
     * The method returns a the edgepoints and angles for an ellipse where all 
     * borders are moved to the inner side of the ellipse by the give $size 
     * value.
     *
     * The method returns an 
     * array (
     *      'center' => (ezcGraphCoordinate) New center point,
     *      'start' => (ezcGraphCoordinate) New outer start point,
     *      'end' => (ezcGraphCoordinate) New outer end point,
     *      'startAngle' => (float) Angle from old center point to new start point,
     *      'endAngle' => (float) Angle from old center point to new end point,
     * )
     * 
     * @param ezcGraphCoordinate $center 
     * @param mixed $startAngle 
     * @param mixed $endAngle 
     * @param mixed $size 
     * @return array
     */
    protected function reduceEllipseSize( ezcGraphCoordinate $center, $width, $height, $startAngle, $endAngle, $size )
    {
        $oldStartPoint = new ezcGraphVector(
            $width * cos( deg2rad( $startAngle ) ) / 2,
            $height * sin( deg2rad( $startAngle ) ) / 2
        );

        $oldEndPoint = new ezcGraphVector(
            $width * cos( deg2rad( $endAngle ) ) / 2,
            $height * sin( deg2rad( $endAngle ) ) / 2
        );

        // Calculate normalized vectors for the lines spanning the ellipse
        $startVector = ezcGraphVector::fromCoordinate( $oldStartPoint )->unify();
        $endVector = ezcGraphVector::fromCoordinate( $oldEndPoint )->unify();

        $oldStartPoint->add( $center );
        $oldEndPoint->add( $center );

        // Use orthogonal vectors of normalized ellipse spanning vectors to 
        $v = clone $startVector;
        $v->rotateClockwise()->scalar( $size );

        // calculate new center point
        // center + v + size / tan( angle / 2 ) * startVector
        $centerMovement = clone $startVector;
        $newCenter = $v->add( $centerMovement->scalar( $size / tan( deg2rad( ( $endAngle - $startAngle ) / 2 ) ) ) )->add( $center );


        // Use start spanning vector and its orthogonal vector to calculate 
        // new start point
        $newStartPoint = clone $oldStartPoint;

        $innerVector = clone $startVector;
        $innerVector->scalar( $size )->scalar( -1 );

        $orthogonalVector = clone $startVector;
        $orthogonalVector->scalar( $size )->rotateClockwise();

        $newStartPoint->add( $innerVector)->add( $orthogonalVector );

        // Use end spanning vector and its orthogonal vector to calculate 
        // new end point
        $newEndPoint = clone $oldEndPoint;

        $innerVector = clone $endVector;
        $innerVector->scalar( $size )->scalar( -1 );

        $orthogonalVector = clone $endVector;
        $orthogonalVector->scalar( $size )->rotateCounterClockwise();

        $newEndPoint->add( $innerVector )->add( $orthogonalVector );

        return array(
            'center' => $newCenter,
            'start' => $newStartPoint,
            'end' => $newEndPoint,
        );
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
    abstract public function drawPolygon( array $points, ezcGraphColor $color, $filled = true, $thickness = 1 );
    
    /**
     * Draws a line 
     * 
     * @param ezcGraphCoordinate $start Start point
     * @param ezcGraphCoordinate $end End point
     * @param ezcGraphColor $color Line color
     * @param float $thickness Line thickness
     * @return void
     */
    abstract public function drawLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color, $thickness = 1 );
    
    /**
     * Returns boundings of text depending on the available font extension
     * 
     * @param float $size Textsize
     * @param ezcGraphFontOptions $font Font
     * @param string $text Text
     * @return ezcGraphBoundings Boundings of text
     */
    abstract protected function getTextBoundings( $size, ezcGraphFontOptions $font, $text );
    
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
        $initialHeight = $height;

        $lines = array( array() );
        $line = 0;
        foreach ( $tokens as $nr => $token )
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
                    // Scale down font size to fit this word in one line
                    return $width / $boundings->width;
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
                return 1;
            }
        }

        // Check width of last line
        $boundings = $this->getTextBoundings( $size, $this->options->font, implode( ' ', $lines[$line] ) );
        if ( $boundings->width > $width )
        {
            return 1;
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
    abstract public function drawTextBox( $string, ezcGraphCoordinate $position, $width, $height, $align );
    
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
    abstract public function drawCircleSector( ezcGraphCoordinate $center, $width, $height, $startAngle, $endAngle, ezcGraphColor $color, $filled = true );
    
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
    abstract public function drawCircularArc( ezcGraphCoordinate $center, $width, $height, $size, $startAngle, $endAngle, ezcGraphColor $color, $filled = true );
    
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
    abstract public function drawCircle( ezcGraphCoordinate $center, $width, $height, ezcGraphColor $color, $filled = true );
    
    /**
     * Draw an image 
     * 
     * @param mixed $file Image file
     * @param ezcGraphCoordinate $position Top left position
     * @param mixed $width Width of image in destination image
     * @param mixed $height Height of image in destination image
     * @return void
     */
    abstract public function drawImage( $file, ezcGraphCoordinate $position, $width, $height );

    /**
     * Return mime type for current image format
     * 
     * @return string
     */
    abstract public function getMimeType();

    /**
     * Render image directly to output
     *
     * The method renders the image directly to the standard output. You 
     * normally do not want to use this function, because it makes it harder 
     * to proper cache the generated graphs.
     * 
     * @return void
     */
    public function renderToOutput()
    {
        header( 'Content-Type: ' . $this->getMimeType() );
        $this->render( 'php://output' );
    }

    /**
     * Finally save image
     * 
     * @param string $file Destination filename
     * @return void
     */
    abstract public function render( $file );
}

?>
