<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->title = 'Access statistics';
$graph->options->label = '%2$d (%3$.1f%%)';

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );
$graph->data['Access statistics']->highlight['Explorer'] = true;
$graph->data['Access statistics']->symbol = ezcGraph::BULLET;

$graph->renderer = new ezcGraphRenderer3d();

$graph->renderer->options->pieChartShadowSize = 5;
$graph->renderer->options->pieChartShadowColor = ezcGraphColor::create( '#000000' );
$graph->renderer->options->pieChartGleam = .5;
$graph->renderer->options->dataBorder = false;
$graph->renderer->options->pieChartHeight = 8;
$graph->renderer->options->pieChartSymbolColor = '#888A8588';
$graph->renderer->options->pieChartRotation = .8;
$graph->renderer->options->legendSymbolGleam = .5;
$graph->renderer->options->legendSymbolGleamSize = .9;
$graph->renderer->options->legendSymbolGleamColor = '#FFFFFF';

$graph->driver = new ezcGraphCairoDriver();

$graph->render( 400, 150, 'tutorial_driver_cairo.png' );

?>
