<?php
/**
 * File containing the abstract ezcGraphRenderer class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005,
        2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Abstract class to transform the basic chart components. To be extended by
 * three- and twodimensional renderers.
 *
 * @package Graph
 */
abstract class ezcGraphRenderer
{

    protected $driver;

    public function setDriver( ezcGraphDriver $driver )
    {
        $this->driver = $driver;
    }

    /**
     * Draw pie segment
     *
     * Draws a single pie segment
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphColor $color Color of pie segment
     * @param float $startAngle Start angle
     * @param float $endAngle End angle
     * @param string $label Label of pie segment
     * @param float $moveOut Move out from middle for hilighting
     * @return void
     */
    abstract public function drawPieSegment(
        ezcGraphBoundings $boundings,
        ezcGraphColor $color,
        $startAngle = .0,
        $endAngle = 360.,
        $label = false,
        $moveOut = false
    );
    
    /**
     * Draw data line
     *
     * Draws a line as a data element in a line chart
     * 
     * @param ezcGraphBoundings $boundings Chart boundings
     * @param ezcGraphColor $color Color of line
     * @param ezcGraphCoordinate $start Starting point
     * @param ezcGraphCoordinate $end Ending point
     * @param int $symbol Symbol to draw for line
     * @param ezcGraphColor $symbolColor Color of the symbol, defaults to linecolor
     * @param ezcGraphColor $fillColor Color to fill line with
     * @param float $axisPosition Position of axis for drawing filled lines
     * @param float $thickness Line thickness
     * @return void
     */
    abstract public function drawDataLine(
        ezcGraphBoundings $boundings,
        ezcGraphColor $color,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        $symbol = ezcGraph::NO_SYMBOL,
        ezcGraphColor $symbolColor = null,
        ezcGraphColor $fillColor = null,
        $axisPosition = 0.,
        $thickness = 1
    );
    
    /**
     * Draw legend
     *
     * Will draw a legend in the bounding box
     * 
     * @param ezcGraphBoundings $boundings Bounding of legend
     * @param ezcGraphChartElementLegend $labels Legend to draw
     * @param int $type Type of legend: Protrait or landscape
     * @return void
     */
    abstract public function drawLegend(
        ezcGraphBoundings $boundings,
        ezcGraphChartElementLegend $legend,
        $type = ezcGraph::VERTICAL
    );
    
    /**
     * Draw box
     *
     * Box are wrapping each major chart element and draw border, background
     * and title to each chart element.
     *
     * Optionally a padding and margin for each box can be defined.
     * 
     * @param ezcGraphBoundings $boundings Boundings of the box
     * @param ezcGraphColor $background Background color
     * @param ezcGraphColor $borderColor Border color
     * @param int $borderWidth Border width
     * @param int $margin Margin
     * @param int $padding Padding
     * @param string $title Title of the box
     * @param int $titleSize Size of title in the box
     * @return ezcGraphBoundings Remaining inner boundings
     */
    abstract public function drawBox(
        ezcGraphBoundings $boundings,
        ezcGraphColor $background = null,
        ezcGraphColor $borderColor = null,
        $borderWidth = 0,
        $margin = 0,
        $padding = 0,
        $title = false,
        $titleSize = 16 
    );
    
    /**
     * Draw text
     *
     * Draws the provided text in the boundings
     * 
     * @param ezcGraphBoundings $boundings Boundings of text
     * @param string $text Text
     * @param int $align Alignement of text
     * @param int $align Alignement of text
     * @return void
     */
    abstract public function drawText(
        ezcGraphBoundings $boundings,
        $text,
        $align = ezcGraph::LEFT
    );

    /**
     * Draw axis
     *
     * Draws an axis form the provided start point to the end point. A specific 
     * angle of the axis is not required.
     *
     * For the labeleing of the axis a sorted array with major steps and an 
     * array with minor steps is expected, which are build like this:
     *  array(
     *      array(
     *          'position' => (float),
     *          'label' => (string),
     *      )
     *  )
     * where the label is optional.
     *
     * The label renderer class defines how the labels are rendered. For more
     * documentation on this topic have a look at the basic label renderer 
     * class.
     *
     * Additionally it can be specified if a major and minor grid are rendered 
     * by defining a color for them. Teh axis label is used to add a caption 
     * for the axis.
     * 
     * @param ezcGraphBoundings $boundings Boundings of axis
     * @param ezcGraphCoordinate $start Start point of axis
     * @param ezcGraphCoordinate $end Endpoint of axis
     * @param ezcGraphChartElementAxis $axis Axis to render
     * @param ezcGraphLabelRenderer $labelClass Used label renderer
     * @return void
     */
    abstract public function drawAxis(
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $start,
        ezcGraphCoordinate $end,
        ezcGraphChartElementAxis $axis,
        ezcGraphAxisLabelRenderer $labelClass = null
    );

    /**
     * Draw background image
     *
     * Draws a background image at the defined position. If repeat is set the
     * background image will be repeated like any texture.
     * 
     * @param ezcGraphBoundings $boundings Boundings for the background image
     * @param string $file Filename of background image
     * @param int $position Position of background image
     * @param int $repeat Type of repetition
     * @return void
     */
    abstract public function drawBackgroundImage(
        ezcGraphBoundings $boundings,
        $file,
        $position = 48, // ezcGraph::CENTER | ezcGraph::MIDDLE
        $repeat = ezcGraph::NO_REPEAT
    );
    
    /**
     * Draw Symbol
     *
     * Draws a single symbol defined by the symbol constants in ezcGraph. for
     * NO_SYMBOL a rect will be drawn.
     * 
     * @param ezcGraphBoundings $boundings Boundings of symbol
     * @param ezcGraphColor $color Color of symbol
     * @param int $symbol Type of symbol
     * @return void
     */
    abstract public function drawSymbol(
        ezcGraphBoundings $boundings,
        ezcGraphColor $color,
        $symbol = ezcGraph::NO_SYMBOL
    );

    /**
     * Finish rendering
     *
     * Method is called before the final image is renderer, so that finishing
     * operations can be performed here.
     * 
     * @abstract
     * @access public
     * @return void
     */
    protected function finish()
    {
        return true;
    }

    /**
     * Finally renders the image 
     * 
     * @param string $file Filename of destination file
     * @return void
     */
    public function render( $file )
    {
        $this->finish();
        $this->driver->render( $file );
    }
}
?>
