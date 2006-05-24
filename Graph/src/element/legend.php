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
    public function generateFromDatasets(array $datasets)
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
                'symbol' => ( $dataset->symbol[$label] === null ?
                              ezcGraph::NO_SYMBOL :
                              $dataset->symbol[$label] ),
            );
        }
    }
    
    protected function calculateBoundings( ezcGraphBoundings $boundings )
    {
        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $this->boundings = clone $boundings;

                $this->boundings->y1 = $boundings->y0 + ($boundings->y1 - $boundings->y0) * $this->landscapeSize;
                $boundings->y0 = $boundings->y0 + ($boundings->y1 - $boundings->y0) * $this->landscapeSize;
                break;
            case ezcGraph::LEFT:
                $this->boundings = clone $boundings;

                $this->boundings->x1 = $boundings->x0 + ($boundings->x1 - $boundings->x0) * $this->portraitSize;
                $boundings->x0 = $boundings->x0 + ($boundings->x1 - $boundings->x0) * $this->portraitSize;
                break;
            case ezcGraph::RIGHT:
                $this->boundings = clone $boundings;

                $this->boundings->x0 = $boundings->x1 - ($boundings->x1 - $boundings->x0) * $this->portraitSize;
                $boundings->x1 = $boundings->x1 - ($boundings->x1 - $boundings->x0) * $this->portraitSize;
                break;
            case ezcGraph::BOTTOM:
                $this->boundings = clone $boundings;

                $this->boundings->y0 = $boundings->y1 - ($boundings->y1 - $boundings->y0) * $this->landscapeSize;
                $boundings->y1 = $boundings->y1 - ($boundings->y1 - $boundings->y0) * $this->landscapeSize;
                break;
        }

        return $boundings;
    }

    protected function renderLegend( ezcGraphRenderer $renderer )
    {
        switch ( $this->position )
        {
            case ezcGraph::LEFT:
            case ezcGraph::RIGHT:
                $symbolSize = min(
                    max(
                        $this->symbolSize,
                        ( $this->boundings->y1 - $this->boundings->y0 ) * $this->minimumSymbolSize
                    ),
                    ( $this->boundings->y1 - $this->boundings->y0 ) / count( $this->labels )
                );

                foreach ( $this->labels as $labelNr => $label )
                {
                    $renderer->drawSymbol(
                        $label['color'],
                        new ezcGraphCoordinate( 
                            $this->boundings->x0 + $this->padding,
                            $this->boundings->y0 + $labelNr * $symbolSize + $this->padding
                        ),
                        $symbolSize - 2 * $this->padding,
                        $symbolSize - 2 * $this->padding,
                        $label['symbol']
                    );
                    $renderer->drawTextBox(
                        new ezcGraphCoordinate(
                            $this->boundings->x0 + $symbolSize,
                            $this->boundings->y0 + $labelNr * $symbolSize + $this->padding
                        ),
                        $label['label'],
                        $this->boundings->x1 - $this->boundings->x0 - $symbolSize - $this->padding,
                        $symbolSize - 2 * $this->padding
                    );
                }
                break;
            case ezcGraph::TOP:
            case ezcGraph::BOTTOM:
                $symbolSize = min(
                    $this->symbolSize,
                    ( $this->boundings->y1 - $this->boundings->y0 )
                );
                $width = ( $this->boundings->x1 - $this->boundings->x0 ) / count( $this->labels );

                foreach ( $this->labels as $labelNr => $label )
                {
                    $renderer->drawSymbol(
                        $label['color'],
                        new ezcGraphCoordinate( 
                            $this->boundings->x0 + $labelNr * $width + $this->padding,
                            $this->boundings->y0 + $this->padding
                        ),
                        $symbolSize - 2 * $this->padding,
                        $symbolSize - 2 * $this->padding,
                        $label['symbol']
                    );
                    $renderer->drawTextBox(
                        new ezcGraphCoordinate(
                            $this->boundings->x0 + $labelNr * $width + $this->padding + $symbolSize,
                            $this->boundings->y0 + $this->padding
                        ),
                        $label['label'],
                        $width - $this->padding - $symbolSize,
                        $symbolSize - 2 * $this->padding
                    );
                }
                break;
        }
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
        
        // Render standard elements
        $this->renderBorder( $renderer );
        $this->renderBackground( $renderer );
        $this->renderTitle( $renderer );

        // Render legend
        $this->renderLegend( $renderer );

        return $boundings;  
    }
}

?>
