<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphLineChart();
$graph->title = 'Some random statistical data';

// Generate and add random data
for ( $x = -5; $x <= 10; ++$x )
{
    $data[$x] = mt_rand( -10, 10 );
}
$graph->data['Random data'] = new ezcGraphArrayDataSet( $data );
$graph->data['Random data']->symbol = ezcGraph::DIAMOND;

$graph->data['Average'] = new ezcGraphDataSetAveragePolynom( $graph->data['Random data'], 3 );

// Configure axis
$graph->xAxis = new ezcGraphChartElementNumericAxis();

// Render image
$graph->render( 500, 200, 'tutorial_example_06.svg' );

?>
