<?php

require_once 'tutorial_insert_data.php';

// Receive data from database
$db = ezcDbInstance::get();
$query = $db->createSelectQuery();
$query
    ->select( 'hits' )
    ->from( 'browser_hits' );
$statement = $query->prepare();
$statement->execute();

// Create chart from data
$chart = new ezcGraphLineChart();
$chart->title = 'Browser statistics';
$chart->options->fillLines = 220;

$chart->data['browsers'] = new ezcGraphDatabaseDataSet( $statement );
$chart->data['average'] = new ezcGraphDataSetAveragePolynom(
    $chart->data['browsers']
);

$chart->render( 400, 150, 'tutorial_single.svg' );

?>
