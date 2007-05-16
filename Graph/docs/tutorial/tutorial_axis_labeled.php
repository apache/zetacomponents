<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphLineChart();
$graph->options->fillLines = 210;
$graph->options->font->maxFontSize = 10;
$graph->title = 'Error level colors';
$graph->legend = false;

$graph->yAxis = new ezcGraphChartElementLabeledAxis();
$graph->yAxis->axisLabelRenderer->showZeroValue = true;

$graph->yAxis->label = 'Color';
$graph->xAxis->label = 'Error level';

// Add data
$graph->data['colors'] = new ezcGraphArrayDataSet(
    array(
        'info' => 'blue',
        'notice' => 'green',
        'warning' => 'orange',
        'error' => 'red',
        'fatal' => 'red',
    )
);

$graph->render( 400, 150, 'tutorial_axis_labeled.svg' );

?>
