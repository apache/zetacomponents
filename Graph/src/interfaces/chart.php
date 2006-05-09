<?php
/**
 * File containing the abstract ezcGraphChart class
 *
 * @package Graph
 * @version $id$
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
     */
    public function __set( $propertyName, $propertyValue ) 
    {
        switch ( $propertyName ) {
            case 'title':
                $this->title = (string) $propertyValue;
                return $this;
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
                // Consider everything else as dataset
                // @TODO: Implement
            break;
        }
    }

    public function __get( $propertyName )
    {
        if ( isset( $this->$propertyName ) )
        {
            return $this->$propertyName;
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
     * @param ezcGraphRenderer $renderer Renderer fr the chart
     * @abstract
     * @return void
     */
    abstract public function render( ezcGraphRenderer $renderer );
}

?>
