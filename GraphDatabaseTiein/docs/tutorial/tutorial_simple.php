<?php

require_once 'tutorial_insert_data.php';

// Receive data from database
$db = ezcDbInstance::get();
$query = $db->createSelectQuery();
$query
    ->select( 'browser', 'hits' )
    ->from( 'browser_hits' );
$statement = $query->prepare();
$statement->execute();

// Create chart from data
$chart = new ezcGraphPieChart();
$chart->title = 'Browser statistics';

$chart->data['browsers'] = new ezcGraphDatabaseDataSet( $statement );

$chart->render( 400, 200, 'tutorial_simple.svg' );

?>
