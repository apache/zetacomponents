<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphLineChart();
$graph->title = 'Wikipedia articles';

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}

$graph->yAxis->min = 0;

// Use a different axis for the norwegian dataset
$graph->additionalAxis['norwegian'] = $nAxis = new ezcGraphChartElementNumericAxis();
$nAxis->position = ezcGraph::BOTTOM;
$nAxis->chartPosition = 1;
$nAxis->min = 0;

$graph->data['Norwegian']->yAxis = $nAxis;

// Still use the marker
$graph->additionalAxis['border'] = $marker = new ezcGraphChartElementNumericAxis();

$marker->position = ezcGraph::LEFT;
$marker->chartPosition = 1 / 3;

$graph->render( 400, 150, 'tutorial_line_chart_additional_axis.svg' );

?>
