<?php
/**
 * File containing the abstract ezcGraphChartElement class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * 
 *
 * @package Graph
 */
interface ezcGraphChartElement extends ezcBaseOptions
{
    /**
     * __set 
     * 
     * @param mixed $propertyName 
     * @param mixed $propertyValue 
     * @access public
     * @return void
     */
    public function __set( $propertyName, $propertyValue );
    
    /**
     * Renders this chart element
     *
     * Creates basic visual chart elements from this chart element to be 
     * processed by the renderer.
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer );
}

?>
