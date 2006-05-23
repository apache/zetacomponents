<?php

$db = ezcDbInstance::get();

$q = $db->createSelectQuery();

// innerJoin(), rightJoin() and leftJoin() could be used in three forms:

// 1. simple form, performs join of two tables: 
//    rightJoin( 't1', 't2', 't1.id', 't2.id' ) 
//    takes 4 string arguments and return SQL string
 
// $q->rightJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) will produce 
// string "table1 RIGHT JOIN table2 ON table1.id = table2.id"
// that should be added to FROM clause of query.
// resulting query is "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id".
$q->select( 'id' )->from( $q->rightJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
$q->prepare();
$q->execute();

// Other two forms of innerJoin(), rightJoin() and leftJoin() could be 
// used to build complex joins of more than two tables.
// *Join() methods could be invoked several times during building query.
// Each invocation joins one table.
// innerJoin(), rightJoin() and leftJoin() in this forms returns ezcQuery object.

// 2. rightJoin( 'table2', $joinCondition )
//    takes 2 string arguments ( table name and join condition ) and return ezcQuery.

// will produce the same query as above i.e.
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id".
$q->select( 'id' )->from( 'table1' )->rightJoin( 'table2', $q->expr->eq('table1.id', 'table2.id' ) );
$q->prepare();
$q->execute();


// will produce SQL for joining 3 tables:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id < table2.id RIGHT JOIN table3 ON table2.id > table3.id".
$q->select( 'id' )
        ->from( 'table1' )
            ->rightJoin( 'table2', $q->expr->lt('table1.id', 'table2.id' ) )
            ->rightJoin( 'table3', $q->expr->gt('table2.id', 'table3.id' ) );
$q->prepare();
$q->execute();


// 3. simplified version of 2.
//    Takes 3 arguments ( table name, column , column )
//    rightJoin( 'table1', 'table1.id', 'table2.id' )
//    This equals to rightJoin( 'table1', $this->expr->eq('table1.id', 'table2.id' ) );

// will produce SQL for joining 3 tables:
// "SELECT id FROM table1 RIGHT JOIN table2 ON table1.id = table2.id RIGHT JOIN table3 ON table2.id = table3.id".
$q->select( 'id' )
        ->from( 'table1' )
            ->rightJoin( 'table2', 'table1.id', 'table2.id' )
            ->rightJoin( 'table3', 'table2.id', 'table3.id' );
$q->prepare();
$q->execute();


?>
