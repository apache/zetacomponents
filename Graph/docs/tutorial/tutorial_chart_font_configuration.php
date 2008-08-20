<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEzBlue();
$graph->title = 'Access statistics';

// Set the maximum font size to 8 for all chart elements
$graph->options->font->maxFontSize = 8;

// Set the font size for the title independently to 14
$graph->title->font->maxFontSize = 14;

// The following only affects all elements except the // title element,
// which now has its own font configuration.
$graph->options->font->name = 'serif';

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->render( 400, 150, 'tutorial_chart_font_configuration.svg' );

?>
