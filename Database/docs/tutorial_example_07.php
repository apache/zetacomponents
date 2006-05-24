<?php

$db = ezcDbInstance::get();

$q = $db->createSelectQuery();

// Right join of two tables. Will produce SQL:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id".
$q->select( 'id' )->from( 'table1' )->rightJoin( 'table2', $q->expr->eq('table1.id', 'table2.id' ) );

$q->prepare();
$q->execute();


// Right join of three tables. Will produce SQL:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id < table2.id RIGHT JOIN table3 ON table2.id > table3.id".
$q->select( 'id' )
        ->from( 'table1' )
            ->rightJoin( 'table2', $q->expr->lt('table1.id', 'table2.id' ) )
            ->rightJoin( 'table3', $q->expr->gt('table2.id', 'table3.id' ) );
$q->prepare();
$q->execute();


// rightJoin( 'table1', 'table1.id', 'table2.id' ) it's just shorter equivalent
// for rightJoin( 'table1', $this->expr->eq('table1.id', 'table2.id' ) );
// Right join of three tables. Will produce SQL:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id RIGHT JOIN table3 ON table2.id = table3.id".
$q->select( 'id' )
        ->from( 'table1' )
            ->rightJoin( 'table2', 'table1.id', 'table2.id' )
            ->rightJoin( 'table3', 'table2.id', 'table3.id' );
$q->prepare();
$q->execute();


?>
