<?php
/**
 * File containing the ezcGraphFontOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for charts
 *
 * @property string $name
 *           Name of font.
 * @property string $path
 *           Path to font file.
 * @property string $type
 *           Type of used font. May be one of the following:
 *            - TTF_FONT    Native TTF fonts
 *            - PS_FONT     PostScript Type1 fonts
 *            - FT2_FONT    FreeType 2 fonts
 * @property float $minFontSize
 *           Minimum font size for displayed texts.
 * @property float $maxFontSize
 *           Maximum font size for displayed texts.
 * @property float $minimalUsedFont
 *           The minimal used font size for this element.
 * @property ezcGraphColor $color
 *           Font color.
 * @property ezcGraphColor $background
 *           Background color
 * @property ezcGraphColor $border
 *           Border color
 * @property int $borderWidth
 *           Border width
 * @property int $padding
 *           Padding between text and border
 * @property bool $minimizeBorder
 *           Fit the border exactly around the text, or use the complete 
 *           possible space.
 * @property bool $textShadow
 *           Draw shadow for texts
 * @property int $textShadowOffset
 *           Offset for text shadow
 * @property ezcGraphColor $textShadowColor
 *           Color of text shadow. If false the inverse color of the text 
 *           color will be used.
 *
 * @package Graph
 */
class ezcGraphFontOptions extends ezcBaseOptions
{
    protected $pathChecked = false;

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['name'] = 'sans-serif';
//        $this->properties['path'] = 'Graph/tests/data/font.ttf';
        $this->properties['path'] = '';
        $this->properties['type'] = ezcGraph::TTF_FONT;

        $this->properties['minFontSize'] = 6;
        $this->properties['maxFontSize'] = 96;
        $this->properties['minimalUsedFont'] = 96;
        $this->properties['color'] = ezcGraphColor::fromHex( '#000000' );

        $this->properties['background'] = false;
        $this->properties['border'] = false;
        $this->properties['borderWidth'] = 1;
        $this->properties['padding'] = 0;
        $this->properties['minimizeBorder'] = true;
        
        $this->properties['textShadow'] = false;
        $this->properties['textShadowOffset'] = 1;
        $this->properties['textShadowColor'] = false;

        parent::__construct( $options );
    }

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'minFontSize':
            case 'maxFontSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'float > 1' );
                }

                $this->properties[$propertyName] = (float) $propertyValue;
                break;

            case 'minimalUsedFont':
                $propertyValue = (float) $propertyValue;
                if ( $propertyValue < $this->minimalUsedFont )
                {
                    $this->properties['minimalUsedFont'] = $propertyValue;
                }
                break;

            case 'color':
            case 'background':
            case 'border':
            case 'textShadowColor':
                $this->properties[$propertyName] = ezcGraphColor::create( $propertyValue );
                break;

            case 'borderWidth':
            case 'padding':
            case 'textShadowOffset':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 0' );
                }

                $this->properties[$propertyName] = (int) $propertyValue;
                break;

            case 'minimizeBorder':
            case 'textShadow':
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'bool' );
                }
                $this->properties[$propertyName] = (bool) $propertyValue;
                break;

            case 'name':
                if ( is_string( $propertyValue ) )
                {
                    $this->properties['name'] = $propertyValue;
                }
                else 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string' );
                }
                break;
            case 'path':
                if ( is_file( $propertyValue ) && is_readable( $propertyValue ) )
                {
                    $this->properties['path'] = realpath( $propertyValue );
                    $parts = pathinfo( $this->properties['path'] );
                    switch ( strtolower( $parts['extension'] ) )
                    {
                        case 'fdb':
                            $this->properties['type'] = ezcGraph::PALM_FONT;
                            break;
                        case 'pfb':
                            $this->properties['type'] = ezcGraph::PS_FONT;
                            break;
                        case 'ttf':
                            $this->properties['type'] = ezcGraph::TTF_FONT;
                            break;
                        default:
                            throw new ezcGraphUnknownFontTypeException( $propertyValue, $parts['extension'] );
                    }
                    $this->pathChecked = true;
                }
                else 
                {
                    throw new ezcBaseFileNotFoundException( $propertyValue, 'font' );
                }
                break;
            case 'type':
                if ( is_int( $propertyValue ) )
                {
                    $this->properties['type'] = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int' );
                }
                break;
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
            case 'textShadowColor':
                // Use inverted font color if false
                if ( $this->properties['textShadowColor'] === false )
                {
                    $this->properties['textShadowColor'] = $this->properties['color']->invert();
                }

                return $this->properties['textShadowColor'];
            case 'path':
                if ( $this->pathChecked === false )
                {
                    // Enforce call of path check
                    $this->__set( 'path', $this->properties['path'] );
                }
                // No break to use parent return
            default:
                return parent::__get( $propertyName );
        }
    }
}

?>
