<?php
/**
 * File containing the abstract ezcGraphChartElement class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * 
 *
 * @package Graph
 */
abstract class ezcGraphChartElement extends ezcBaseOptions
{

    /**
     * Title of chart element
     * 
     * @var string
     */
    protected $title = 'Legend';

    /**
     * Background color of chart element 
     * 
     * @var ezcGraphColor
     */
    protected $background;

    /**
     * Border color of chart element 
     * 
     * @var ezcGraphColor
     */
    protected $border;

    /**
     * Border width 
     * 
     * @var integer
     */
    protected $borderWidth;

    /**
     * Integer defining the elements position in the chart 
     * 
     * @var integer
     */
    protected $position;

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
            case 'title':
                $this->title = (string) $propertyValue;
                break;
            case 'background':
                $this->background = ezcGraphColor::create( $propertyValue );
                break;
            case 'border':
                $this->border = ezcGraphColor::create( $propertyValue );
                break;
            case 'borderWidth':
                $this->borderWidth = max( 0, (int) $propertyValue);
                break;
            case 'position':
                $positions = array(
                    ezcGraph::TOP,
                    ezcGraph::BOTTOM,
                    ezcGraph::LEFT,
                    ezcGraph::RIGHT,
                );

                if ( in_array( $propertyValue, $positions, true ) )
                {
                    $this->position = $propertyValue;
                }
                else 
                {
                    throw new ezcBaseValueException( 'position', $propertyValue, 'integer' );
                }
                break;
            default:
                throw new ezcGraphNoSuchDatasetException( $propertyName );
                break;
        }
    }
    
    /**
     * Renders this chart element
     *
     * Creates basic visual chart elements from this chart element to be 
     * processed by the renderer.
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    abstract public function render();
}

?>
