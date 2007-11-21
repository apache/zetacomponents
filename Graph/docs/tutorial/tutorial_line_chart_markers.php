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

$graph->additionalAxis['border'] = $marker = new ezcGraphChartElementNumericAxis( );

$marker->position = ezcGraph::LEFT;
$marker->chartPosition = 1 / 3;
$marker->label = 'One million!';

$graph->render( 400, 150, 'tutorial_line_chart_markers.svg' );

?>
