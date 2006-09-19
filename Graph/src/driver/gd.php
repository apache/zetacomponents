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
     * Array with image files to draw
     * 
     * @var array
     */
    protected $preProcessImages = array();

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
     * Contains ressources for already loaded ps fonts.
     *  array(
     *      path => ressource
     *  )
     * 
     * @var array
     */
    protected $psFontRessources = array();

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphGdDriverOptions( $options );
    }

    protected function getImage()
    {
        if ( !isset( $this->image ) )
        {
            $this->image = imagecreatetruecolor( 
                $this->supersample( $this->options->width ), 
                $this->supersample( $this->options->height )
            );

            // Default to a transparent white background
            $bgColor = imagecolorallocatealpha( $this->image, 255, 255, 255, 127 );
            imagealphablending( $this->image, true );
            imagesavealpha( $this->image, true );
            imagefill( $this->image, 1, 1, $bgColor );

            imagesetthickness( 
                $this->image, 
                $this->options->supersampling
            );
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
                throw new ezcGraphGdDriverUnsupportedImageTypeException( $data[2] );
        }
    }

    protected function supersample( $value )
    {
        $mod = (int) floor( $this->options->supersampling / 2 );
        return $value * $this->options->supersampling - $mod;
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
        $image = $this->getImage();

        $drawColor = $this->allocate( $color );

        // Create point array
        $pointCount = count( $points );
        $pointArray = array();
        for ( $i = 0; $i < $pointCount; ++$i )
        {
            $pointArray[] = $this->supersample( $points[$i]->x );
            $pointArray[] = $this->supersample( $points[$i]->y );
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

        return $points;
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
        $image = $this->getImage();

        $drawColor = $this->allocate( $color );

        imagesetthickness( 
            $this->image, 
            $this->options->supersampling * $thickness
        );

        imageline( 
            $image, 
            $this->supersample( $start->x ), 
            $this->supersample( $start->y ), 
            $this->supersample( $end->x ), 
            $this->supersample( $end->y ), 
            $drawColor
        );

        imagesetthickness( 
            $this->image, 
            $this->options->supersampling
        );

        return array();
    }
    
    /**
     * Returns boundings of text
     * 
     * @param float $size Textsize
     * @param ezcGraphFontOptions $font Font
     * @param string $text Text
     * @return ezcGraphBoundings Boundings of text
     */
    protected function getTextBoundings( $size, ezcGraphFontOptions $font, $text )
    {
        switch( $font->type )
        {
            case ezcGraph::PS_FONT:
                if ( !isset( $this->psFontRessources[$font->path] ) )
                {
                    $this->psFontRessources[$font->path] = imagePsLoadFont( $font->path );
                }

                $boundings = imagePsBBox( $text, $this->psFontRessources[$font->path], $size );
                return new ezcGraphBoundings(
                    $boundings[0],
                    $boundings[1],
                    $boundings[2],
                    $boundings[3]
                );
            case ezcGraph::TTF_FONT:
                switch ( true )
                {
                    case ezcBaseFeatures::hasFunction( 'imageftbbox' ) && !$this->options->forceNativeTTF:
                        $boundings = imageFtBBox( $size, 0, $font->path, $text );
                        return new ezcGraphBoundings(
                            $boundings[0],
                            $boundings[1],
                            $boundings[4],
                            $boundings[5]
                        );
                    case ezcBaseFeatures::hasFunction( 'imagettfbbox' ):
                        $boundings = imageTtfBBox( $size, 0, $font->path, $text );
                        return new ezcGraphBoundings(
                            $boundings[0],
                            $boundings[1],
                            $boundings[4],
                            $boundings[5]
                        );
                }
                break;
        }
    }

    /**
     * Render text depending of font type and available font extensions
     * 
     * @param ressource $image Image ressource
     * @param string $text Text
     * @param ezcGraphFontOptions $font Font
     * @param ezcGraphCoordinate $position Position
     * @param float $size Textsize
     * @param ezcGraphColor $color Textcolor 
     * @return void
     */
    protected function renderText( $image, $text, ezcGraphFontOptions $font, ezcGraphCoordinate $position, $size )
    {
        switch( $font->type )
        {
            case ezcGraph::PS_FONT:
                imagePsText( 
                    $image, 
                    $text, 
                    $this->psFontRessources[$font->path], 
                    $size, 
                    $this->allocate( $font->color ), 
                    1, 
                    $position->x, 
                    $position->y 
                );
                break;
            case ezcGraph::TTF_FONT:
                switch ( true )
                {
                    case ezcBaseFeatures::hasFunction( 'imagefttext' ) && !$this->options->forceNativeTTF:
                        imageFtText(
                            $image, 
                            $size,
                            0,
                            $position->x,
                            $position->y,
                            $this->allocate( $font->color ),
                            $font->path,
                            $text
                        );
                        break;
                    case ezcBaseFeatures::hasFunction( 'imagettftext' ):
                        imageTtfText(
                            $image, 
                            $size,
                            0,
                            $position->x,
                            $position->y,
                            $this->allocate( $font->color ),
                            $font->path,
                            $text
                        );
                        break;
                }
                break;
        }
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
        if ( $boundings->width > $width ) {
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
        // Test font
        if ( !is_file( $this->options->font->path ) || !is_readable( $this->options->font->path ) )
        {
            throw new ezcGraphGdDriverInvalidFontException( $this->options->font->path );
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

        return array(
            clone $position,
            new ezcGraphCoordinate( $position->x + $width, $position->y ),
            new ezcGraphCoordinate( $position->x + $width, $position->y + $height ),
            new ezcGraphCoordinate( $position->x, $position->y + $height ),
        );
    }
    
    protected function drawAllTexts()
    {
        $image = $this->getImage();

        foreach ( $this->strings as $text )
        {
            $size = $text['font']->minimalUsedFont;

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
                    $boundings = $this->getTextBoundings( $size, $text['font'], $string );
                    if ( ( $width === false) || ( $boundings->width > $width ) )
                    {
                        $width = $boundings->width;
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

            if ( $text['font']->border !== false )
            {
                $this->drawPolygon( 
                    $borderPolygonArray, 
                    $text['font']->border,
                    false,
                    $text['font']->borderWidth
                );
            }

            // Render text with evaluated font size
            foreach ( $text['text'] as $line )
            {
                $string = implode( ' ', $line );
                $boundings = $this->getTextBoundings( $size, $text['font'], $string );
                $text['position']->y += $size;

                switch ( true )
                {
                    case ( $text['align'] & ezcGraph::LEFT ):
                        $this->renderText( 
                            $image, 
                            $string,
                            $text['font'], 
                            new ezcGraphCoordinate( 
                                $text['position']->x, 
                                $text['position']->y + $yOffset
                            ),
                            $size
                        );
                        break;
                    case ( $text['align'] & ezcGraph::RIGHT ):
                        $this->renderText( 
                            $image, 
                            $string,
                            $text['font'], 
                            new ezcGraphCoordinate( 
                                $text['position']->x + ( $text['width'] - $boundings->width ), 
                                $text['position']->y + $yOffset
                            ),
                            $size
                        );
                        break;
                    case ( $text['align'] & ezcGraph::CENTER ):
                        $this->renderText( 
                            $image, 
                            $string,
                            $text['font'], 
                            new ezcGraphCoordinate( 
                                $text['position']->x + ( ( $text['width'] - $boundings->width ) / 2 ), 
                                $text['position']->y + $yOffset
                            ),
                            $size
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
    public function drawCircleSector( ezcGraphCoordinate $center, $width, $height, $startAngle, $endAngle, ezcGraphColor $color, $filled = true )
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

        if ( $filled )
        {
            imagefilledarc( 
                $image, 
                $this->supersample( $center->x ), 
                $this->supersample( $center->y ), 
                $this->supersample( $width ), 
                $this->supersample( $height ), 
                $startAngle, 
                $endAngle, 
                $drawColor, 
                IMG_ARC_PIE 
            );
        }
        else
        {
            imagefilledarc( 
                $image, 
                $this->supersample( $center->x ), 
                $this->supersample( $center->y ), 
                $this->supersample( $width ), 
                $this->supersample( $height ), 
                $startAngle, 
                $endAngle, 
                $drawColor, 
                IMG_ARC_PIE | IMG_ARC_NOFILL | IMG_ARC_EDGED
            );
        }

        // Create polygon array to return
        $polygonArray = array( $center );
        for ( $angle = $startAngle; $angle < $endAngle; $angle += $this->options->imageMapResolution )
        {
            $polygonArray[] = new ezcGraphCoordinate(
                $center->x + 
                    ( ( cos( deg2rad( $angle ) ) * $width ) / 2 ),
                $center->y + 
                    ( ( sin( deg2rad( $angle ) ) * $height ) / 2 )
            );
        }
        $polygonArray[] = new ezcGraphCoordinate(
            $center->x + 
                ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
            $center->y + 
                ( ( sin( deg2rad( $endAngle ) ) * $height ) / 2 )
        );

        return $polygonArray;
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
                        ( ( sin( deg2rad( $startAngle ) ) * $height ) / 2 ) + $size
                ),
                new ezcGraphCoordinate(
                    $center->x + 
                        ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
                    $center->y + 
                        ( ( sin( deg2rad( $endAngle ) ) * $height ) / 2 ) + $size
                ),
                new ezcGraphCoordinate(
                    $center->x + 
                        ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
                    $center->y + 
                        ( ( sin( deg2rad( $endAngle ) ) * $height ) / 2 )
                ),
            ),
            $color->darken( $this->options->shadeCircularArc * ( 1 + cos ( deg2rad( $startAngle ) ) ) / 2 ),
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
    public function drawCircularArc( ezcGraphCoordinate $center, $width, $height, $size, $startAngle, $endAngle, ezcGraphColor $color, $filled = true )
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
 
        if ( $filled === true )
        {
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
        else
        {
            imagefilledarc( 
                $image, 
                $this->supersample( $center->x ), 
                $this->supersample( $center->y ), 
                $this->supersample( $width ), 
                $this->supersample( $height ), 
                $startAngle, 
                $endAngle, 
                $drawColor, 
                IMG_ARC_PIE | IMG_ARC_NOFILL
            );
        }

        // Create polygon array to return
        $polygonArray = array();
        for ( $angle = $startAngle; $angle < $endAngle; $angle += $this->options->imageMapResolution )
        {
            $polygonArray[] = new ezcGraphCoordinate(
                $center->x + 
                    ( ( cos( deg2rad( $angle ) ) * $width ) / 2 ),
                $center->y + 
                    ( ( sin( deg2rad( $angle ) ) * $height ) / 2 )
            );
        }
        $polygonArray[] = new ezcGraphCoordinate(
            $center->x + 
                ( ( cos( deg2rad( $endAngle ) ) * $width ) / 2 ),
            $center->y + 
                ( ( sin( deg2rad( $endAngle ) ) * $height ) / 2 )
        );

        for ( $angle = $endAngle; $angle > $startAngle; $angle -= $this->options->imageMapResolution )
        {
            $polygonArray[] = new ezcGraphCoordinate(
                $center->x + 
                    ( ( cos( deg2rad( $angle ) ) * $width ) / 2 ) + $size,
                $center->y + 
                    ( ( sin( deg2rad( $angle ) ) * $height ) / 2 )
            );
        }
        $polygonArray[] = new ezcGraphCoordinate(
            $center->x + 
                ( ( cos( deg2rad( $startAngle ) ) * $width ) / 2 ) + $size,
            $center->y + 
                ( ( sin( deg2rad( $startAngle ) ) * $height ) / 2 )
        );

        return $polygonArray;
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
                $this->supersample( $center->x ), 
                $this->supersample( $center->y ), 
                $this->supersample( $width ), 
                $this->supersample( $height ), 
                $drawColor 
            );
        }
        else
        {
            imageellipse( 
                $image, 
                $this->supersample( $center->x ), 
                $this->supersample( $center->y ), 
                $this->supersample( $width ), 
                $this->supersample( $height ), 
                $drawColor 
            );
        }

        $polygonArray = array();
        for ( $angle = 0; $angle < 360; $angle += $this->options->imageMapResolution )
        {
            $polygonArray[] = new ezcGraphCoordinate(
                $center->x + 
                    ( ( cos( deg2rad( $angle ) ) * $width ) / 2 ),
                $center->y + 
                    ( ( sin( deg2rad( $angle ) ) * $height ) / 2 )
            );
        }

        return $polygonArray;
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
        $this->preProcessImages[] = array(
            'file' => $file, 
            'position' => clone $position,
            'width' => $width,
            'height' => $height,
        );

        return array(
            $position,
            new ezcGraphCoordinate( $position->x + $width, $position->y ),
            new ezcGraphCoordinate( $position->x + $width, $position->y + $height ),
            new ezcGraphCoordinate( $position->x, $position->y + $height ),
        );
    }

    /**
     * Draw all images to image ressource handler
     * 
     * @param ressource $image Image to draw on
     * @return ressource Updated image ressource
     */
    protected function addImages( $image )
    {
        foreach ( $this->preProcessImages as $preImage )
        {
            $preImageData = $this->imageCreateFrom( $preImage['file'] );
            call_user_func_array(
                $this->options->resampleFunction,
                array(
                    $image,
                    $preImageData['image'],
                    $preImage['position']->x, $preImage['position']->y,
                    0, 0,
                    $preImage['width'], $preImage['height'],
                    $preImageData['width'], $preImageData['height'],
                )
            );
        }

        return $image;
    }

    /**
     * Finally save image
     * 
     * @param mixed $file 
     * @return void
     */
    public function render ( $file )
    {
        $destination = imagecreatetruecolor( $this->options->width, $this->options->height );

        // Default to a transparent white background
        $bgColor = imagecolorallocatealpha( $destination, 255, 255, 255, 127 );
        imagealphablending( $destination, true );
        imagesavealpha( $destination, true );
        imagefill( $destination, 1, 1, $bgColor );

        // Apply background if one is defined
        if ( $this->options->background !== false )
        {
            $background = $this->imageCreateFrom( $this->options->background );

            call_user_func_array(
                $this->options->resampleFunction,
                array(
                    $destination,
                    $background['image'],
                    0, 0,
                    0, 0,
                    $this->options->width, $this->options->height,
                    $background['width'], $background['height'],
                )
            );
        }

        // Draw all images to exclude them from supersampling
        $destination = $this->addImages( $destination );

        // Finally merge with graph
        $image = $this->getImage();
        call_user_func_array(
            $this->options->resampleFunction,
            array(
                $destination,
                $image,
                0, 0,
                0, 0,
                $this->options->width, $this->options->height,
                $this->supersample( $this->options->width ), $this->supersample( $this->options->height )
            )
        );

        $this->image = $destination;
        imagedestroy( $image );

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
