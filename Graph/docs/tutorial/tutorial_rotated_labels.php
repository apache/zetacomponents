<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphLineChart();
$graph->title = 'Wikipedia articles';

$graph->xAxis->axisLabelRenderer = new ezcGraphAxisRotatedLabelRenderer();
$graph->xAxis->axisLabelRenderer->angle = 45;
$graph->xAxis->axisSpace = .2;

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}
$graph->data['German']->displayType = ezcGraph::LINE;

$graph->options->fillLines = 210;

$graph->render( 400, 150, 'tutorial_rotated_labels.svg' );

?>
