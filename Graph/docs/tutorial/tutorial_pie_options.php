<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->title = 'Elections 2005 Germany';

$graph->data['2005'] = new ezcGraphArrayDataSet( array(
    'CDU' => 35.2,
    'SPD' => 34.2,
    'FDP' => 9.8,
    'Die Gruenen' => 8.1,
    'PDS' => 8.7,
    'NDP' => 1.6,
    'REP' => 0.6,
) );

$graph->options->label = '%3$.1f%%';
$graph->options->sum = 100;
$graph->options->percentThreshold = 0.02;
$graph->options->summarizeCaption = 'Others';

$graph->render( 400, 150, 'tutorial_pie_options.svg' );

?>
