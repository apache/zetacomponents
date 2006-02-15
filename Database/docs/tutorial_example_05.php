<?php

$db = ezcDbInstance::get();

$q = $db->createSelectQuery();
$q->select( '*' )->from( 'quotes' );

$stmt = $q->prepare();
$stmt->execute();

?>
