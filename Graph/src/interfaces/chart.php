<?php
/**
 * File containing the abstract ezcGraphChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a complete chart.
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

    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
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

    /**
     * Add element to chart
     *
     * Add a chart element to the chart and perform the required configuration
     * tasks for the chart element.
     * 
     * @param string $name Element name
     * @param ezcGraphChartElement $element Chart element
     * @return void
     */
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
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue ) 
    {
        switch ( $propertyName ) {
            case 'title':
                $this->elements['title']->title = $propertyValue;
                $this->renderElement['title'] = true;
                break;
            case 'legend':
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'boolean' );
                }

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
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphRenderer' );
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
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphDriver' );
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
        $this->options->font->name = $palette->fontName;
        $this->options->font->color = $palette->fontColor;

        foreach ( $this->elements as $element )
        {
            $element->setFromPalette( $palette );
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

    /**
     * Renders this chart to direct output
     * 
     * Does the same as ezcGraphChart::render(), but renders directly to 
     * output and not into a file.
     * 
     * @return void
     */
    abstract public function renderToOutput( $widht, $height );
}

?>
