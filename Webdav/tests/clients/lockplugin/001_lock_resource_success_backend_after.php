<?php

$backendAfter = require '001_lock_resource_success_backend_before.php';

$backendAfter->setProperty(
    '/collection/resource.html',
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

$backendAfter->setProperty(
    '/collection/resource.html',
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

return $backendAfter;

?>
