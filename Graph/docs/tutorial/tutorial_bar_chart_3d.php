<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphBarChart();
$graph->palette = new ezcGraphPaletteEz();
$graph->title = 'Wikipedia articles';

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}
$graph->data['English']->symbol = ezcGraph::NO_SYMBOL;
$graph->data['German']->symbol = ezcGraph::BULLET;
$graph->data['Norwegian']->symbol = ezcGraph::DIAMOND;

$graph->renderer = new ezcGraphRenderer3d();

$graph->renderer->options->legendSymbolGleam = .5;
$graph->renderer->options->barChartGleam = .5;

$graph->render( 400, 150, 'tutorial_bar_chart_3d.svg' );

?>
