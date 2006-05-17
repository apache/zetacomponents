<?php
/**
 * File containing the abstract ezcGraphChartElementLegend class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a legend as a chart element
 *
 * @package Graph
 */
class ezcGraphChartElementLegend extends ezcGraphChartElement
{

    /**
     * Contains data which should be shown in the legend
     *  array(
     *      array(
     *          'label' => (string) 'Label of data element',
     *          'color' => (ezcGraphColor) $color,
     *      ),
     *      ...
     *  )
     * 
     * @var array
     */
    protected $labels;

    /**
     * Generate legend from several datasets with on entry per dataset
     * 
     * @param array $datasets 
     * @return void
     */
    public function generateFromDatasets(array $datasets)
    {
        $this->labels = array();
        foreach ($datasets as $dataset)
        {
            $this->labels[] = array(
                'label' => $dataset->label->default,
                'color' => $dataset->color->default,
            );
        }
    }

    /**
     * Generate legend from single dataset with on entry per data element 
     * 
     * @param ezcGraphDataset $dataset 
     * @return void
     */
    public function generateFromDataset(ezcGraphDataset $dataset)
    {
        $this->labels = array();
        foreach ($dataset as $label => $data)
        {
            $this->labels[] = array(
                'label' => $label,
                'color' => $dataset->color[$label],
            );
        }
    }
    
    /**
     * Render a legend
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render()
    {
        
    }
}

?>
