<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();

// Configure Graph
$graph->palette = new ezcGraphPaletteEzBlue();
$graph->legend->position = ezcGraph::BOTTOM;

$graph->driver = new ezcGraphGdDriver();
$graph->options->font = 'tutorial_font.ttf';

$graph->title = 'Access statistics';
$graph->title->font = 'tutorial_font.pfb';

// Add data
$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );
$graph->data['Access statistics']->highlight['Opera'] = true;
$graph->data['Access statistics']->symbol = ezcGraph::NO_SYMBOL;

$graph->options->label = '%2$d (%3$.1f%%)';

// Configure renderer options
$graph->renderer->options->pieChartShadowSize = 5;
$graph->renderer->options->pieChartShadowColor = '#DDDDDD';

// Render image
$graph->render( 400, 200, 'tutorial_example_02.png' );

?>
