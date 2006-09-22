<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphLineChart();
$graph->title = 'Wikipedia articles';

// Configure Graph
$graph->palette = new ezcGraphPaletteBlack();

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}

// Configure axis
$graph->yAxis->label = 'Articles in thousands';

// Render image
$graph->driver = new ezcGraphGdDriver();
$graph->options->font->path = 'tutorial_font.ttf';

$graph->render( 400, 200, 'tutorial_example_04.png' );

?>
