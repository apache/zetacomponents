<?php

require 'Base/src/base.php';
function __autoload( $className )
{
        ezcBase::autoload( $className );
}

// Require custom palette
require dirname( __FILE__ ) . '/ez_green.php';

// Create the graph
$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEzGreen();
$graph->legend = false;

// Add the data and hilight norwegian data set
$graph->data['week'] = new ezcGraphArrayDataSet( array(
    'Lukasz Serwatka' => 1805,
    'Paul Forsyth' => 1491,
    'Paul Borgermans' => 1316,
    'Kristof Coomans' => 956,
    'Alex Jones' => 942 ,
    'Bard Farstad' => 941,
    'Tony Wood' => 900,
) );

// Set graph title
$graph->title = 'Alltime 10 most active users on forum';

// Use 3d renderer, and beautify it
$graph->renderer = new ezcGraphRenderer3d();
$graph->renderer->options->pieChartShadowSize = 12;
$graph->renderer->options->pieChartGleam = .5;
$graph->renderer->options->dataBorder = false;
$graph->renderer->options->pieChartHeight = 16;
$graph->renderer->options->legendSymbolGleam = .5;
$graph->renderer->options->pieChartOffset = 100;

$graph->driver = new ezcGraphSvgDriver();

// Output the graph with std SVG driver
$graph->render( 500, 200, 'forum_year.svg' );

?>
