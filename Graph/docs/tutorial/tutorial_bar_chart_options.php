<?php

require_once 'tutorial_autoload.php';
$wikidata = include 'tutorial_wikipedia_data.php';

$graph = new ezcGraphBarChart();
$graph->title = 'Wikipedia articles';

// Add data
foreach ( $wikidata as $language => $data )
{
    $graph->data[$language] = new ezcGraphArrayDataSet( $data );
}
$graph->data['German']->displayType = ezcGraph::LINE;
$graph->data['German']->highlight = true;
$graph->data['German']->highlight['Mar 2006'] = false;

$graph->options->fillLines = 210;

$graph->options->highlightSize = 12;

$graph->options->highlightFont->background = '#EEEEEC88';
$graph->options->highlightFont->border = '#000000';
$graph->options->highlightFont->borderWidth = 1;

// $graph->renderer = new ezcGraphRenderer2d();

$graph->renderer->options->barMargin = .2;
$graph->renderer->options->barPadding = .2;

$graph->renderer->options->dataBorder = 0;

$graph->render( 400, 150, 'tutorial_bar_chart_options.svg' );

?>
