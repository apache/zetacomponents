<?php

$db = ezcDbInstance::get();

$rows = $db->query( 'SELECT * FROM quotes' );

?>
