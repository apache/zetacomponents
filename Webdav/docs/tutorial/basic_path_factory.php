<?php

require_once 'tutorial_autoload.php';

$server = ezcWebdavServer::getInstance();

$server->configurations->pathFactory =
    new ezcWebdavBasicPathFactory( '/path/to/webdav' );

$backend = new ezcWebdavFileBackend(
   dirname( __FILE__ ) . '/backend'
);

$server->handle( $backend ); 

?>
