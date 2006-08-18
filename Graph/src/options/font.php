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
 * @property string $font
 *           Font face.
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
            case 'font':
                if ( is_string( $propertyValue ) )
                {
                    $this->properties['font'] = $propertyValue;
                }
                else 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
