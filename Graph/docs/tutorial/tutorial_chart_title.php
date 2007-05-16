<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEzBlue();
$graph->title = 'Access statistics';

$graph->options->font->name = 'serif';

$graph->title->background = '#EEEEEC';
$graph->title->font->name = 'sans-serif';

$graph->options->font->maxFontSize = 8;

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->render( 400, 150, 'tutorial_chart_title.svg' );

?>
