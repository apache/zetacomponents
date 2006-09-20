<?php
/**
 * File containing the abstract ezcGraphPaletteEz class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Color pallet for ezcGraph based on eZ color scheme
 *
 * @package Graph
 */
class ezcGraphPaletteEz extends ezcGraphPalette
{
    /**
     * Axiscolor 
     * 
     * @var ezcGraphColor
     */
    protected $axisColor = '#1E1E1E';

    /**
     * Array with colors for datasets
     * 
     * @var array
     */
    protected $dataSetColor = array(
        '#C60C30',
        '#C90062',
        '#E05206',
        '#F0AB00',
        '#D4BA00',
        '#9C9A00',
        '#3C8A2E',
        '#006983',
        '#0098C3',
        '#21578A',
        '#55517B',
        '#4E7D5B',
    );

    /**
     * Array with symbols for datasets 
     * 
     * @var array
     */
    protected $dataSetSymbol = array(
        ezcGraph::BULLET,
    );

    /**
     * Name of font to use
     * 
     * @var string
     */
    protected $fontName = 'sans-serif';

    /**
     * Fontcolor 
     * 
     * @var ezcGraphColor
     */
    protected $fontColor = '#1E1E1E';

    /**
     * Backgroundcolor for chart
     * 
     * @var ezcGraphColor
     */
    protected $chartBackground = '#FFFFFFFF';

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
}

?>
