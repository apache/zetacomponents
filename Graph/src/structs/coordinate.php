<?php
/**
 * File containing the ezcGraphCoordinate struct
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents coordinates in two dimensional catesian coordinate system.
 *
 * @package Graph
 */
class ezcGraphCoordinate extends ezcBaseStruct
{
    /**
     * x coordinate
     * 
     * @var float
     */
    public $x = 0;

    /**
     * y coordinate
     * 
     * @var float
     */
    public $y = 0;
    
    /**
     * Simple constructor
     *
     * @param float $x x coordinate
     * @param float $y y coordinate
     * @ignore
     */
    public function __construct( $x, $y )
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * __set_state 
     * 
     * @param array $properties Struct properties
     * @return void
     * @ignore
     */
    public function __set_state( array $properties )
    {
        $this->x = $properties['x'];
        $this->y = $properties['y'];
    }
}

?>
