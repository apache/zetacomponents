<?php
/**
 * File containing the abstract ezcGraph class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base options class for all eZ components.
 *
 * @package Graph
 */
class ezcGraph
{

    const DIAMOND = 1;

    static protected $chartTypes = array(
        'pie'   => 'ezcGraphPieChart',
        'line'  => 'ezcGraphLineChart',
    );

    /**
     * create 
     * 
     * @param string $type Type of chart to create
     * @param array $options Options to create the chart with
     * @throws ezcGraphUnknownChartTypeException
     * @return ezcGraphChart
     */
    static public function create( $type, $options = array() ) 
    {
        $type = strtolower( $type );
        if ( isset( self::$chartTypes[$type] ) )
        {
            $className = self::$chartTypes[$type];
            return new $className( $options );
        }
        else 
        {
            throw new ezcGraphUnknownChartTypeException($type);
        }
    }
}

?>
