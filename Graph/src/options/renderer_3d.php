<?php
/**
 * File containing the ezcGraphRenderer3dOptions class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for pie charts
 *
 * @property bool $seperateLines
 *           Indicates wheather the full depth should be used for each line in
 *           the chart, or beeing seperated by the count of lines.
 * @property float $fillAxis
 *           Transparency used to fill the axis polygon.
 * @property float $fillGrid
 *           Transparency used to fill the grid lines.
 * @property float $depth
 *           Part of picture used to simulate depth of three dimensional chart.
 * @property float $pieChartHeight
 *           Height of the pie charts border.
 * @property float $pieChartRotation
 *           Rotation of pie chart. Defines the percent of width used to 
 *           calculate the height of the ellipse.
 * @property int $pieChartShadowSize
 *           Size of shadows.
 * @property float $pieChartShadowTransparency
 *           Used transparency for pie chart shadows.
 * @property float $pieChartShadowColor
 *           Color used for pie chart shadows.
 * @property float $barDarkenSide
 *           Factor to darken the color used for the bars side polygon.
 * @property float $barDarkenTop
 *           Factor to darken the color used for the bars top polygon.
 * @property float $barChartGleam
 *           Transparancy for gleam on bar charts
 * 
 * @package Graph
 */
class ezcGraphRenderer3dOptions extends ezcGraphRendererOptions
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
        $this->properties['seperateLines'] = true;
        $this->properties['fillAxis'] = .8;
        $this->properties['fillGrid'] = 0;
        $this->properties['depth'] = .1;
        $this->properties['pieChartHeight'] = 10.;
        $this->properties['pieChartRotation'] = .6;
        $this->properties['pieChartShadowSize'] = 0;
        $this->properties['pieChartShadowTransparency'] = .3;
        $this->properties['pieChartShadowColor'] = ezcGraphColor::fromHex( '#000000' );
        $this->properties['pieChartGleam'] = false;
        $this->properties['pieChartGleamColor'] = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->properties['barDarkenSide'] = .2;
        $this->properties['barDarkenTop'] = .4;
        $this->properties['barChartGleam'] = false;

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
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'fillAxis':
            case 'fillGrid':
                if ( $propertyValue !== false &&
                     !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) || 
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'false OR 0 <= float <= 1' );
                }

                $this->properties[$propertyName] = ( 
                    $propertyValue === false
                    ? false
                    : (float) $propertyValue );
                break;

            case 'depth':
            case 'pieChartRotation':
            case 'pieChartShadowTransparency':
            case 'barDarkenSide':
            case 'barDarkenTop':
            case 'barChartGleam':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) || 
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= float <= 1' );
                }

                $this->properties[$propertyName] = (float) $propertyValue;
                break;

            case 'pieChartHeight':
            case 'pieChartShadowSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 0 ) ) 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'float > 0' );
                }

                $this->properties[$propertyName] = (float) $propertyValue;
                break;

            case 'seperateLines':
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'bool' );
                }

                $this->properties['seperateLines'] = $propertyValue;
                break;
            case 'pieChartShadowColor':
                $this->properties['pieChartShadowColor'] = ezcGraphColor::create( $propertyValue );
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
