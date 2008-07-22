<?php

require_once 'tutorial_autoload.php';

$server = ezcWebdavServer::getInstance();

$pathFactory = new ezcWebdavBasicPathFactory(
    'http://example.com/webdav/index.php'
);

foreach ( $server->configurations as $conf )
{
    $conf->pathFactory = $pathFactory;
}

$backend = new ezcWebdavFileBackend(
   dirname( __FILE__ ) . '/backend'
);

$server->handle( $backend ); 

?>
