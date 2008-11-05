<?php

$backendBefore = new ezcWebdavMemoryBackend();

$backendBefore->addContents(
    array(
        'collection' => array(
            'resource.html' => '',
        ),
    )
);

$backendBefore->setProperty(
    '/collection',
    new ezcWebdavLockDiscoveryProperty()
);

$backendBefore->setProperty(
    '/collection/resource.html',
    new ezcWebdavLockDiscoveryProperty()
);

return $backendBefore;

?>
