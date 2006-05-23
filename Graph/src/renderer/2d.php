<?php
/**
 * File containing the ezcGraphRenderer2D class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Implements the three dimensional renderer for the graph component
 *
 * @package Graph
 */
class ezcGraphRenderer2D extends ezcGraphRenderer
{

    /**
     * Draw a pie segment
     * 
     * @param ezcGraphCoordinate $position 
     * @param mixed $radius 
     * @param float $startAngle 
     * @param float $endAngle 
     * @param float $moveOut 
     * @return void
     */
    public function drawPieSegment( ezcGraphColor $color, ezcGraphCoordinate $position, $radius, $startAngle = .0, $endAngle = 360., $moveOut = .0 )
    {
        
    }
    
    /**
     * Draw a line
     *
     * Semantically means a line as a chart element, not a single line like
     * the ones used in axes.
     * 
     * @param ezcGraphCoordinate $position 
     * @param ezcGraphCoordinate $end 
     * @param mixed $filled 
     * @return void
     */
    public function drawLine( ezcGraphColor $color, ezcGraphCoordinate $position, ezcGraphCoordinate $end, $filled = true )
    {
        
    }
    
    /**
     * Draws a text box
     * 
     * @param ezcGraphCoordinate $position 
     * @param mixed $text 
     * @param mixed $width 
     * @param mixed $height 
     * @return void
     */
    public function drawTextBox( ezcGraphCoordinate $position, $text, $width = null, $height = null, $align = ezcGraph::LEFT )
    {
        
    }
    
    /**
     * Draws a rectangle
     *
     * @param ezcGraphColor $color 
     * @param ezcGraphCoordinate $position 
     * @param mixed $width 
     * @param mixed $height 
     * @param float $borderWidth 
     * @return void
     */
    public function drawRect( ezcGraphColor $color, ezcGraphCoordinate $position = null, $width = null, $height = null, $borderWidth = 1 )
    {
        
    }
    
    /**
     * Draw Background
     *
     * Draws a filled rectangle, used for backgrounds
     * 
     * @param ezcGraphColor $color 
     * @param ezcGraphCoordinate $position 
     * @param mixed $width 
     * @param mixed $height 
     * @return void
     */
    public function drawBackground( ezcGraphColor $color, ezcGraphCoordinate $position = null, $width = null, $height = null )
    {
        
    }
    
    /**
     * Draws BackgrouniImage
     * 
     * @param mixed $file 
     * @param ezcGraphCoordinate $position 
     * @param mixed $width 
     * @param mixed $height 
     * @return void
     */
    public function drawBackgroundImage( $file, ezcGraphCoordinate $position = null, $width = null, $height = null )
    {
        
    }
    
    /**
     * Draws a lines symbol
     * 
     * @param ezcGraphCoordinate $position 
     * @param float $width 
     * @param float $height 
     * @param int $symbol 
     * @return void
     */
    public function drawSymbol( ezcGraphColor $color, ezcGraphCoordinate $position, $width, $height, $symbol = ezcGraph::NO_SYMBOL)
    {
        
    }
}

?>
