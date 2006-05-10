<?php
/**
 * File containing the abstract ezcGraphPieChart class
 *
 * @package Graph
 * @version $id$
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
    /**
     * Render a line chart
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render(ezcGraphRenderer $renderer)
    {
        
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
        if ( count( $this->data ) >= 1 &&
             !isset( $this->data[$name] ) )
        {
            throw new ezcGraphTooManyDatasetsExceptions( $name );
        }
        else
        {
            parent::addDataSet( $name, $values );
        }
    }

}
?>
