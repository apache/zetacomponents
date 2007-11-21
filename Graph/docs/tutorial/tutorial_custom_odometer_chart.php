<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphOdometerChart();
$graph->title = 'Custom odometer';

$graph->data['data'] = new ezcGraphArrayDataSet(
    array( 87 )
);

// Set the marker color
$graph->data['data']->color[0]  = '#A0000055';

// Set colors for the background gradient
$graph->options->startColor     = '#2E3436';
$graph->options->endColor       = '#EEEEEC';

// Define a border for the odometer
$graph->options->borderWidth    = 2;
$graph->options->borderColor    = '#BABDB6';

// Set marker width
$graph->options->markerWidth    = 5;

// Set space, which the odometer may consume
$graph->options->odometerHeight = .7;

// Set axis span and label
$graph->axis->min               = 0;
$graph->axis->max               = 100;
$graph->axis->label             = 'Coverage  ';

$graph->render( 400, 150, 'tutorial_custom_odometer_chart.svg' );

?>
