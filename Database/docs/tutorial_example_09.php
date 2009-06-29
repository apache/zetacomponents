<?php

$name = 'IBM';
$q = new ezcQuerySelect( ezcDbInstance::get() );

// Creating subselect object
$q2 = $q->subSelect();

// $q2 will build the subquery "SELECT company FROM query_test WHERE
// company = :ezcValue1 AND id > 2". This query will be used inside the SQL for
// $q.
$q2->select( 'company' )
   ->from( 'query_test' )
   ->where( $q2->expr->eq( 'company', $q2->bindParam( $name ) ), 'id > 2' );

// $q the resulting query. It produces the following SQL:
// SELECT * FROM query_test
// WHERE  id >= 1  AND
//     company IN ( (
//         SELECT company FROM query_test
//         WHERE company = :ezcValue1 AND id > 2
//     ) )
$q->select('*')
  ->from( 'query_test' )
  ->where( ' id >= 1 ', $q->expr->in( 'company', $q2 ) );

$stmt = $q->prepare();
$stmt->execute();

?>
