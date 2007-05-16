<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphBarChart();
$graph->palette = new ezcGraphPaletteBlack();
$graph->title = 'Wikipedia articles';

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}
$graph->data['German']->displayType = ezcGraph::LINE;

$graph->options->fillLines = 210;

$graph->render( 400, 150, 'tutorial_user_palette.svg' );

?>
