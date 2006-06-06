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
     * @var array( ezcGraphDataset )
     */
    protected $data = array();

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

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphChartOptions( $options );

        $this->__set( 'palette', 'Tango' );

        // Add standard elements
        $this->addElement( 'title', new ezcGraphChartElementText() );
        $this->elements['title']->position = ezcGraph::TOP;

        $this->addElement( 'legend', new ezcGraphChartElementLegend() );
        $this->elements['legend']->position = ezcGraph::LEFT;

        // Define standard renderer and driver
        $this->driver = new ezcGraphSVGDriver();
        $this->renderer = new ezcGraphRenderer2D();
        $this->renderer->setDriver( $this->driver );
    }

    protected function addElement( $name, ezcGraphChartElement $element )
    {
        $this->elements[$name] = $element;
        $this->elements[$name]->font = $this->options->font;
        $this->elements[$name]->setFromPalette( $this->palette );
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
                    $this->palette = ezcGraph::createPalette( $propertyValue );
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
                return $this->addDataSet($propertyName, $propertyValue);
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
        $this->options->background = $palette->chartBackground;
        $this->options->border = $palette->chartBorderColor;
        $this->options->borderWidth = $palette->chartBorderWidth;

        foreach ( $this->elements as $element )
        {
            $element->setFromPalette( $palette );
        }
    }

    /**
     * Adds a dataset to the charts data
     * 
     * @param string $name Name of dataset
     * @param mixed $values Values to create dataset with
     * @throws ezcGraphTooManyDatasetExceptions
     *          If too many datasets are created
     * @return ezcGraphDataset
     */
    protected function addDataSet( $name, $values )
    {
        $this->data[$name] = new ezcGraphDataset();
        
        if ( is_array($values) )
        {
            $this->data[$name]->createFromArray( $values );
            $this->data[$name]->label = $name;
            $this->data[$name]->palette = $this->palette;
        }
        elseif ( $values instanceof PDOStatement )
        {
            $this->data[$name]->createFromStatement( $values );
            $this->data[$name]->label = $name;
            $this->data[$name]->palette = $this->palette;
        }
        else
        {
            throw new ezcGraphUnknownDatasetSourceException( $values );
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

        if ( isset( $this->data[$propertyName] ) )
        {
            return $this->data[$propertyName];
        }

        if ( $propertyName === "options" )
        {
            return $this->options;
        }
        else
        {
            throw new ezcGraphNoSuchDatasetException( $propertyName );
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
