<?php

require_once 'client_test_setup.php';
require_once 'classes/client_test_lock_auth.php';

class ezcWebdavClientTestRfcLockSetup extends ezcWebdavClientTestSetup
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        $pathFactory  = new ezcWebdavBasicPathFactory( 'http://www.foo.bar' );

        $testSetName = basename( $testSetName );
        switch( $testSetName )
        {
            case '001_lock_1':
                $customPathFactory = self::getSetup1( $test );
                break;
            case '002_lock_2':
                $customPathFactory = self::getSetup2( $test );
                break;
            case '003_lock_3':
                $customPathFactory = self::getSetup3( $test );
                break;
            case '004_lockdiscovery':
                $customPathFactory = self::getSetup4( $test );
                break;
            /*
            case '005_move_collection_locked':
                $customPathFactory = self::getSetup5( $test );
                break;
            */

            case '009_unlock':
                $customPathFactory = self::getSetup9( $test );
                break;
            default:
                throw new RuntimeException( "Could not find setup for test set '$testSetName'." );
        }

        $test->server = self::getServer(
            ( $customPathFactory === null ? $pathFactory : $customPathFactory )
        );
        $test->server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration(
                new ezcWebdavLockPluginOptions(
                    array( 'lockTimeout' => 604800 )
                )
            )
        );

        $test->server->auth = new ezcWebdavClientTestRfcLockAuth();
    }

    protected static function getSetup1( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();

        $test->backend->addContents(
            array(
                'workspace' => array(
                    'webdav' => array(
                        'proposal.doc' => '',
                    ),
                ),
            )
        );
    }

    protected static function getSetup2( ezcWebdavClientTest $test )
    {
        self::getSetup1( $test );
        $test->backend->setProperty(
            '/workspace/webdav/proposal.doc',
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                            ezcWebdavRequest::DEPTH_INFINITY,
                            new ezcWebdavPotentialUriContent(
                                'http://www.ics.uci.edu/~ejw/contact.html',
                                true
                            ),
                            40,
                            new ezcWebdavPotentialUriContent(
                                'opaquelocktoken:e71d4fae-5dec-22d6-fea5-00a0c91e6be4',
                                true
                            )
                        ),
                    )
                )
            )
        );
    }

    protected static function getSetup3( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();

        $test->backend->addContents(
            array(
                'webdav' => array(
                    'secret' => ''
                ),
            )
        );
    }

    protected static function getSetup4( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();

        $test->backend->addContents(
            array(
                'container' => array(
                ),
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                            ezcWebdavRequest::DEPTH_ZERO,
                            new ezcWebdavPotentialUriContent(
                                'Jane Smith'
                            ),
                            40,
                            new ezcWebdavPotentialUriContent(
                                'opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76',
                                true
                            )
                        ),
                    )
                )
            )
        );
    }

    protected static function getSetup5( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();

        $test->backend->addContents(
            array(
                'container' => array(
                ),
                'othercontainer' => array(
                )
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                            ezcWebdavRequest::DEPTH_ZERO,
                            new ezcWebdavPotentialUriContent(
                                'Jane Smith'
                            ),
                            40,
                            new ezcWebdavPotentialUriContent(
                                'opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76',
                                true
                            )
                        ),
                    )
                )
            )
        );
    }

    protected static function getSetup9( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();

        $test->backend->addContents(
            array(
                'workspace' => array(
                    'webdav' => array(
                        'info.doc' => '',
                    ),
                ),
            )
        );

        $lockDiscoveryProperty = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                        ezcWebdavRequest::DEPTH_INFINITY,
                        new ezcWebdavPotentialUriContent(
                            'http://www.ics.uci.edu/~ejw/contact.html',
                            true
                        ),
                        40,
                        new ezcWebdavPotentialUriContent(
                            'opaquelocktoken:a515cfa4-5da4-22e1-f5b5-00a0451e6bf7',
                            true
                        )
                    ),
                )
            )
        );

        // Lock is unlocked on a deeper resource in the lock,
        // just to make a more complex scenario.
        $test->backend->setProperty(
            '/workspace/webdav/info.doc',
            $lockDiscoveryProperty
        );
        $test->backend->setProperty(
            '/workspace/webdav',
            $lockDiscoveryProperty
        );

        $test->backend->setProperty(
            '/workspace/webdav/info.doc',
            new ezcWebdavLockInfoProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockTokenInfo(
                            'opaquelocktoken:a515cfa4-5da4-22e1-f5b5-00a0451e6bf7',
                            '/workspace/webdav'
                        ),
                    )
                ),
                // Make this a null lock resource
                true
            )
        );
        $test->backend->setProperty(
            '/workspace/webdav',
            new ezcWebdavLockInfoProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockTokenInfo(
                            'opaquelocktoken:a515cfa4-5da4-22e1-f5b5-00a0451e6bf7',
                            null,
                            new DateTime()
                        ),
                    )
                )
            )
        );
    }
}

?>
