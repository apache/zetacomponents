<?php

$db = ezcDbFactory::create( 'mysql://user:password@host/database' );
ezcDbInstance::set( $db );

// anywhere later in your program you can retrieve the db instance again using
$db = ezcDbInstance::get();

?>
