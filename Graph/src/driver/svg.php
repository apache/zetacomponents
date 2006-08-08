<?php
/**
 * File containing the ezcGraphSVGDriver class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Extension of the basic Driver package to utilize the SVGlib.
 *
 * @package Graph
 */

class ezcGraphSvgDriver extends ezcGraphDriver
{

    /**
     * DOM tree of the svg document
     * 
     * @var DOMDocument
     */
    protected $dom;

    /**
     * DOMElement containing all svg style definitions
     * 
     * @var DOMElement
     */
    protected $defs;

    /**
     * DOMElement containing all svg objects
     * 
     * @var DOMElement
     */
    protected $elements;

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
        $this->options = new ezcGraphSvgDriverOptions( $options );
    }

    protected function createDocument()
    {
        if ( $this->dom === null )
        {
            $this->dom = new DOMDocument();
            $svg = $this->dom->createElement( 'svg' );

            $svg->setAttribute( 'xmlns', 'http://www.w3.org/2000/svg' );
            $svg->setAttribute( 'width', $this->options->width );
            $svg->setAttribute( 'height', $this->options->height );
            $svg->setAttribute( 'version', '1.0' );
            $svg->setAttribute( 'id', 'ezcGraph' );
            $this->dom->appendChild( $svg );

            $this->defs = $this->dom->createElement( 'defs' );
            $this->defs = $svg->appendChild( $this->defs );

            $this->elements = $this->dom->createElement( 'g' );
            $this->elements->setAttribute( 'id', 'chart' );
            $this->elements->setAttribute( 'color-rendering', $this->options->colorRendering );
            $this->elements->setAttribute( 'shape-rendering', $this->options->shapeRendering );
            $this->elements->setAttribute( 'text-rendering', $this->options->textRendering );
            $this->elements = $svg->appendChild( $this->elements );
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
    public function drawPolygon( array $points, ezcGraphColor $color, $filled = true, $thickness = 1 )
    {
        $this->createDocument();

		$lastPoint = end( $points );
        $pointString = sprintf( ' M %.4f,%.4f', 
            $lastPoint->x, 
            $lastPoint->y
        );

		foreach ( $points as $point )
        {
            $pointString .= sprintf( ' L %.4f,%.4f', 
                $point->x,
                $point->y
            );
        }
		$pointString .= ' z ';

        $path = $this->dom->createElement( 'path' );
        $path->setAttribute( 'd', $pointString );

        if ( $filled )
        {
            $path->setAttribute(
                'style', 
                sprintf( 'fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    1 - ( $color->alpha / 255 )
                )
            );
        }
        else
        {
            $path->setAttribute(
                'style', 
                sprintf( 'fill: none; stroke: #%02x%02x%02x; stroke-width: %d; stroke-opacity: %.2f; stroke-linecap: %s;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    $thickness,
                    1 - ( $color->alpha / 255 ),
                    $this->options->strokeLineCap
                )
            );
        }
		
		$this->elements->appendChild( $path );
    }
    
    /**
     * Draws a single line
     * 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param ezcGraphColor $color 
     * @return void
     */
    public function drawLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color, $thickness = 1 )
    {
        $this->createDocument();  
        
        $pointString = sprintf( ' M %.4f,%.4f L %.4f,%.4f', 
            $start->x, 
            $start->y,
            $end->x, 
            $end->y
        );

        $path = $this->dom->createElement( 'path' );
        $path->setAttribute( 'd', $pointString );
        $path->setAttribute(
            'style', 
            sprintf( 'fill: none; stroke: #%02x%02x%02x; stroke-width: %d; stroke-opacity: %.2f; stroke-linecap: %s;',
                $color->red,
                $color->green,
                $color->blue,
                $thickness,
                1 - ( $color->alpha / 255 ),
                $this->options->strokeLineCap
            )
        );

        $this->elements->appendChild( $path );
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

            // Assume characters have the same width as height
            $strWidth = $size * strlen( implode( ' ', $selectedLine ) ) * $this->options->assumedCharacterWidth;

            // Check if line is too long
            if ( $strWidth > $width )
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
        $strWidth = $size * strlen( implode( ' ', $selectedLine ) ) * $this->options->assumedCharacterWidth;
        if ( $strWidth > $width ) {
            return false;
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
    }

    protected function drawAllTexts()
    {
        foreach ( $this->strings as $text )
        {
            $size = $text['options']->minimalUsedFont;
            $font = $text['options']->font;

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
                $text['position']->y += $size;

                switch ( true )
                {
                    case ( $text['align'] & ezcGraph::LEFT ):
                        $position = new ezcGraphCoordinate(
                            $text['position']->x, 
                            $text['position']->y + $yOffset
                        );
                        break;
                    case ( $text['align'] & ezcGraph::RIGHT ):
                        $position = new ezcGraphCoordinate(
                            $text['position']->x + ( $text['width'] - $size * strlen( $string ) * $this->options->assumedCharacterWidth ), 
                            $text['position']->y + $yOffset
                        );
                        break;
                    case ( $text['align'] & ezcGraph::CENTER ):
                        $position = new ezcGraphCoordinate(
                            $text['position']->x + ( ( $text['width'] - $size * strlen( $string ) * $this->options->assumedCharacterWidth ) / 2 ),
                            $text['position']->y + $yOffset
                        );
                        break;
                }

                $textNode = $this->dom->createElement( 'text', $string );
                $textNode->setAttribute( 'x', $position->x );
                $textNode->setAttribute( 'text-length', ( $size * strlen( $string ) * $this->options->assumedCharacterWidth ) . 'px' );
                $textNode->setAttribute( 'y', $position->y );
                $textNode->setAttribute( 
                    'style', 
                    sprintf(
                        'font-size: %dpx; font-family: sans-serif; fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                        $size,
                        $text['options']->color->red,
                        $text['options']->color->green,
                        $text['options']->color->blue,
                        1 - ( $text['options']->color->alpha / 255 )
                    )
                );

                $this->elements->appendChild( $textNode );

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
    public function drawCircleSector( ezcGraphCoordinate $center, $width, $height, $startAngle, $endAngle, ezcGraphColor $color, $filled = true )
    {
        $this->createDocument();  

        // Normalize angles
        if ( $startAngle > $endAngle )
        {
            $tmp = $startAngle;
            $startAngle = $endAngle;
            $endAngle = $tmp;
        }
        
        // We need the radius
        $width /= 2;
        $height /= 2;

        $Xstart = $center->x + $width * cos( ( -$startAngle / 180 ) * M_PI );
        $Ystart = $center->y + $height * sin( ( $startAngle / 180 ) * M_PI );
        $Xend = $center->x + $width * cos( ( -( $endAngle ) / 180 ) * M_PI );
        $Yend = $center->y + $height * sin( ( ( $endAngle ) / 180 ) * M_PI );
        
        $arc = $this->dom->createElement( 'path' );
        $arc->setAttribute('d', sprintf('M %.2f,%.2f L %.2f,%.2f A %.2f,%2f 0 %d,1 %.2f,%.2f z',
            // Middle
            $center->x, $center->y,
            // Startpoint
            $Xstart, $Ystart,
            // Radius
            $width, $height,
            // SVG-Stuff
            ( $endAngle - $startAngle ) > 180,
            // Endpoint
            $Xend, $Yend
            )
        );

        if ( $filled )
        {
            $arc->setAttribute(
                'style', 
                sprintf( 'fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    1 - ( $color->alpha / 255 )
                )
            );
        }
        else
        {
            $arc->setAttribute(
                'style', 
                sprintf( 'fill: none; stroke: #%02x%02x%02x; stroke-width: %d; stroke-opacity: %.2f; stroke-linecap: %s;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    1, // Line Thickness
                    1 - ( $color->alpha / 255 ),
                    $this->options->strokeLineCap
                )
            );
        }
        
        $this->elements->appendChild( $arc );
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
        $this->createDocument();  

        // Normalize angles
        if ( $startAngle > $endAngle )
        {
            $tmp = $startAngle;
            $startAngle = $endAngle;
            $endAngle = $tmp;
        }
        
        // We need the radius
        $width /= 2;
        $height /= 2;

        $Xstart = $center->x + $width * cos( ( -$startAngle / 180 ) * M_PI );
        $Ystart = $center->y + $height * sin( ( $startAngle / 180 ) * M_PI );
        $Xend = $center->x + $width * cos( ( -( $endAngle ) / 180 ) * M_PI );
        $Yend = $center->y + $height * sin( ( ( $endAngle ) / 180 ) * M_PI );
        
        $arc = $this->dom->createElement( 'path' );
        $arc->setAttribute('d', sprintf('   M %.2f,%.2f 
                                            A %.2f,%2f 0 %d,0 %.2f,%.2f 
                                            L %.2f,%.2f 
                                            A %.2f,%2f 0 %d,1 %.2f,%.2f z',
            // Endpoint low
            $Xend, $Yend + $size,
            // Radius
            $width, $height,
            // SVG-Stuff
            ( $endAngle - $startAngle ) > 180,
            // Startpoint low
            $Xstart, $Ystart + $size,
            // Startpoint
            $Xstart, $Ystart,
            // Radius
            $width, $height,
            // SVG-Stuff
            ( $endAngle - $startAngle ) > 180,
            // Endpoint
            $Xend, $Yend
            )
        );

        $arc->setAttribute(
            'style', 
            sprintf( 'fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                $color->red,
                $color->green,
                $color->blue,
                1 - ( $color->alpha / 255 )
            )
        );

        $this->elements->appendChild( $arc );
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
        $this->createDocument();  
        
        $ellipse = $this->dom->createElement('ellipse');
        $ellipse->setAttribute( 'cx', $center->x );
        $ellipse->setAttribute( 'cy', $center->y );
        $ellipse->setAttribute( 'rx', $width / 2 );
        $ellipse->setAttribute( 'ry', $height / 2 );

        if ( $filled )
        {
            $ellipse->setAttribute(
                'style', 
                sprintf( 'fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    1 - ( $color->alpha / 255 )
                )
            );
        }
        else
        {
            $ellipse->setAttribute(
                'style', 
                sprintf( 'fill: none; stroke: #%02x%02x%02x; stroke-width: %d; stroke-opacity: %.2f; stroke-linecap: %s;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    1, // Line Thickness
                    1 - ( $color->alpha / 255 ),
                    $this->options->strokeLineCap
                )
            );
        }
        
        $this->elements->appendChild( $ellipse );
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
        $this->createDocument();  
        
        // @TODO: Inline images instead of linking them
        /*
        $image = $this->dom->createElement( 'image' );
        $image->setAttribute( 'x', $position->x );
        $image->setAttribute( 'y', $position->y );
        $image->setAttribute( 'width', $width . 'px' );
        $image->setAttribute( 'height', $height . 'px' );
        $image->setAttribute( 'xlink:href', $file );

        $this->elements->appendChild( $image );
        */
    }

    /**
     * Finally save image
     * 
     * @param mixed $file 
     * @return void
     */
    public function render ( $file )
    {
        $this->createDocument();  
        $this->drawAllTexts();
        $this->dom->save( $file );
    }
}

?>
