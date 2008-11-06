<?php

$backendBefore = new ezcWebdavMemoryBackend();

$backendBefore->addContents(
    array(
        'collection' => array(
            'resource.html' => "Some content.\n",
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
                        'opaquelocktoken:1234',
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
                    'opaquelocktoken:1234',
                    null,
                    new DateTime()
                ),
            )
        )
    )
);

$backendBefore->setProperty(
    '/collection/resource.html',
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
                        'opaquelocktoken:1234',
                        true
                    )
                ),
            )
        )
    )
);

$backendBefore->setProperty(
    '/collection/resource.html',
    new ezcWebdavLockInfoProperty(
        new ArrayObject(
            array(
                new ezcWebdavLockTokenInfo(
                    'opaquelocktoken:1234',
                    '/collection',
                    null
                ),
            )
        )
    )
);

return $backendBefore;

?>
