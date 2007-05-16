<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEzRed();
$graph->title = 'Access statistics';
$graph->legend = false;

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );
$graph->data['Access statistics']->highlight['Explorer'] = true;

// $graph->renderer = new ezcGraphRenderer2d();

$graph->renderer->options->moveOut = .2;

$graph->renderer->options->pieChartOffset = 63;

$graph->renderer->options->pieChartGleam = .3;
$graph->renderer->options->pieChartGleamColor = '#FFFFFF';
$graph->renderer->options->pieChartGleamBorder = 2;

$graph->renderer->options->pieChartShadowSize = 5;
$graph->renderer->options->pieChartShadowColor = '#BABDB6';

$graph->render( 400, 150, 'tutorial_pie_chart_options.svg' );

?>
