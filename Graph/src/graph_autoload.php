<?php
/**
 * Autoloader definition for the ezcGraph component.
 *
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Graph
 */

return array(
    'ezcGraph'                              => 'Graph/graph.php',
    'ezcGraphUnknownChartTypeException'     => 'Graph/exceptions/unknown_chart_type.php',
    
    'ezcGraphChart'                         => 'Graph/interfaces/chart.php',
    'ezcGraphPieChart'                      => 'Graph/charts/pie.php',
    'ezcGraphLineChart'                     => 'Graph/charts/line.php',
);

?>
