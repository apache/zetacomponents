<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();

// Configure Graph
$graph->palette = new ezcGraphPaletteEzBlue();
$graph->legend->position = ezcGraph::BOTTOM;

$graph->title = 'Access statistics';

// Add data
$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );
$graph->data['Access statistics']->highlight['Opera'] = true;

$graph->options->label = '%2$d (%3$.1f%%)';

// Configure renderer options
$graph->renderer = new ezcGraphRenderer3d();
$graph->renderer->options->pieChartShadowSize = 10;
$graph->renderer->options->pieChartGleam = .5;
$graph->renderer->options->dataBorder = false;
$graph->renderer->options->pieChartHeight = 16;
$graph->renderer->options->legendSymbolGleam = .5;

// Render image
$graph->render( 400, 200, 'tutorial_example_03.svg' );

?>
