<?php
/**
 * File containing the abstract ezcGraphDriver class
 *
 * @package Graph
 * @version $id$
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base options class for all eZ components.
 *
 * @package Graph
 */
abstract class ezcGraphDriver
{
    /**
     * Draws a single polygon 
     * 
     * @param mixed $points 
     * @param ezcGraphColor $color 
     * @param mixed $filled 
     * @return void
     */
    abstract abstract public function drawPolygon( $points, ezcGraphColor $color, $filled = true );
    
    /**
     * Draws a single line
     * 
     * @param ezcGraphCoordinate $start 
     * @param ezcGraphCoordinate $end 
     * @param ezcGraphColor $color 
     * @return void
     */
    abstract abstract public function drawLine( ezcGraphCoordinate $start, ezcGraphCoordinate $end, ezcGraphColor $color );
    
    /**
     * Wrties text in a box of desired size
     * 
     * @param mixed $string 
     * @param ezcGraphCoordinate $position 
     * @param mixed $width 
     * @param mixed $height 
     * @param ezcGraphColor $color 
     * @return void
     */
    abstract abstract public function drawTextBox( $string, ezcGraphCoordinate $position, $width, $height, ezcGraphColor $color );
    
    /**
     * Draws a sector of cirlce
     * 
     * @param ezcGraphCoordinate $center 
     * @param mixed $radius 
     * @param mixed $startAngle 
     * @param mixed $endAngle 
     * @param ezcGraphColor $color 
     * @return void
     */
    abstract abstract public function drawCircleSector( ezcGraphCoordinate $center, $radius, $startAngle, $endAngle, ezcGraphColor $color );
    
    /**
     * Draws a circular arc
     * 
     * @param ezcGraphCoordinate $center 
     * @param mixed $radius 
     * @param mixed $height 
     * @param mixed $startAngle 
     * @param mixed $endAngle 
     * @param ezcGraphColor $color 
     * @return void
     */
    abstract abstract public function drawCircularArc( ezcGraphCoordinate $center, $radius, $height, $startAngle, $endAngle, ezcGraphColor $color );
    
    /**
     * Draws a imagemap of desired size
     * 
     * @param mixed $file 
     * @param ezcGraphCoordinate $position 
     * @param mixed $width 
     * @param mixed $height 
     * @return void
     */
    abstract abstract public function drawImage( $file, ezcGraphCoordinate $position, $width, $height );
}
