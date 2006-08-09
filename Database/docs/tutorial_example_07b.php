<?php

$db = ezcDbInstance::get();

$q = $db->createSelectQuery();

// Right join of three tables. Will produce SQL:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id RIGHT JOIN table3 ON table2.id = table3.id".
$q->select( 'id' )
        ->from( 'table1' )
            ->rightJoin( 'table2', 'table1.id', 'table2.id' )
            ->rightJoin( 'table3', 'table2.id', 'table3.id' );

$stmt = $q->prepare();
$stmt->execute();


?>
