<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphBarChart();
$graph->options->font->path = 'tutorial_font.ttf';
$graph->options->fillLines = 220;

$graph->title = 'Wikipedia articles';
$graph->legend->position = ezcGraph::BOTTOM;

// Configure Graph
$graph->palette = new ezcGraphPaletteBlack();

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}
$graph->data['English']->highlight['Jun 2006'] = true;
$graph->options->highlightFont->maxFontSize = 8;

$graph->data['German']->displayType = ezcGraph::LINE;

// Configure axis
$graph->yAxis->label = 'Articles in thousands';

// Render image
$graph->driver = new ezcGraphGdDriver();

$graph->render( 400, 200, 'tutorial_example_05.png' );

?>
