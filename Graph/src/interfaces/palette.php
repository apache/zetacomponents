<?php
/**
 * File containing the abstract ezcGraphPalette class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Abstract class to contain pallet definitions
 *
 * @package Graph
 */
abstract class ezcGraphPalette
{
    /**
     * Indicates which color should be used for the next dataset
     * 
     * @var integer
     */
    protected $colorIndex = -1;

    /**
     * Indicates which symbol should be used for the nect dataset
     * 
     * @var integer
     */
    protected $symbolIndex = -1;

    /**
     * Backgroundcolor 
     * 
     * @var ezcGraphColor
     */
    protected $background;

    /**
     * Axiscolor 
     * 
     * @var ezcGraphColor
     */
    protected $axisColor;

    /**
     * Array with colors for datasets
     * 
     * @var array
     */
    protected $dataSetColor;

    /**
     * Array with symbols for datasets 
     * 
     * @var array
     */
    protected $dataSetSymbol;

    /**
     * Fontface
     * 
     * @var string
     */
    protected $fontFace;

    /**
     * Fontcolor 
     * 
     * @var ezcGraphColor
     */
    protected $fontColor;

    /**
     * Bordercolor the chart
     * 
     * @var ezcGraphColor
     */
    protected $chartBorderColor;

    /**
     * Borderwidth for the chart
     * 
     * @var integer
     * @access protected
     */
    protected $chartBorderWidth = 1;

    /**
     * Bordercolor for elements
     * 
     * @var ezcGraphColor
     */
    protected $elementBorderColor;

    /**
     * Borderwidth for elements
     * 
     * @var integer
     * @access protected
     */
    protected $elementBorderWidth = 0;

    /**
     * Padding in elements
     * 
     * @var integer
     */
    protected $padding = 1;

    /**
     * Margin of elements
     * 
     * @var integer
     */
    protected $margin = 0;

    /**
     * Ensure value to be a color
     * 
     * @param mixed $color Color to transform into a ezcGraphColor object
     * @return ezcGraphColor
     */
    protected function checkColor( &$color )
    {
        if ( !( $color instanceof ezcGraphColor ) )
        {
            $color = ezcGraphColor::create( $color );
        }

        return $color;
    }

    /**
     * Returns the requested property
     * 
     * @param string $propertyName Name of property
     * @return mixed
     */
    public function __get( $propertyName )
    {
        switch ( $propertyName )
        {
            case 'background':
                return $this->checkColor( $this->background );

            case 'axisColor':
                return $this->checkColor( $this->axisColor );

            case 'dataSetColor':
                $this->colorIndex = ( ( $this->colorIndex + 1 ) % count( $this->dataSetColor ) );
                return $this->checkColor( $this->dataSetColor[ $this->colorIndex ] );
            case 'dataSetSymbol':
                $this->symbolIndex = ( ( $this->symbolIndex + 1 ) % count( $this->dataSetSymbol ) );
                return $this->dataSetSymbol[ $this->symbolIndex ];

            case 'fontColor':
                return $this->checkColor( $this->fontColor );
            case 'fontFace':
                return $this->fontFace;

            case 'chartBorderColor':
                return $this->checkColor( $this->chartBorderColor );
            case 'chartBorderWidth':
                return $this->chartBorderWidth;

            case 'elementBorderColor':
                return $this->checkColor( $this->elementBorderColor );
            case 'elementBorderWidth':
                return $this->elementBorderWidth;

            case 'padding':
                return $this->padding;
            case 'margin':
                return $this->margin;
        }
    }
}

?>
