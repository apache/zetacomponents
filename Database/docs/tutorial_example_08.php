<?php

$db = ezcDbInstance::get();

$q = $db->createSelectQuery();

// $q->rightJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) will produce
// string "table1 RIGHT JOIN table2 ON table1.id = table2.id"
// that should be added to FROM clause of query.
// resulting query is "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id".
$q->select( 'id' )->from( $q->rightJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
$stmt = $q->prepare();
$stmt->execute();

?>
