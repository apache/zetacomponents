<?php

require 'Base/src/base.php';
function __autoload( $className )
{
        ezcBase::autoload( $className );
}

// Require custom palette
require dirname( __FILE__ ) . '/ez_red.php';

// Create the graph
$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEzRed();
$graph->legend = false;

// Add the data and hilight norwegian data set
$graph->data['week'] = new ezcGraphArrayDataSet( array(
    'Claudia Kosny' => 128,
    'Kristof Coomans' => 70,
    'Xavier Dutoit' => 64,
    'David Jones' => 58,
    'Lukasz Serwatka' => 45,
    'Norman Leutner' => 22,
    'Marko Zmak' => 20,
    'sangib das' => 20,
    'Nabil Alimi' => 19,
) );

// Set graph title
$graph->title = '10 most active users on forum in last month';

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
$graph->render( 500, 200, 'forum_month.svg' );

?>
