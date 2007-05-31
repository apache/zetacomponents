<?php

require_once 'tutorial_insert_data.php';

// Receive data from database
$db = ezcDbInstance::get();
$query = $db->createSelectQuery();
$query
    ->select( '*' )
    ->from( 'browser_hits' );
$statement = $query->prepare();
$statement->execute();

// Create chart from data
$chart = new ezcGraphPieChart();
$chart->title = 'Browser statistics';
$chart->legend = false;

$chart->data['browsers'] = new ezcGraphDatabaseDataSet( 
    $statement,
    array(
        ezcGraph::KEY   => 'browser',
        ezcGraph::VALUE => 'hits',
    )
);

// Some graph output formatting
$chart->renderer = new ezcGraphRenderer3d();

$chart->renderer->options->pieChartGleam = .3;
$chart->renderer->options->pieChartGleamColor = '#FFFFFF';
$chart->renderer->options->dataBorder = false;

$chart->renderer->options->pieChartShadowSize = 5;
$chart->renderer->options->pieChartShadowColor = '#000000';

$chart->renderer->options->pieChartSymbolColor = '#55575388';

$chart->renderer->options->pieChartHeight = 5;
$chart->renderer->options->pieChartRotation = .8;

// Render
$chart->render( 400, 150, 'tutorial_multiple.svg' );

?>
