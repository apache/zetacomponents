<?php
/**
 * File containing the ezcGraphRenderer2dOptions class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for pie charts
 *
 * @package Graph
 */
class ezcGraphRenderer2dOptions extends ezcGraphRendererOptions
{

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
