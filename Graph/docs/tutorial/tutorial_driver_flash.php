<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->title = 'Access statistics';
$graph->legend = false;

$graph->driver = new ezcGraphFlashDriver();
$graph->options->font = 'tutorial_font.fdb';

$graph->driver->options->compression = 7;

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->renderer = new ezcGraphRenderer3d();
$graph->renderer->options->pieChartShadowSize = 10;
$graph->renderer->options->pieChartGleam = .5;
$graph->renderer->options->dataBorder = false;
$graph->renderer->options->pieChartHeight = 16;
$graph->renderer->options->legendSymbolGleam = .5;

$graph->render( 400, 200, 'tutorial_driver_flash.swf' );

?>
