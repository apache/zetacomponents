<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphRadarChart();
$graph->palette = new ezcGraphPaletteEzBlue();
$graph->options->fillLines = 220;
$graph->legend->position = ezcGraph::BOTTOM;

$graph->rotationAxis = new ezcGraphChartElementNumericAxis();
$graph->rotationAxis->majorStep = 2;
$graph->rotationAxis->minorStep = .5;

mt_srand( 5 );
$data = array();
for ( $i = 0; $i <= 10; $i++ )
{
    $data[$i] = mt_rand( -5, 5 );
}
$data[$i - 1] = reset( $data );

$graph->data['random data'] = $dataset = new ezcGraphArrayDataSet( $data );

$average = new ezcGraphDataSetAveragePolynom( $dataset, 4 );
$graph->data[(string) $average->getPolynom()] = $average;
$graph->data[(string) $average->getPolynom()]->symbol = ezcGraph::NO_SYMBOL;
$graph->data[(string) $average->getPolynom()]->color = '#9CAE86';

$graph->render( 500, 250, 'tutorial_complex_radar_chart.svg' );

?>
