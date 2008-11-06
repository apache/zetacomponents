<?php

$backendBefore = new ezcWebdavMemoryBackend();

$backendBefore->addContents(
    array(
        'collection' => array(
            'resource.html' => '',
            'newresource' => '',
        ),
    )
);

$backendBefore->setProperty(
    '/collection',
    new ezcWebdavLockDiscoveryProperty(
        new ArrayObject(
            array(
                new ezcWebdavLockDiscoveryPropertyActiveLock(
                    ezcWebdavLockRequest::TYPE_WRITE,
                    ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                    ezcWebdavRequest::DEPTH_ZERO,
                    new ezcWebdavPotentialUriContent(
                        'http://example.com/some/user',
                        true
                    ),
                    604800,
                    new ezcWebdavPotentialUriContent(
                        'opaquelocktoken:5678',
                        true
                    )
                ),
            )
        )
    )
);

$backendBefore->setProperty(
    '/collection',
    new ezcWebdavLockInfoProperty(
        new ArrayObject(
            array(
                new ezcWebdavLockTokenInfo(
                    'opaquelocktoken:5678',
                    null,
                    new DateTime()
                ),
            )
        ),
        true
    )
);

$backendBefore->setProperty(
    '/collection/newresource',
    new ezcWebdavLockDiscoveryProperty(
        new ArrayObject(
            array(
                new ezcWebdavLockDiscoveryPropertyActiveLock(
                    ezcWebdavLockRequest::TYPE_WRITE,
                    ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                    ezcWebdavRequest::DEPTH_INFINITY,
                    new ezcWebdavPotentialUriContent(
                        'http://example.com/some/user',
                        true
                    ),
                    604800,
                    new ezcWebdavPotentialUriContent(
                        'opaquelocktoken:1234',
                        true
                    )
                ),
            )
        )
    )
);

$backendBefore->setProperty(
    '/collection/newresource',
    new ezcWebdavLockInfoProperty(
        new ArrayObject(
            array(
                new ezcWebdavLockTokenInfo(
                    'opaquelocktoken:1234',
                    null,
                    new DateTime()
                ),
            )
        )
    )
);

return $backendBefore;

?>
