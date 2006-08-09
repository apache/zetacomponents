<?php
/**
 * File containing the abstract ezcGraphChartElementBackground class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a legend as a chart element
 *
 * @package Graph
 */
class ezcGraphChartElementBackground extends ezcGraphChartElement
{

    /**
     * Filename of the file to use for background
     * 
     * @var string
     */
    protected $image = false;

    /**
     * Defines how the background image gets repeated
     * 
     * @var int
     */
    protected $repeat = ezcGraph::NO_REPEAT;

    /**
     * __set 
     * 
     * @param mixed $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBaseValueException
     *          If a submitted parameter was out of range or type.
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'image':
                // Check for existance of file
                if ( !is_file( $propertyValue ) || !is_readable( $propertyValue ) )
                {
                    throw new ezcBaseFileNotFoundException( $propertyValue );
                }

                // Check for beeing an image file
                $data = getImageSize( $propertyValue );
                if ( $data === false )
                {
                    throw new ezcGraphInvalidImageFileException( $propertyValue );
                }

                // SWF files are useless..
                if ( $data[2] === 4 ) 
                {
                    throw new ezcGraphInvalidImageFileException( 'We cant use SWF files like <' . $propertyValue . '>.' );
                }

                $this->image = $propertyValue;
                break;
            case 'repeat':
                if ( ( $propertyValue >= 0 ) && ( $propertyValue <= 3 ) )
                {
                    $this->repeat = (int) $propertyValue;
                }
                else
                {
                    throw new ezcBaseValeException( $propertyName, $propertyValue, '0 <= int <= 3' );
                }
                break;
            case 'position':
                if ( is_int( $propertyValue ) )
                {
                    $this->position = $propertyValue;
                }
                else 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'integer' );
                }
                break;
            case 'color':
                // Use color as an alias to set background color for background
                $this->__set( 'background', $propertyValue );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Set colors and border fro this element
     * 
     * @param ezcGraphPalette $palette Palette
     * @return void
     */
    public function setFromPalette( ezcGraphPalette $palette )
    {
        $this->border = $palette->chartBorderColor;
        $this->borderWidth = $palette->chartBorderWidth;
        $this->background = $palette->chartBackground;
        $this->padding = 0;
        $this->margin = 0;
    }

    /**
     * Render a legend
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        $boundings = $renderer->drawBox(
            $boundings,
            $this->background,
            $this->border,
            $this->borderWidth,
            $this->margin,
            $this->padding
        );

        if ( $this->image === false )
        {
            return $boundings;
        }

        $renderer->drawBackgroundImage(
            $boundings,
            $this->image,
            $this->position,
            $this->repeat
        );

        return $boundings;
    }
}

?>
