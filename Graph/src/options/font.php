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
 *            - GD_FONT     Native GD bitmap fonts
 * @property float $minFontSize
 *           Minimum font size for displayed texts.
 * @property float $maxFontSize
 *           Maximum font size for displayed texts.
 * @property float $minimalUsedFont
 *           The minimal used font size for this element.
 * @property ezcGraphColor $color
 *           Font color.
 * @property float $lineSpacing
 *           Percent of font size used for line spacing
 *
 * @package Graph
 */
class ezcGraphFontOptions extends ezcBaseOptions
{
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
        $this->properties['path'] = 'Graph/tests/data/font.ttf';
        $this->properties['type'] = ezcGraph::TTF_FONT;

        $this->properties['minFontSize'] = 6;
        $this->properties['maxFontSize'] = 96;
        $this->properties['minimalUsedFont'] = 96;
        $this->properties['lineSpacing'] = .1;
        $this->properties['color'] = ezcGraphColor::fromHex( '#000000' );

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
                $this->properties['minFontSize'] = max(1, (float) $propertyValue);
                break;
            case 'maxFontSize':
                $this->properties['maxFontSize'] = max(1, (float) $propertyValue);
                break;
            case 'minimalUsedFont':
                $propertyValue = (float) $propertyValue;
                if ( $propertyValue < $this->minimalUsedFont )
                {
                    $this->properties['minimalUsedFont'] = $propertyValue;
                }
                break;
            case 'color':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->properties['color'] = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphColor' );
                }
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
                        case 'pfb':
                            $this->properties['type'] = ezcGraph::PS_FONT;
                            break;
                        case 'ttf':
                            $this->properties['type'] = ezcGraph::TTF_FONT;
                            break;
                        default:
                            throw new ezcGraphUnknownFontTypeException( $propertyValue, $parts['extension'] );
                    }
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
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
