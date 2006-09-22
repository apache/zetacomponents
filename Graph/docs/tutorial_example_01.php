<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->title = 'Access statistics';

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->render( 400, 200, 'tutorial_example_01.svg' );

?>
