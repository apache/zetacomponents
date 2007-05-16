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

$graph->data['Access statistics']->url = 'http://example.org/';
$graph->data['Access statistics']->url['Mozilla'] = 'http://example.org/mozilla';

$graph->render( 400, 200, 'tutorial_reference_svg.svg' );

$graph->driver->options->linkCursor = 'crosshair';
ezcGraphTools::linkSvgElements( $graph );

?>
