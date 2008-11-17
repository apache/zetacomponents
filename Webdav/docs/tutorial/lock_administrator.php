<?php

require_once 'tutorial_autoload.php';

require_once 'custom_lock_auth.php';

$server = ezcWebdavServer::getInstance();

$server->pluginRegistry->registerPlugin(
    new ezcWebdavLockPluginConfiguration()
);

$backend = new ezcWebdavFileBackend(
    // Your WebDAV directory here
    dirname( __FILE__ ) . '/backend'
);

$administrator = new ezcWebdavLockAdministrator(
    $backend
);

$administrator->purgeLocks();

?>
