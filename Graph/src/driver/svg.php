<?php
/**
 * File containing the ezcGraphSVGDriver class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Extension of the basic Driver package to utilize the SVGlib.
 *
 * @package Graph
 * @mainclass
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

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        ezcBase::checkDependency( 'Graph', ezcBase::DEP_PHP_EXTENSION, 'dom' );
        $this->options = new ezcGraphSvgDriverOptions( $options );
    }

    /**
     * Creates the DOM object to insert SVG nodes in.
     *
     * If the DOM document does not exists it will be created or loaded 
     * according to the settings.
     * 
     * @return void
     */
    protected function createDocument()
    {
        if ( $this->dom === null )
        {
            // Create encoding based dom document
            if ( $this->options->encoding !== null )
            {
                $this->dom = new DOMDocument( '1.0', $this->options->encoding );
            }
            else
            {
                $this->dom = new DOMDocument( '1.0' );
            }

            if ( $this->options->templateDocument !== false )
            {
// @TODO: Add                $this->dom->format
                $this->dom->load( $this->options->templateDocument );

                $this->defs = $this->dom->getElementsByTagName( 'defs' )->item( 0 );
                $svg = $this->dom->getElementsByTagName( 'svg' )->item( 0 );
            }
            else
            {
                $svg = $this->dom->createElementNS( 'http://www.w3.org/2000/svg', 'svg' );
                $this->dom->appendChild( $svg );

                $svg->setAttribute( 'width', $this->options->width );
                $svg->setAttribute( 'height', $this->options->height );
                $svg->setAttribute( 'version', '1.0' );
                $svg->setAttribute( 'id', $this->options->idPrefix );

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
                $this->elements->setAttribute( 'id', $this->options->idPrefix . 'Chart' );
                $this->elements->setAttribute( 'color-rendering', $this->options->colorRendering );
                $this->elements->setAttribute( 'shape-rendering', $this->options->shapeRendering );
                $this->elements->setAttribute( 'text-rendering', $this->options->textRendering );
                $this->elements = $svg->appendChild( $this->elements );
            }
        }
    }

    /**
     * Return gradient URL
     *
     * Creates the definitions needed for a gradient, if a proper gradient does
     * not yet exists. In each case a URL referencing the correct gradient will
     * be returned.
     * 
     * @param ezcGraphColor $color Gradient
     * @return string Gradient URL
     */
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
                    $gradient->setAttribute( 'x1', round( $color->startPoint->x, 4 ) );
                    $gradient->setAttribute( 'y1', round( $color->startPoint->y, 4 ) );
                    $gradient->setAttribute( 'x2', round( $color->endPoint->x, 4 ) );
                    $gradient->setAttribute( 'y2', round( $color->endPoint->y, 4 ) );
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
                    $gradient->setAttribute( 'cx', round( $color->center->x, 4 ) );
                    $gradient->setAttribute( 'cy', round( $color->center->y, 4 ) );
                    $gradient->setAttribute( 'fx', round( $color->center->x, 4 ) );
                    $gradient->setAttribute( 'fy', round( $color->center->y, 4 ) );
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

    /**
     * Get SVG style definition
     *
     * Returns a string with SVG style definitions created from color, 
     * fillstatus and line thickness.
     * 
     * @param ezcGraphColor $color Color
     * @param mixed $filled Filled
     * @param float $thickness Line thickness.
     * @return string Formatstring
     */
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
        $this->createDocument();

        if ( !$filled )
        {
            // The middle of the border is on the outline of a polygon in SVG, 
            // fix that:
            $points = $this->reducePolygonSize( $points, $thickness / 2 );
        }

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
        $path->setAttribute( 'id', $id = ( $this->options->idPrefix . 'Polygon_' . ++$this->elementID ) );
        $this->elements->appendChild( $path );

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

        $path->setAttribute( 'id', $id = ( $this->options->idPrefix . 'Line_' . ++$this->elementID ) );
        $this->elements->appendChild( $path );

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
        return new ezcGraphBoundings(
            0,
            0,
            $this->getTextWidth( $text, $size ),
            $size
        );
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
        $padding = $this->options->font->padding + ( $this->options->font->border !== false ? $this->options->font->borderWidth : 0 );

        $width -= $padding * 2;
        $height -= $padding * 2;
        $textPosition = new ezcGraphCoordinate(
            $position->x + $padding,
            $position->y + $padding
        );

        // Try to get a font size for the text to fit into the box
        $maxSize = min( $height, $this->options->font->maxFontSize );
        $result = false;
        for ( $size = $maxSize; $size >= $this->options->font->minFontSize; )
        {
            $result = $this->testFitStringInTextBox( $string, $position, $width, $height, $size );
            if ( is_array( $result ) )
            {
                break;
            }
            $size = ( ( $newsize = $size * ( $result ) ) >= $size ? $size - 1 : floor( $newsize ) );
        }
        
        if ( !is_array( $result ) )
        {
            throw new ezcGraphFontRenderingException( $string, $this->options->font->minFontSize, $width, $height );
        }

        $this->options->font->minimalUsedFont = $size;
        $this->strings[] = array(
            'text' => $result,
            'id' => $id = ( $this->options->idPrefix . 'TextBox_' . ++$this->elementID ),
            'position' => $textPosition,
            'width' => $width,
            'height' => $height,
            'align' => $align,
            'font' => $this->options->font,
        );

        return $id;
    }

    /**
     * Guess text width for string
     *
     * The is no way to know the font or fontsize used by the SVG renderer to
     * render the string. We assume some character width defined in the SVG 
     * driver options, tu guess the length of a string. We discern between
     * numeric an non numeric strings, because we often use only numeric 
     * strings to display chart data and numbers tend to be a bit wider then
     * characters.
     * 
     * @param mixed $string 
     * @param mixed $size 
     * @access protected
     * @return void
     */
    protected function getTextWidth( $string, $size )
    {
        switch ( strtolower( $this->options->encoding ) )
        {
            case '':
            case 'utf-8':
            case 'utf-16':
                $string = utf8_decode( $string );
            break;
        }

        if ( is_numeric( $string ) )
        {
            return $size * strlen( $string ) * $this->options->assumedNumericCharacterWidth;
        }
        else
        {
            return $size * strlen( $string ) * $this->options->assumedTextCharacterWidth;
        }
    }

    /**
     * Encodes non-utf-8 strings
     *
     * Transforms non-utf-8 strings to their hex entities, because ext/DOM 
     * fails here with conversion errors.
     * 
     * @param string $string 
     * @return string
     */
    protected function encode( $string )
    {
        $string = htmlspecialchars( $string );

        switch ( strtolower( $this->options->encoding ) )
        {
            case '':
            case 'utf-8':
            case 'utf-16':
                return $string;
            default:
                // Manual escaping of non ANSII characters, because ext/DOM fails here
                return preg_replace_callback( 
                    '/[\\x80-\\xFF]/', 
                    create_function(
                        '$char',
                        'return sprintf( \'&#x%02x;\', ord( $char[0] ) );'
                    ),
                    $string 
                );
        }
    }

    /**
     * Draw all collected texts
     *
     * The texts are collected and their maximum possible font size is 
     * calculated. This function finally draws the texts on the image, this
     * delayed drawing has two reasons:
     *
     * 1) This way the text strings are always on top of the image, what 
     *    results in better readable texts
     * 2) The maximum possible font size can be calculated for a set of texts
     *    with the same font configuration. Strings belonging to one chart 
     *    element normally have the same font configuration, so that all texts
     *    belonging to one element will have the same font size.
     * 
     * @access protected
     * @return void
     */
    protected function drawAllTexts()
    {
        $elementsRoot = $this->elements;

        foreach ( $this->strings as $text )
        {
            // Add all text elements into one group
            $this->elements = $this->dom->createElement( 'g' );
            $this->elements->setAttribute( 'id', $text['id'] );
            $this->elements = $elementsRoot->appendChild( $this->elements );

            $size = $text['font']->minimalUsedFont;
            $font = $text['font']->name;

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

            $padding = $text['font']->padding + $text['font']->borderWidth / 2;
            if ( $this->options->font->minimizeBorder === true )
            {
                // Calculate maximum width of text rows
                $width = false;
                foreach ( $text['text'] as $line )
                {
                    $string = implode( ' ', $line );
                    if ( ( $strWidth = $this->getTextWidth( $string, $size ) ) > $width )
                    {
                        $width = $strWidth;
                    }
                }

                switch ( true )
                {
                    case ( $text['align'] & ezcGraph::LEFT ):
                        $xOffset = 0;
                        break;
                    case ( $text['align'] & ezcGraph::CENTER ):
                        $xOffset = ( $text['width'] - $width ) / 2;
                        break;
                    case ( $text['align'] & ezcGraph::RIGHT ):
                        $xOffset = $text['width'] - $width;
                        break;
                }

                $borderPolygonArray = array(
                    new ezcGraphCoordinate(
                        $text['position']->x - $padding + $xOffset,
                        $text['position']->y - $padding + $yOffset
                    ),
                    new ezcGraphCoordinate(
                        $text['position']->x + $padding * 2 + $xOffset + $width,
                        $text['position']->y - $padding + $yOffset
                    ),
                    new ezcGraphCoordinate(
                        $text['position']->x + $padding * 2 + $xOffset + $width,
                        $text['position']->y + $padding * 2 + $yOffset + $completeHeight
                    ),
                    new ezcGraphCoordinate(
                        $text['position']->x - $padding + $xOffset,
                        $text['position']->y + $padding * 2 + $yOffset + $completeHeight
                    ),
                );
            }
            else
            {
                $borderPolygonArray = array(
                    new ezcGraphCoordinate(
                        $text['position']->x - $padding,
                        $text['position']->y - $padding
                    ),
                    new ezcGraphCoordinate(
                        $text['position']->x + $padding * 2 + $text['width'],
                        $text['position']->y - $padding
                    ),
                    new ezcGraphCoordinate(
                        $text['position']->x + $padding * 2 + $text['width'],
                        $text['position']->y + $padding * 2 + $text['height']
                    ),
                    new ezcGraphCoordinate(
                        $text['position']->x - $padding,
                        $text['position']->y + $padding * 2 + $text['height']
                    ),
                );
            }

            if ( $text['font']->background !== false )
            {
                $this->drawPolygon( 
                    $borderPolygonArray, 
                    $text['font']->background,
                    true
                );
            }
            else
            {
                // Always draw full tranparent background polygon as fallback, 
                // to be able to click on complete font space, not only on 
                // the text
                $this->drawPolygon( 
                    $borderPolygonArray, 
                    ezcGraphColor::fromHex( '#FFFFFFFF' ),
                    true
                );
            }

            if ( $text['font']->border !== false )
            {
                $this->drawPolygon( 
                    $borderPolygonArray, 
                    $text['font']->border,
                    false,
                    $text['font']->borderWidth
                );
            }

            // Bottom line for SVG fonts is lifted a bit
            $text['position']->y += $size * .85;

            // Render text with evaluated font size
            foreach ( $text['text'] as $line )
            {
                $string = implode( ' ', $line );

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
                            $text['position']->x + ( $text['width'] - $this->getTextWidth( $string, $size ) ),
                            $text['position']->y + $yOffset
                        );
                        break;
                    case ( $text['align'] & ezcGraph::CENTER ):
                        $position = new ezcGraphCoordinate(
                            $text['position']->x + ( ( $text['width'] - $this->getTextWidth( $string, $size ) ) / 2 ),
                            $text['position']->y + $yOffset
                        );
                        break;
                }

                // Optionally draw text shadow
                if ( $text['font']->textShadow === true )
                {
                    $textNode = $this->dom->createElement( 'text', $this->encode( $string ) );
                    $textNode->setAttribute( 'id', $text['id'] . '_shadow' );
                    $textNode->setAttribute( 'x', round( $position->x + $this->options->graphOffset->x + $text['font']->textShadowOffset, 4 ) );
                    $textNode->setAttribute( 'text-length', round( $this->getTextWidth( $string, $size ), 4 ) . 'px' );
                    $textNode->setAttribute( 'y', round( $position->y + $this->options->graphOffset->y + $text['font']->textShadowOffset, 4 ) );
                    $textNode->setAttribute( 
                        'style', 
                        sprintf(
                            'font-size: %dpx; font-family: %s; fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                            $size,
                            $text['font']->name,
                            $text['font']->textShadowColor->red,
                            $text['font']->textShadowColor->green,
                            $text['font']->textShadowColor->blue,
                            1 - ( $text['font']->textShadowColor->alpha / 255 )
                        )
                    );
                    $this->elements->appendChild( $textNode );
                }
                
                // Finally draw text
                $textNode = $this->dom->createElement( 'text', $this->encode( $string ) );
                $textNode->setAttribute( 'id', $text['id'] . '_text' );
                $textNode->setAttribute( 'x', round( $position->x + $this->options->graphOffset->x, 4 ) );
                $textNode->setAttribute( 'text-length', round( $this->getTextWidth( $string, $size ), 4 ) . 'px' );
                $textNode->setAttribute( 'y', round( $position->y + $this->options->graphOffset->y, 4 ) );
                $textNode->setAttribute( 
                    'style', 
                    sprintf(
                        'font-size: %dpx; font-family: %s; fill: #%02x%02x%02x; fill-opacity: %.2f; stroke: none;',
                        $size,
                        $text['font']->name,
                        $text['font']->color->red,
                        $text['font']->color->green,
                        $text['font']->color->blue,
                        1 - ( $text['font']->color->alpha / 255 )
                    )
                );
                $this->elements->appendChild( $textNode );

                $text['position']->y += $size + $size * $this->options->lineSpacing;
            }
        }

        $this->elements = $elementsRoot;
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
     * @param mixed $filled Filled;
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
        
        if ( ( $endAngle - $startAngle ) >= 360 )
        {
            return $this->drawCircle( $center, $width, $height, $color, $filled );
        }

        // We need the radius
        $width /= 2;
        $height /= 2;

        $Xstart = $center->x + $this->options->graphOffset->x + $width * cos( ( -$startAngle / 180 ) * M_PI );
        $Ystart = $center->y + $this->options->graphOffset->y + $height * sin( ( $startAngle / 180 ) * M_PI );
        $Xend = $center->x + $this->options->graphOffset->x + $width * cos( ( -( $endAngle ) / 180 ) * M_PI );
        $Yend = $center->y + $this->options->graphOffset->y + $height * sin( ( ( $endAngle ) / 180 ) * M_PI );
        
        $arc = $this->dom->createElement( 'path' );
        $arc->setAttribute( 'd', sprintf( 'M %.2f,%.2f L %.2f,%.2f A %.2f,%.2f 0 %d,1 %.2f,%.2f z',
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
        
        $arc->setAttribute( 'id', $id = ( $this->options->idPrefix . 'CircleSector_' . ++$this->elementID ) );
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
            $arc->setAttribute( 'd', sprintf( 'M %.2f,%.2f A %.2f,%.2f 0 %d,0 %.2f,%.2f L %.2f,%.2f A %.2f,%2f 0 %d,1 %.2f,%.2f z',
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
            $arc->setAttribute( 'd', sprintf( 'M %.2f,%.2f  A %.2f,%.2f 0 %d,1 %.2f,%.2f',
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

        $arc->setAttribute( 'id', $id = ( $this->options->idPrefix . 'CircularArc_' . ++$this->elementID ) );
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
            $arc->setAttribute( 'd', sprintf( 'M %.2f,%.2f A %.2f,%.2f 0 %d,0 %.2f,%.2f L %.2f,%.2f A %.2f,%2f 0 %d,1 %.2f,%.2f z',
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
        $this->createDocument();  
        
        $ellipse = $this->dom->createElement( 'ellipse' );
        $ellipse->setAttribute( 'cx', round( $center->x + $this->options->graphOffset->x, 4 ) );
        $ellipse->setAttribute( 'cy', round( $center->y + $this->options->graphOffset->y, 4 ) );
        $ellipse->setAttribute( 'rx', round( $width / 2 - ( $filled ? 0 : .5 ), 4 ) );
        $ellipse->setAttribute( 'ry', round( $height / 2 - ( $filled ? 0 : .5 ), 4 ) );

        $ellipse->setAttribute(
            'style', 
            $this->getStyle( $color, $filled, 1 )
        );
        
        $ellipse->setAttribute( 'id', $id = ( $this->options->idPrefix . 'Circle_' . ++$this->elementID ) );
        $this->elements->appendChild( $ellipse );

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
        $this->createDocument();

        $data = getimagesize( $file );
        $image = $this->dom->createElement( 'image' );

        $image->setAttribute( 'x', round( $position->x + $this->options->graphOffset->x, 4 ) );
        $image->setAttribute( 'y', round( $position->y + $this->options->graphOffset->y, 4 ) );
        $image->setAttribute( 'width', round( $width, 4 ) . 'px' );
        $image->setAttribute( 'height', round( $height, 4 ) . 'px' );
        $image->setAttributeNS( 
            'http://www.w3.org/1999/xlink', 
            'xlink:href', 
            sprintf( 'data:%s;base64,%s',
                $data['mime'],
                base64_encode( file_get_contents( $file ) )
            )
        );

        $this->elements->appendChild( $image );
        $image->setAttribute( 'id', $id = ( $this->options->idPrefix . 'Image_' . ++$this->elementID ) );

        return $id;
    }

    /**
     * Return mime type for current image format
     * 
     * @return string
     */
    public function getMimeType()
    {
        return 'image/svg+xml';
    }

    /**
     * Finally save image
     * 
     * @param string $file Destination filename
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
