<?php
/**
 * File containing the ezcGraphRenderer2dOptions class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for pie charts
 *
 * @property int $pieChartShadowSize
 *           Size of shadows.
 * @property float $pieChartShadowTransparency
 *           Used transparency for pie chart shadows.
 * @property float $pieChartShadowColor
 *           Color used for pie chart shadows.
 * 
 * @package Graph
 */
class ezcGraphRenderer2dOptions extends ezcGraphRendererOptions
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
        $this->properties['pieChartShadowSize'] = 0;
        $this->properties['pieChartShadowTransparency'] = .3;
        $this->properties['pieChartShadowColor'] = ezcGraphColor::fromHex( '#000000' );

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
            case 'pieChartShadowSize':
                $this->properties['pieChartShadowSize'] = max( 0, (int) $propertyValue );
                break;
            case 'pieChartShadowTransparency':
                $this->properties['pieChartShadowTransparency'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            case 'pieChartShadowColor':
                if ( !$propertyValue instanceof ezcGraphColor )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphColor' );
                }
                $this->properties['pieChartShadowColor'] = $propertyValue;
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
