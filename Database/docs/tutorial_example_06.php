<?php

$db = ezcDbInstance::get();

// Insert
$q = $db->createInsertQuery();
$q->insertInto( 'quotes' )
  ->set( 'id', 1 )
  ->set( 'name', $q->bindValue( 'Robert Foster' ) )
  ->set( 'quote', $q->bindValue( "It doesn't look as if it's ever used!" ) );
$q->prepare();
$q->execute();

// update
$q = $db->createUpdateQuery();
$q->update( 'quotes' )
  ->set( 'quote', 'His skin is cold... Like plastic...' )
  ->where( $q->expr->eq( 'id', 1 ) );
$q->prepare();
$q->execute();

// delete
$q = $db->createDeleteQuery();
$q->deleteFrom( 'quotes' )
  ->where( $q->expr->eq( $q->bindValue( 'Robert Foster' ) ) );
$q->prepare();
$q->execute();
?>
