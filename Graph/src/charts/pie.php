<?php
/**
 * File containing the abstract ezcGraphPieChart class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a pie chart.
 *
 * @package Graph
 */
class ezcGraphPieChart extends ezcGraphChart
{
    
    public function __construct( array $options = array() )
    {
        $this->options = new ezcGraphPieChartOptions( $options );

        parent::__construct( $options );
    }

    /**
     * Adds a dataset to the charts data
     * 
     * @param string $name Name of dataset
     * @param mixed $values Values to create dataset with
     * @throws ezcGraphTooManyDataSetExceptions
     *          If too many datasets are created
     * @return ezcGraphDataSet
     */
    protected function addDataSet( $name, $values )
    {
        if ( count( $this->data ) >= 1 &&
             !isset( $this->data[$name] ) )
        {
            throw new ezcGraphTooManyDataSetsExceptions( $name );
        }
        else
        {
            parent::addDataSet( $name, $values );

            // Colorize each data element
            foreach ( $this->data[$name] as $label => $value )
            {
                $this->data[$name]->color[$label] = $this->palette->dataSetColor;
            }
        }
    }

    protected function renderData( $renderer, $boundings )
    {
        // Only draw the first (and only) dataset
        $dataset = reset( $this->data );

        $this->driver->options->font = $this->options->font;

        // Calculate sum of all values to be able to calculate percentage
        $sum = 0;
        foreach ( $dataset as $value )
        {
            $sum += $value;
        }

        $angle = 0;
        foreach ( $dataset as $label => $value )
        {
            $renderer->drawPieSegment(
                $boundings,
                $dataset->color[$label],
                $angle,
                $angle += $value / $sum * 360,
                sprintf( $this->options->label, $label, $value, $value / $sum * 100 ),
                $dataset->highlight[$label]
            );
        }
    }

    /**
     * Render a pie chart
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( $width, $height, $file = null )
    {
        // Set image properties in driver
        $this->driver->options->width = $width;
        $this->driver->options->height = $height;

        // Generate legend
        $this->elements['legend']->generateFromDataSet( reset( $this->data ) );

        // Get boundings from parameters
        $this->options->width = $width;
        $this->options->height = $height;

        $boundings = new ezcGraphBoundings();
        $boundings->x1 = $this->options->width;
        $boundings->y1 = $this->options->height;

        // Render subelements
        foreach ( $this->elements as $name => $element )
        {
            // Skip element, if it should not get rendered
            if ( $this->renderElement[$name] === false )
            {
                continue;
            }

            $this->driver->options->font = $element->font;
            $boundings = $element->render( $this->renderer, $boundings );
        }

        // Render graph
        $this->renderData( $this->renderer, $boundings );

        if ( !empty( $file ) )
        {
            $this->renderer->render( $file );
        }
    }
}

?>
