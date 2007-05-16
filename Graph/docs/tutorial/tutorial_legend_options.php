<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEz();
$graph->title = 'Access statistics';

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->legend->position = ezcGraph::BOTTOM;
$graph->legend->landscapeSize = .3;
$graph->legend->title = 'Legend';

$graph->render( 400, 150, 'tutorial_legend_options.svg' );

?>
