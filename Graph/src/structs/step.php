<?php
/**
 * File containing the ezcGraphAxisStep struct
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a single step on the axis
 *
 * @version //autogentag//
 * @package Graph
 */
class ezcGraphAxisStep
{
    /**
     * Position of step on one axis.
     * 
     * @var float
     */
    public $position = 0;

    /**
     * Size of step
     * 
     * @var float
     */
    public $width = 0;

    /**
     * Steps label 
     * 
     * @var string
     */
    public $label = false;

    /**
     * Childrens of step 
     * 
     * @var array(ezcGraphAxisStep)
     */
    public $childs = array();

    /**
     * True if the step is at the same position as the other axis
     * 
     * @var bool
     */
    public $isZero = false;

    /**
     * True if this step is the last one
     * 
     * @var bool
     */
    public $isLast = false;

    /**
     * Simple constructor
     *
     * @param float $position 
     * @param float $width 
     * @param string $label 
     * @param array $childs 
     * @param bool $isZero 
     * @param bool $isLast 
     * @ignore
     */
    public function __construct( $position = .0, $width = .0, $label = false, array $childs = array(), $isZero = false, $isLast = false )
    {
        $this->position = (float) $position;
        $this->width = (float) $width;
        $this->label = $label;
        $this->childs = $childs;
        $this->isZero = (bool) $isZero;
        $this->isLast = (bool) $isLast;
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
        $this->position = $properties['position'];
        $this->width = $properties['width'];
        $this->label = $properties['label'];
        $this->childs = $properties['childs'];
        $this->isZero = $properties['isZero'];
        $this->isLast = $properties['isLast'];
    }
}

?>
