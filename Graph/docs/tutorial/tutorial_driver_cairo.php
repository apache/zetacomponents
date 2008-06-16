<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEzBlue();
$graph->title = 'Access statistics';
$graph->legend = false;

// Set the cairo driver
$graph->driver = new ezcGraphCairoDriver();

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->renderer = new ezcGraphRenderer3d();

$graph->renderer->options->pieChartGleam = .3;
$graph->renderer->options->pieChartGleamColor = '#FFFFFF';
$graph->renderer->options->pieChartShadowSize = 5;
$graph->renderer->options->pieChartShadowColor = '#000000';

$graph->renderer->options->legendSymbolGleam = .5;
$graph->renderer->options->legendSymbolGleamSize = .9;
$graph->renderer->options->legendSymbolGleamColor = '#FFFFFF';

$graph->renderer->options->pieChartSymbolColor = '#55575388';

$graph->renderer->options->pieChartHeight = 5;
$graph->renderer->options->pieChartRotation = .8;

$graph->render( 400, 300, 'tutorial_driver_cairo.png' );

?>
