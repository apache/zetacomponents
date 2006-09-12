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

    /**
     * List of already created gradients
     * 
     * @var array
     */
    protected $drawnGradients = array();

    /**
     * Numeric unique element id
     * 
     * @var int
     */
    protected $elementID = 0;

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphSvgDriverOptions( $options );
    }

    protected function createDocument()
    {
        if ( $this->dom === null )
        {
            if ( $this->options->templateDocument !== false )
            {
                $this->dom = new DOMDocument();
// @TODO: Add                $this->dom->format
                $this->dom->load( $this->options->templateDocument );

                $this->defs = $this->dom->getElementsByTagName( 'defs' )->item( 0 );
                $svg = $this->dom->getElementsByTagName( 'svg' )->item( 0 );
            }
            else
            {
                $this->dom = new DOMDocument();
                $svg = $this->dom->createElementNS( 'http://www.w3.org/2000/svg', 'svg' );
                $this->dom->appendChild( $svg );

                $svg->setAttribute( 'width', $this->options->width );
                $svg->setAttribute( 'height', $this->options->height );
                $svg->setAttribute( 'version', '1.0' );
                $svg->setAttribute( 'id', 'ezcGraph' );

                $this->defs = $this->dom->createElement( 'defs' );
                $this->defs = $svg->appendChild( $this->defs );
            }

            if ( $this->options->insertIntoGroup !== false )
            {
                // getElementById only works for Documents validated against a certain 
                // schema, so that the use of XPath should be faster in most cases.
                $xpath = new DomXPath( $this->dom );
                $this->elements = $xpath->query( '//*[@id = \'' . $this->options->insertIntoGroup . '\']' )->item( 0 );
                if ( !$this->elements )
                {
                    throw new ezcGraphSvgDriverInvalidIdException( $this->options->insertIntoGroup );
                }
            }
            else
            {
                $this->elements = $this->dom->createElement( 'g' );
                $this->elements->setAttribute( 'id', 'chart' );
                $this->elements->setAttribute( 'color-rendering', $this->options->colorRendering );
                $this->elements->setAttribute( 'shape-rendering', $this->options->shapeRendering );
                $this->elements->setAttribute( 'text-rendering', $this->options->textRendering );
                $this->elements = $svg->appendChild( $this->elements );
            }
        }
    }

    protected function getGradientUrl( ezcGraphColor $color )
    {
        switch ( true )
        {
            case ( $color instanceof ezcGraphLinearGradient ):
                if ( !in_array( $color->__toString(), $this->drawnGradients, true ) )
                {
                    $gradient = $this->dom->createElement( 'linearGradient' );
                    $gradient->setAttribute( 'id', 'Definition_' . $color->__toString() );
                    $this->defs->appendChild( $gradient );

                    // Start of linear gradient
                    $stop = $this->dom->createElement( 'stop' );
                    $stop->setAttribute( 'offset', 0 );
                    $stop->setAttribute( 'style', sprintf( 'stop-color: #%02x%02x%02x; stop-opacity: %.2f;',
                        $color->startColor->red,
                        $color->startColor->green,
                        $color->startColor->blue,
                        1 - ( $color->startColor->alpha / 255 )
                        )
                    );
                    $gradient->appendChild( $stop );

                    // End of linear gradient
                    $stop = $this->dom->createElement( 'stop' );
                    $stop->setAttribute( 'offset', 1 );
                    $stop->setAttribute( 'style', sprintf( 'stop-color: #%02x%02x%02x; stop-opacity: %.2f;',
                        $color->endColor->red,
                        $color->endColor->green,
                        $color->endColor->blue,
                        1 - ( $color->endColor->alpha / 255 )
                        )
                    );
                    $gradient->appendChild( $stop );

                    $gradient = $this->dom->createElement( 'linearGradient' );
                    $gradient->setAttribute( 'id', $color->__toString() );
                    $gradient->setAttribute( 'x1', $color->startPoint->x );
                    $gradient->setAttribute( 'y1', $color->startPoint->y );
                    $gradient->setAttribute( 'x2', $color->endPoint->x );
                    $gradient->setAttribute( 'y2', $color->endPoint->y );
                    $gradient->setAttribute( 'gradientUnits', 'userSpaceOnUse' );
                    $gradient->setAttributeNS( 
                        'http://www.w3.org/1999/xlink', 
                        'xlink:href',
                        '#Definition_' . $color->__toString()
                    );
                    $this->defs->appendChild( $gradient );

                    $this->drawnGradients[] = $color->__toString();
                }

                return sprintf( 'url(#%s)',
                    $color->__toString()
                );
            case ( $color instanceof ezcGraphRadialGradient ):
                if ( !in_array( $color->__toString(), $this->drawnGradients, true ) )
                {
                    $gradient = $this->dom->createElement( 'linearGradient' );
                    $gradient->setAttribute( 'id', 'Definition_' . $color->__toString() );
                    $this->defs->appendChild( $gradient );

                    // Start of linear gradient
                    $stop = $this->dom->createElement( 'stop' );
                    $stop->setAttribute( 'offset', 0 );
                    $stop->setAttribute( 'style', sprintf( 'stop-color: #%02x%02x%02x; stop-opacity: %.2f;',
                        $color->startColor->red,
                        $color->startColor->green,
                        $color->startColor->blue,
                        1 - ( $color->startColor->alpha / 255 )
                        )
                    );
                    $gradient->appendChild( $stop );

                    // End of linear gradient
                    $stop = $this->dom->createElement( 'stop' );
                    $stop->setAttribute( 'offset', 1 );
                    $stop->setAttribute( 'style', sprintf( 'stop-color: #%02x%02x%02x; stop-opacity: %.2f;',
                        $color->endColor->red,
                        $color->endColor->green,
                        $color->endColor->blue,
                        1 - ( $color->endColor->alpha / 255 )
                        )
                    );
                    $gradient->appendChild( $stop );

                    $gradient = $this->dom->createElement( 'radialGradient' );
                    $gradient->setAttribute( 'id', $color->__toString() );
                    $gradient->setAttribute( 'cx', $color->center->x );
                    $gradient->setAttribute( 'cy', $color->center->y );
                    $gradient->setAttribute( 'fx', $color->center->x );
                    $gradient->setAttribute( 'fy', $color->center->y );
                    $gradient->setAttribute( 'r', max( $color->height, $color->width ) );
                    $gradient->setAttribute( 'gradientUnits', 'userSpaceOnUse' );
                    $gradient->setAttributeNS( 
                        'http://www.w3.org/1999/xlink', 
                        'xlink:href',
                        '#Definition_' . $color->__toString()
                    );
                    $this->defs->appendChild( $gradient );

                    $this->drawnGradients[] = $color->__toString();
                }

                return sprintf( 'url(#%s)',
                    $color->__toString()
                );
            default:
                return false;
        }

    }

    protected function getStyle( ezcGraphColor $color, $filled = true, $thickness = 1 )
    {
        if ( $filled )
        {
            if ( $url = $this->getGradientUrl( $color ) )
            {
                return sprintf( 'fill: %s; stroke: none;', $url );
            }
            else
            {
                return sprintf( 'fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    1 - ( $color->alpha / 255 )
                );
            }
        }
        else
        {
            if ( $url = $this->getGradientUrl( $color ) )
            {
                return sprintf( 'fill: none; stroke: %s;', $url );
            }
            else
            {
                return sprintf( 'fill: none; stroke: #%02x%02x%02x; stroke-width: %d; stroke-opacity: %.2f; stroke-linecap: %s; stroke-linejoin: %s;',
                    $color->red,
                    $color->green,
                    $color->blue,
                    $thickness,
                    1 - ( $color->alpha / 255 ),
                    $this->options->strokeLineCap,
                    $this->options->strokeLineJoin
                );
            }
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
            $lastPoint->x + $this->options->graphOffset->x, 
            $lastPoint->y + $this->options->graphOffset->y
        );

		foreach ( $points as $point )
        {
            $pointString .= sprintf( ' L %.4f,%.4f', 
                $point->x + $this->options->graphOffset->x,
                $point->y + $this->options->graphOffset->y
            );
        }
		$pointString .= ' z ';

        $path = $this->dom->createElement( 'path' );
        $path->setAttribute( 'd', $pointString );

        $path->setAttribute(
            'style',
            $this->getStyle( $color, $filled, $thickness )
        );
        $path->setAttribute( 'id', $id = ( 'ezcGraphPolygon_' . ++$this->elementID ) );
		$this->elements->appendChild( $path );

        return $id;
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
            $start->x + $this->options->graphOffset->x, 
            $start->y + $this->options->graphOffset->y,
            $end->x + $this->options->graphOffset->x, 
            $end->y + $this->options->graphOffset->y
        );

        $path = $this->dom->createElement( 'path' );
        $path->setAttribute( 'd', $pointString );
        $path->setAttribute(
            'style', 
            $this->getStyle( $color, false, $thickness )
        );

        $path->setAttribute( 'id', $id = ( 'ezcGraphLine_' . ++$this->elementID ) );
        $this->elements->appendChild( $path );

        return $id;
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

        $this->options->font->minimalUsedFont = $size;
        $this->strings[] = array(
            'text' => $result,
            'id' => $id = ( 'ezcGraphTextBox_' . ++$this->elementID ),
            'position' => $position,
            'width' => $width,
            'height' => $height,
            'align' => $align,
            'options' => $this->options->font,
        );

        return $id;
    }

    protected function drawAllTexts()
    {
        foreach ( $this->strings as $text )
        {
            $size = $text['options']->minimalUsedFont;
            $font = $text['options']->name;

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
                $textNode->setAttribute( 'id', $text['id'] );
                $textNode->setAttribute( 'x', $position->x + $this->options->graphOffset->x );
                $textNode->setAttribute( 'text-length', ( $size * strlen( $string ) * $this->options->assumedCharacterWidth ) . 'px' );
                $textNode->setAttribute( 'y', $position->y + $this->options->graphOffset->y );
                $textNode->setAttribute( 
                    'style', 
                    sprintf(
                        'font-size: %dpx; font-family: %s; fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                        $size,
                        $text['options']->name,
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

        $Xstart = $center->x + $this->options->graphOffset->x + $width * cos( ( -$startAngle / 180 ) * M_PI );
        $Ystart = $center->y + $this->options->graphOffset->y + $height * sin( ( $startAngle / 180 ) * M_PI );
        $Xend = $center->x + $this->options->graphOffset->x + $width * cos( ( -( $endAngle ) / 180 ) * M_PI );
        $Yend = $center->y + $this->options->graphOffset->y + $height * sin( ( ( $endAngle ) / 180 ) * M_PI );
        
        $arc = $this->dom->createElement( 'path' );
        $arc->setAttribute('d', sprintf('M %.2f,%.2f L %.2f,%.2f A %.2f,%.2f 0 %d,1 %.2f,%.2f z',
            // Middle
            $center->x + $this->options->graphOffset->x, $center->y + $this->options->graphOffset->y,
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
            $this->getStyle( $color, $filled, 1 )
        );
        
        $arc->setAttribute( 'id', $id = ( 'ezcGraphCircleSector_' . ++$this->elementID ) );
        $this->elements->appendChild( $arc );
        
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
        $this->createDocument();  

        // Normalize angles
        if ( $startAngle > $endAngle )
        {
            $tmp = $startAngle;
            $startAngle = $endAngle;
            $endAngle = $tmp;
        }
        
        if ( ( $endAngle - $startAngle > 180 ) ||
             ( ( $startAngle % 180 != 0) && ( $endAngle % 180 != 0) && ( ( $startAngle % 360 > 180 ) XOR ( $endAngle % 360 > 180 ) ) ) )
        {
            // Border crosses he 180 degrees border
            $intersection = floor( $endAngle / 180 ) * 180;
            while ( $intersection >= $endAngle )
            {
                $intersection -= 180;
            }

            $this->drawCircularArc( $center, $width, $height, $size, $startAngle, $intersection, $color, $filled );
            $this->drawCircularArc( $center, $width, $height, $size, $intersection, $endAngle, $color, $filled );
            return;
        }

        // We need the radius
        $width /= 2;
        $height /= 2;

        $Xstart = $center->x + $this->options->graphOffset->x + $width * cos( -( $startAngle / 180 ) * M_PI );
        $Ystart = $center->y + $this->options->graphOffset->y + $height * sin( ( $startAngle / 180 ) * M_PI );
        $Xend = $center->x + $this->options->graphOffset->x + $width * cos( ( -( $endAngle ) / 180 ) * M_PI );
        $Yend = $center->y + $this->options->graphOffset->y + $height * sin( ( ( $endAngle ) / 180 ) * M_PI );
        
        if ( $filled === true )
        {
            $arc = $this->dom->createElement( 'path' );
            $arc->setAttribute('d', sprintf( 'M %.2f,%.2f A %.2f,%.2f 0 %d,0 %.2f,%.2f L %.2f,%.2f A %.2f,%2f 0 %d,1 %.2f,%.2f z',
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
        }
        else
        {
            $arc = $this->dom->createElement( 'path' );
            $arc->setAttribute('d', sprintf( 'M %.2f,%.2f  A %.2f,%.2f 0 %d,1 %.2f,%.2f',
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
        }

        $arc->setAttribute(
            'style', 
            $this->getStyle( $color, $filled )
        );

        $arc->setAttribute( 'id', $id = ( 'ezcGraphCircularArc_' . ++$this->elementID ) );
        $this->elements->appendChild( $arc );

        if ( ( $this->options->shadeCircularArc !== false ) &&
             $filled )
        {
            $gradient = new ezcGraphLinearGradient(
                new ezcGraphCoordinate(
                    $center->x - $width,
                    $center->y
                ),
                new ezcGraphCoordinate(
                    $center->x + $width,
                    $center->y
                ),
                ezcGraphColor::fromHex( '#FFFFFF' )->transparent( $this->options->shadeCircularArc * 1.5 ),
                ezcGraphColor::fromHex( '#000000' )->transparent( $this->options->shadeCircularArc )
            );

            $arc = $this->dom->createElement( 'path' );
            $arc->setAttribute('d', sprintf( 'M %.2f,%.2f A %.2f,%.2f 0 %d,0 %.2f,%.2f L %.2f,%.2f A %.2f,%2f 0 %d,1 %.2f,%.2f z',
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
                $this->getStyle( $gradient, $filled )
            );

            $this->elements->appendChild( $arc );
        }

        return $id;
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
        $ellipse->setAttribute( 'cx', $center->x + $this->options->graphOffset->x );
        $ellipse->setAttribute( 'cy', $center->y + $this->options->graphOffset->y );
        $ellipse->setAttribute( 'rx', $width / 2 );
        $ellipse->setAttribute( 'ry', $height / 2 );

        $ellipse->setAttribute(
            'style', 
            $this->getStyle( $color, $filled, 1 )
        );
        
        $ellipse->setAttribute( 'id', $id = ( 'ezcGraphCircle_' . ++$this->elementID ) );
        $this->elements->appendChild( $ellipse );

        return $id;
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

        $data = getimagesize( $file );
        $image = $this->dom->createElement( 'image' );

        $image->setAttribute( 'x', $position->x + $this->options->graphOffset->x );
        $image->setAttribute( 'y', $position->y + $this->options->graphOffset->y );
        $image->setAttribute( 'width', $width . 'px' );
        $image->setAttribute( 'height', $height . 'px' );
        $image->setAttributeNS( 
            'http://www.w3.org/1999/xlink', 
            'xlink:href', 
            sprintf( 'data:%s;base64,%s',
                $data['mime'],
                base64_encode( file_get_contents( $file ) )
            )
        );

        $this->elements->appendChild( $image );
        $image->setAttribute( 'id', $id = ( 'ezcGraphImage_' . ++$this->elementID ) );

        return $id;
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
