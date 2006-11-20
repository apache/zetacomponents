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

$graph->render( 400, 200, 'tutorial_example_08.png' );

$elements = $graph->renderer->getElementReferences();

?>
<html>
    <head><title>Image map example</title></head>
    <body>
        <map 
            name="ezcGraphPieChartMap">
<?php
    foreach ( $elements['legend'] as $objectName => $polygones )
    {
        foreach ( $polygones as $shape => $polygone )
        {
            $coordinateString = '';
            foreach( $polygone as $coordinate )
            {
                $coordinateString .= sprintf( '%d,%d,', $coordinate->x, $coordinate->y );
            }

            printf( "<area shape=\"poly\" coords=\"%s\" href=\"/detailedData.php?browser=%s\" alt=\"%s: %s\" title=\"%s: %s\" />\n",
                substr( $coordinateString, 0, -1 ),
                $objectName,
                $shape, $objectName,
                $shape, $objectName
            );
        }
    }
?>
        </map>
        <img
            src="tutorial_example_08.png"
            width="400" height="200"
            usemap="#ezcGraphPieChartMap"
    </body>
</html>
<?php
?>
