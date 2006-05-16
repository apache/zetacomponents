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
    protected $elements;

    /**
     * Contains the data of the chart
     * 
     * @var array( ezcGraphDataset )
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
     * Title of the chart
     * 
     * @var string
     */
    protected $title;

    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphChartOption();

        // Add standard element legend
        $this->elements['legend'] = new ezcGraphChartElementLegend();
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
                return $this->title = (string) $propertyValue;
                break;
            case 'renderer':
                if ( $propertyValue instanceof ezcGraphRenderer )
                {
                    return $this->renderer = $propertyValue;
                }
                else 
                {
                    throw new ezcGraphInvalidRendererException( $propertyValue );
                }
                break;
            case 'driver':
                if ( $propertyValue instanceof ezcGraphDriver )
                {
                    return $this->driver = $propertyValue;
                }
                else 
               {
                    throw new ezcGraphInvalidDriverException( $propertyValue );
               }
                break;
            default:
                return $this->addDataSet($propertyName, $propertyValue);
                break;
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
        }
        elseif ( $values instanceof PDOStatement )
        {
            $this->data[$name]->createFromStatement( $values );
            $this->data[$name]->label = $name;
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
        else
        {
            throw new ezcGraphNoSuchDatasetException( $propertyName );
        }
    }

    /**
     * Renders this chart
     * 
     * Creates basic visual chart elements from the chart to be processed by 
     * the renderer.
     * 
     * @abstract
     * @return void
     */
    abstract public function render();
}

?>
