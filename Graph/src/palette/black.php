<?php
/**
 * File containing the abstract ezcGraphPaletteBlack class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Color pallet for ezcGraph based on Tango style guidelines at
 * http://tango-project.org/Generic_Icon_Theme_Guidelines
 *
 * @package Graph
 */
class ezcGraphPaletteBlack extends ezcGraphPalette
{
    /**
     * Axiscolor 
     * 
     * @var ezcGraphColor
     */
    protected $axisColor = '#EEEEEC';

    /**
     * Color of grid lines
     * 
     * @var ezcGraphColor
     */
    protected $gridColor = '#888A85';

    /**
     * Color of minor grid lines
     * 
     * @var ezcGraphColor
     */
    protected $minorGridColor = '#888A8588';

    /**
     * Array with colors for datasets
     * 
     * @var array
     */
    protected $dataSetColor = array(
        '#729FCF',
        '#EF2929',
        '#FCE94F',
        '#8AE234',
        '#F57900',
        '#AD7FA8',

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
     * Fontface
     * 
     * @var string
     */
    protected $fontFace = 'Vera.ttf';

    /**
     * Fontcolor 
     * 
     * @var ezcGraphColor
     */
    protected $fontColor = '#D3D7CF';

    /**
     * Backgroundcolor 
     * 
     * @var ezcGraphColor
     */
    protected $chartBackground = '#2E3436';

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
    protected $margin = 1;
}

?>
