<?php
/**
 * File containing the abstract ezcGraphChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a complete charts.
 *
 * @package Graph
 */
abstract class ezcGraphChart
{

    /**
     * Contains all general chart options
     * 
     * @var ezcGraphChartConfig
     */
    protected $options;

    /**
     * Contains subelelemnts of the chart like legend and axes
     * 
     * @var array( ezcGraphChartElement )
     */
    protected $elements = array();

    /**
     * Contains the data of the chart
     * 
     * @var ezcGraphChartDataContainer
     */
    protected $data;

    /**
     * Renderer for the chart
     * 
     * @var ezcGraphRenderer
     */
    protected $renderer;

    /**
     * Driver for the chart
     * 
     * @var ezcGraphDriver
     */
    protected $driver;

    /**
     * Palette for default colorization
     * 
     * @var ezcGraphPalette
     */
    protected $palette;

    /**
     * Contains the status wheather an element should be rendered
     * 
     * @var array
     */
    protected $renderElement;

    public function __construct( array $options = array() )
    {
        $this->__set( 'palette', new ezcGraphPaletteTango() );

        $this->data = new ezcGraphChartDataContainer( $this );

        // Add standard elements
        $this->addElement( 'background', new ezcGraphChartElementBackground() );
        $this->elements['background']->position = ezcGraph::CENTER | ezcGraph::MIDDLE;

        $this->addElement( 'title', new ezcGraphChartElementText() );
        $this->elements['title']->position = ezcGraph::TOP;
        $this->renderElement['title'] = false;

        $this->addElement( 'legend', new ezcGraphChartElementLegend() );
        $this->elements['legend']->position = ezcGraph::LEFT;

        // Define standard renderer and driver
        $this->driver = new ezcGraphSvgDriver();
        $this->renderer = new ezcGraphRenderer2d();
        $this->renderer->setDriver( $this->driver );
    }

    protected function addElement( $name, ezcGraphChartElement $element )
    {
        $this->elements[$name] = $element;
        $this->elements[$name]->font = $this->options->font;
        $this->elements[$name]->setFromPalette( $this->palette );

        // Render element by default
        $this->renderElement[$name] = true;
    }

    /**
     * Options write access
     * 
     * @throws ezcBasePropertyNotFoundException
     *          If Option could not be found
     * @throws ezcBaseValueException
     *          If value is out of range
     * @param mixed $propertyName   Option name
     * @param mixed $propertyValue  Option value;
     * @return mixed
     */
    public function __set( $propertyName, $propertyValue ) 
    {
        switch ( $propertyName ) {
            case 'title':
                $this->elements['title']->title = $propertyValue;
                $this->renderElement['title'] = true;
                break;
            case 'legend':
                $this->renderElement['legend'] = (bool) $propertyValue;
                break;
            case 'renderer':
                if ( $propertyValue instanceof ezcGraphRenderer )
                {
                    $this->renderer = $propertyValue;
                    $this->renderer->setDriver( $this->driver );
                    return $this->renderer;
                }
                else 
                {
                    throw new ezcGraphInvalidRendererException( $propertyValue );
                }
                break;
            case 'driver':
                if ( $propertyValue instanceof ezcGraphDriver )
                {
                    $this->driver = $propertyValue;
                    $this->renderer->setDriver( $this->driver );
                    return $this->driver;
                }
                else 
                {
                    throw new ezcGraphInvalidDriverException( $propertyValue );
                }
                break;
            case 'palette':
                if ( $propertyValue instanceof ezcGraphPalette )
                {
                    $this->palette = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( "palette", $propertyValue, "instanceof ezcGraphPalette" );
                }

                $this->setFromPalette( $this->palette );

                break;
            case 'options':
                if ( $propertyValue instanceof ezcGraphChartOptions )
                {
                    $this->options = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( "options", $propertyValue, "instanceof ezcGraphOptions" );
                }
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
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
        $this->options->font->font = $palette->fontFace;
        $this->options->font->color = $palette->fontColor;

        foreach ( $this->elements as $element )
        {
            $element->setFromPalette( $palette );
        }
    }

    /**
     * Returns the requested property 
     * 
     * @param mixed $propertyName 
     * @return mixed
     */
    public function __get( $propertyName )
    {
        if ( isset( $this->$propertyName ) )
        {
            return $this->$propertyName;
        }

        if ( isset( $this->elements[$propertyName] ) )
        {
            return $this->elements[$propertyName];
        }

        if ( $propertyName === 'options' )
        {
            return $this->options;
        }
        else
        {
            throw new ezcGraphNoSuchElementException( $propertyName );
        }
    }

    public function setOptions( $options )
    {
        if ( is_array( $options ) )
        {
            $this->options->merge( $options );
        } 
        else if ( $options instanceof ezcGraphOptions )
        {
            $this->options = $options;
        }
        else
        {
            throw new ezcBaseValueException( "options", $options, "instance of ezcGraphOptions" );
        }
    }

    /**
     * Returns the default display type of the current chart type.
     * 
     * @return int Display type
     */
    abstract public function getDefaultDisplayType();

    /**
     * Renders this chart
     * 
     * Creates basic visual chart elements from the chart to be processed by 
     * the renderer.
     * 
     * @return void
     */
    abstract public function render( $widht, $height, $file = null );
}

?>
