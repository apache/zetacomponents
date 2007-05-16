<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphLineChart();
$graph->title = 'Sinus';
$graph->legend->position = ezcGraph::BOTTOM;

$graph->xAxis = new ezcGraphChartElementNumericAxis();

$graph->data['sinus'] = new ezcGraphNumericDataSet( 
    -360, // Start value
    360,  // End value
    create_function(
        '$x',
        'return sin( deg2rad( $x ) );'
    )
);

$graph->data['sinus']->resolution = 120;

$graph->render( 400, 150, 'tutorial_dataset_numeric.svg' );

?>
