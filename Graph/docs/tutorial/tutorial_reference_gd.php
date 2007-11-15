<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEzGreen();
$graph->title = 'Access statistics';

$graph->driver = new ezcGraphGdDriver();
$graph->options->font = 'tutorial_font.ttf';

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->data['Access statistics']->url = 'http://example.org/';
$graph->data['Access statistics']->url['Mozilla'] = 'http://example.org/mozilla';

$graph->render( 400, 200, 'tutorial_reference_gd.png' );

?>
<html>
    <head><title>Image map example</title></head>
<body>
<?php

echo ezcGraphTools::createImageMap( $graph, 'GraphPieChartMap' );

?>
    <img
        src="tutorial_reference_gd.png"
        width="400" height="200"
        usemap="#GraphPieChartMap" />
</body>
</html>
<?php
?>
