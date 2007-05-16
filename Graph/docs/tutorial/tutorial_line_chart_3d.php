<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphLineChart();
$graph->title = 'Some random data';
$graph->legend->position = ezcGraph::BOTTOM;
$graph->options->fillLines = 210;

$graph->xAxis = new ezcGraphChartElementNumericAxis();

$data = array();
for ( $i = 0; $i <= 10; $i++ )
{
    $data[$i] = mt_rand( -5, 5 );
}

// Add data
$graph->data['random data'] = $dataset = new ezcGraphArrayDataSet( $data );

$average = new ezcGraphDataSetAveragePolynom( $dataset, 3 );
$graph->data[(string) $average->getPolynom()] = $average;

$graph->renderer = new ezcGraphRenderer3d();

$graph->render( 400, 150, 'tutorial_line_chart_3d.svg' );

?>
