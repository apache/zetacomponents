<?php

require_once 'tutorial_autoload.php';

$server = ezcWebdavServer::getInstance();
$backend = new ezcWebdavFileBackend(
   dirname( __FILE__ ) . '/backend'
);

$server->handle( $backend ); 

?>
