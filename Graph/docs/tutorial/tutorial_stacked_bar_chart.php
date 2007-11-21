<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphBarChart();
$graph->title = 'Wikipedia articles';

// Stack bars
$graph->options->stackBars = true;

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}

$graph->yAxis->label = 'Thousand articles';

$graph->render( 400, 150, 'tutorial_stacked_bar_chart.svg' );

?>
