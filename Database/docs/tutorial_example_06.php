<?php

$db = ezcDbInstance::get();

// Insert
$q = $db->createInsertQuery();
$q->insertInto( 'quotes' )
  ->set( 'id', 1 )
  ->set( 'name', $q->bindValue( 'Robert Foster' ) )
  ->set( 'quote', $q->bindValue( "It doesn't look as if it's ever used!" ) );
$stmt = $q->prepare();
$stmt->execute();

// update
$q = $db->createUpdateQuery();
$q->update( 'quotes' )
  ->set( 'quote', 'His skin is cold... Like plastic...' )
  ->where( $q->expr->eq( 'id', 1 ) );
$stmt = $q->prepare();
$stmt->execute();

// delete
$q = $db->createDeleteQuery();
$q->deleteFrom( 'quotes' )
  ->where( $q->expr->eq( 'name', $q->bindValue( 'Robert Foster' ) ) );
$stmt = $q->prepare();
$stmt->execute();
?>
