<?php

require_once 'tutorial_autoload.php';

require_once 'custom_lock_auth.php';

$server = ezcWebdavServer::getInstance();

$server->auth = new myCustomLockAuth(
    // Some configuration directory here
    dirname( __FILE__ ) . '/tokens.php'
);

$server->pluginRegistry->registerPlugin(
    new ezcWebdavLockPluginConfiguration()
);

$backend = new ezcWebdavFileBackend(
    // Your WebDAV directory here
    dirname( __FILE__ ) . '/backend'
);

$server->handle( $backend );

?>
