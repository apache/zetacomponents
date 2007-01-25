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

            $x = $points[$nextPoint]->x - $points[$i]->x;
            $y = $points[$nextPoint]->y - $points[$i]->y;

            $length = sqrt(
                pow( $x, 2 ) + 
                pow( $y, 2 )
            );

            if ( $length == 0 )
            {
                $vectors[$i] = new ezcGraphCoordinate( $x, $y );
            }
            else
            {
                $vectors[$i] = new ezcGraphCoordinate(
                    $x / $length,
                    $y / $length
                );
            }
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

            // Calculate new point: Move point to the center site of the 
            // polygon using the normalized orthogonal vectors next to the 
            // point and the size as distance to move.
            $newPoints[$next] = new ezcGraphCoordinate(
                $points[$next]->x
                    + $sign * $vectors[$last]->y * $size
                    + $sign * $vectors[$next]->y * $size,
                $points[$next]->y
                    - $sign * $vectors[$last]->x * $size
                    - $sign * $vectors[$next]->x * $size
            );
        }

        return $newPoints;
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
