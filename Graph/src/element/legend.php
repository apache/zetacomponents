<?php
/**
 * File containing the abstract ezcGraphChartElementLegend class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a legend as a chart element
 *
 * @property float $portraitSize
 *           Size of a portrait style legend in percent of the size of the 
 *           complete chart.
 * @property float $landscapeSize
 *           Size of a landscape style legend in percent of the size of the 
 *           complete chart.
 * @property int $symbolSize
 *           Standard size of symbols and text in legends.
 * @property float $minimumSymbolSize
 *           Scale symbol size up to to percent of complete legends size for 
 *           very big legends.
 * @property int $spacing
 *           Space between labels elements in pixel.
 *
 * @package Graph
 * @mainclass
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
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['portraitSize'] = .2;
        $this->properties['landscapeSize'] = .1;
        $this->properties['symbolSize'] = 14;
        $this->properties['padding'] = 1;
        $this->properties['minimumSymbolSize'] = .05;
        $this->properties['spacing'] = 2;

        parent::__construct( $options );
    }

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
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'padding':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 0' );
                }

                $this->properties['padding'] = (int) $propertyValue;
                break;
            case 'symbolSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 1' );
                }

                $this->properties['symbolSize'] = (int) $propertyValue;
                break;
            case 'landscapeSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) ||
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= int <= 1' );
                }

                $this->properties['landscapeSize'] = (float) $propertyValue;
                break;
            case 'portraitSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) ||
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= int <= 1' );
                }

                $this->properties['portraitSize'] = (float) $propertyValue;
                break;
            case 'minimumSymbolSize':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) ||
                     ( $propertyValue > 1 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= int <= 1' );
                }

                $this->properties['minimumSymbolSize'] = (float) $propertyValue;
                break;
            case 'spacing':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int >= 0' );
                }

                $this->properties['spacing'] = (int) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }
    
    public function __get( $propertyName )
    {
        switch ( $propertyName )
        {
            case 'labels':
                return $this->labels;
            default:
                return parent::__get( $propertyName );
        }
    }

    /**
     * Generate legend from several datasets with on entry per dataset
     * 
     * @param array $datasets 
     * @return void
     */
    public function generateFromDataSets( ezcGraphChartDataContainer $datasets )
    {
        $this->labels = array();
        foreach ( $datasets as $dataset )
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
    public function generateFromDataSet( ezcGraphDataSet $dataset )
    {
        $this->labels = array();
        foreach ( $dataset as $label => $data )
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
    
    /**
     * Calculated boundings needed for the legend.
     *
     * Uses the position and the configured horizontal or vertical size of a 
     * legend to calculate the boundings for the legend.
     * 
     * @param ezcGraphBoundings $boundings Avalable boundings
     * @return ezcGraphBoundings Remaining boundings
     */
    protected function calculateBoundings( ezcGraphBoundings $boundings )
    {
        $this->properties['boundings'] = clone $boundings;

        switch ( $this->position )
        {
            case ezcGraph::LEFT:
                $size = ( $boundings->width ) * $this->portraitSize;

                $boundings->x0 += $size;
                $this->boundings->x1 = $boundings->x0;
                break;
            case ezcGraph::RIGHT:
                $size = ( $boundings->width ) * $this->portraitSize;

                $boundings->x1 -= $size;
                $this->boundings->x0 = $boundings->x1;
                break;
            case ezcGraph::TOP:
                $size = ( $boundings->height ) * $this->landscapeSize;

                $boundings->y0 += $size;
                $this->boundings->y1 = $boundings->y0;
                break;
            case ezcGraph::BOTTOM:
                $size = ( $boundings->height ) * $this->landscapeSize;

                $boundings->y1 -= $size;
                $this->boundings->y0 = $boundings->y1;
                break;
        }

        return $boundings;
    }

    /**
     * Render a legend
     * 
     * @param ezcGraphRenderer $renderer Renderer
     * @param ezcGraphBoundings $boundings Boundings for the axis
     * @return ezcGraphBoundings Remaining boundings
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
        $this->properties['boundings'] = $renderer->drawBox(
            $this->properties['boundings'],
            $this->properties['background'],
            $this->properties['border'],
            $this->properties['borderWidth'],
            $this->properties['margin'],
            $this->properties['padding'],
            $this->properties['title'],
            $this->getTitleSize( $this->properties['boundings'], $type )
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
