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
abstract class ezcGraphChart implements ezcBaseOptions
{

    /**
     * Contains all general chart options
     * 
     * @var ezcGraphChartConfig
     * @access protected
     */
    protected $options;

    /**
     * Contains subelelemnts of the chart like legend and axes
     * 
     * @var array( ezcGraphChartElement )
     * @access protected
     */
    protected $elements;

    /**
     * Contains the data of the chart
     * 
     * @var array( ezcGraphDataset )
     * @access protected
     */
    protected $data;

    /**
     * Renderer for the chart
     * 
     * @var ezcGraphRenderer
     * @access protected
     */
    protected $renderer;

    /**
     * Driver for the chart
     * 
     * @var ezcGraphDriver
     * @access protected
     */
    protected $driver;

    /**
     * Options write access
     * 
     * @throws ezcBasePropertyNotFoundException
     *          If Option could not be found
     * @throws ezcBaseValueException
     *          If value is out of range
     * @param mixed $propertyName   Option name
     * @param mixed $propertyValue  Option value;
     * @access public
     * @return void
     */
    public function __set( $propertyName, $propertyValue ) 
    {
    }

    /**
     * Renders this chart
     * 
     * Creates basic visual chart elements from the chart to be processed by 
     * the renderer.
     * 
     * @param ezcGraphRenderer $renderer Renderer fr the chart
     * @abstract
     * @access public
     * @return void
     */
    abstract public function render( ezcGraphRenderer $renderer );
}

?>
