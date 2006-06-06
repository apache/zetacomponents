<?php
/**
 * File containing the abstract ezcGraphPaletteTango class
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
class ezcGraphPaletteTango extends ezcGraphPalette
{
    /**
     * Backgroundcolor 
     * 
     * @var ezcGraphColor
     */
    protected $background = '#EEEEEC';

    /**
     * Axiscolor 
     * 
     * @var ezcGraphColor
     */
    protected $axisColor = '#2E3436';

    /**
     * Array with colors for datasets
     * 
     * @var array
     */
    protected $dataSetColor = array(
        '#3465A4',
        '#4E9A06',
        '#CC0000',
        '#EDD400',
        '#75505B',
        '#F57900',
        '#204A87',
        '#C17D11',
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
    protected $fontColor = '#888A85';

    /**
     * Bordercolor 
     * 
     * @var ezcGraphColor
     */
    protected $borderColor = '#BABDB6';

    /**
     * Borderwidth
     * 
     * @var integer
     * @access protected
     */
    protected $borderWidth = 0;

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
