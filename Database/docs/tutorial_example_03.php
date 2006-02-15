<?php

$db = ezcDbInstance::get();
$stmt = $db->prepare( 'SELECT * FROM quotes where author = :author' );
$stmt->bindValue( ':author', 'Robert Foster' );

$stmt->execute();
$rows = $stmt->fetchAll();

?>
