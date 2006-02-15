<?php

$db = ezcDbInstance::get();

$q = $db->createSelectQuery();
$e = $q->expr; // fetch the expression object
$q->select( '*' )->from( 'quotes' )
    ->where( $e->eq( 'author', $q->bindValue( 'Robert Foster' ) ) )
    ->orderBy( 'quote' )
    ->limit( 10, 0 );

$stmt = $q->prepare();
$stmt->execute();

?>
