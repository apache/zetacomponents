<?php

$db = ezcDbInstance::get();

$q = $db->createSelectQuery();

// Right join of two tables. Will produce SQL:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id".
$q->select( 'id' )->from( 'table1' )->rightJoin( 'table2', $q->expr->eq( 'table1.id', 'table2.id' ) );

$stmt = $q->prepare();
$stmt->execute();

// Right join of three tables. Will produce SQL:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id < table2.id RIGHT JOIN table3 ON table2.id > table3.id".
$q->select( 'id' )
        ->from( 'table1' )
            ->rightJoin( 'table2', $q->expr->lt( 'table1.id', 'table2.id' ) )
            ->rightJoin( 'table3', $q->expr->gt( 'table2.id', 'table3.id' ) );

$stmt = $q->prepare();
$stmt->execute();
?>
