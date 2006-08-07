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
     *          'symbol' => (integer) ezcGraph::DIAMOND,
     *      ),
     *      ...
     *  )
     * 
     * @var array
     */
    protected $labels;

    /**
     * Size of a portrait style legend in percent of the size of the complete 
     * chart
     * 
     * @var float
     */
    protected $portraitSize = .2;

    /**
     * Size of a landscape style legend in percent of the size of the complete 
     * chart
     * 
     * @var float
     */
    protected $landscapeSize = .1;

    /**
     * Standard size of symbols and text in legends 
     * 
     * @var integer
     */
    protected $symbolSize = 14;

    /**
     * Padding for label elements 
     * 
     * @var integer
     */
    protected $padding = 1;

    /**
     * Scale symbol size up to to percent of complete legends size for very
     * big legends
     * 
     * @var float
     */
    protected $minimumSymbolSize = .05;

    /**
     * Space between lael elements in pixel 
     * 
     * @var integer
     */
    protected $spacing = 2;

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
            case 'padding':
                $this->padding = max( 0, (int) $propertyValue );
                break;
            case 'symbolSize':
                $this->symbolSize = max( 1, (int) $propertyValue );
                break;
            case 'landscapeSize':
                $this->landscapeSize = max( 0, min( 1, (float) $propertyValue ) );
                break;
            case 'portraitSize':
                $this->portraitSize = max( 0, min( 1, (float) $propertyValue ) );
                break;
            case 'spacing':
                $this->portraitSize = max( 0, (int) $propertyValue );
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Generate legend from several datasets with on entry per dataset
     * 
     * @param array $datasets 
     * @return void
     */
    public function generateFromDataSets(array $datasets)
    {
        $this->labels = array();
        foreach ($datasets as $dataset)
        {
            $this->labels[] = array(
                'label' => $dataset->label->default,
                'color' => $dataset->color->default,
                'symbol' => ( $dataset->symbol->default === null ?
                              ezcGraph::NO_SYMBOL :
                              $dataset->symbol->default ),
            );
        }
    }

    /**
     * Generate legend from single dataset with on entry per data element 
     * 
     * @param ezcGraphDataSet $dataset 
     * @return void
     */
    public function generateFromDataSet(ezcGraphDataSet $dataset)
    {
        $this->labels = array();
        foreach ($dataset as $label => $data)
        {
            $this->labels[] = array(
                'label' => $label,
                'color' => $dataset->color[$label],
                'symbol' => ( $dataset->symbol[$label] === null ?
                              ezcGraph::NO_SYMBOL :
                              $dataset->symbol[$label] ),
            );
        }
    }
    
    protected function calculateBoundings( ezcGraphBoundings $boundings )
    {
        $this->boundings = clone $boundings;

        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $size = (int) round( $boundings->y0 + ( $boundings->y1 - $boundings->y0) * $this->landscapeSize );

                $boundings->y0 += $size;
                $this->boundings->y1 = $boundings->y0;
                break;
            case ezcGraph::LEFT:
                $size = (int) round( $boundings->x0 + ( $boundings->x1 - $boundings->x0) * $this->portraitSize );

                $boundings->x0 += $size;
                $this->boundings->x1 = $boundings->x0;
                break;
            case ezcGraph::RIGHT:
                $size = (int) round( $boundings->x1 - ( $boundings->x1 - $boundings->x0) * $this->portraitSize );

                $boundings->x1 -= $size;
                $this->boundings->x0 = $boundings->x1;
                break;
            case ezcGraph::BOTTOM:
                $size = (int) round( $boundings->y1 - ( $boundings->y1 - $boundings->y0) * $this->landscapeSize );

                $boundings->y1 -= $size;
                $this->boundings->y0 = $boundings->y1;
                break;
        }

        return $boundings;
    }

    /**
     * Render a legend
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        $boundings = $this->calculateBoundings( $boundings );
        
        if ( $this->position === ezcGraph::LEFT || $this->position === ezcGraph::RIGHT )
        {
            $type = ezcGraph::VERTICAL;
        }
        else
        {
            $type = ezcGraph::HORIZONTAL;
        }

        // Render standard elements
        $this->boundings = $renderer->drawBox(
            $this->boundings,
            $this->background,
            $this->border,
            $this->borderWidth,
            $this->margin,
            $this->padding,
            $this->title,
            $this->getTitleSize( $this->boundings, $type )
        );

        // Render legend
        $renderer->drawLegend(
            $this->boundings,
            $this,
            $type
        );

        return $boundings;  
    }
}

?>
