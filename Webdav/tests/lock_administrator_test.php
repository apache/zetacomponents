<?php
/**
 * Test case for the ezcWebdavLockAdministrator class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'test_case.php';
require_once 'classes/test_auth.php';

/**
 * Tests for the ezcWebdavLockAdministrator class.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavLockAdministratorTest extends ezcWebdavTestCase
{
    protected $backend;

    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $server = ezcWebdavServer::getInstance();
        $server->auth = new ezcWebdavTestAuth();
        if ( $server->pluginRegistry->hasPlugin( ezcWebdavLockPlugin::PLUGIN_NAMESPACE ) )
        {
            $server->pluginRegistry->unregisterPlugin(
                new ezcWebdavLockPluginConfiguration()
            );
        }
        $server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration()
        );

        $tmpDir = $this->createTempDir( __CLASS__ );

        $this->backend = new ezcWebdavMemoryBackend();
        $this->backend->options['lockFile'] = $tmpDir . '/backend.lock';
        $this->backend->addContents(
            array(
                'collection' => array(
                    'res_1' => '',
                    'subcol' => array(
                        'res_2' => '',
                        'res_3' => '',
                    ),
                ),
                'secure_collection' => array(
                    'res_4' => '',
                    'other_subcol' => array(
                        'res_5' => '',
                        'res_6' => '',
                    ),
                ),
            )
        );

    }

    public function tearDown()
    {
        $server = ezcWebdavServer::getInstance();
        $server->auth = null;
        $server->pluginRegistry->unregisterPlugin(
            new ezcWebdavLockPluginConfiguration()
        );

        $this->backend = null;

        $this->removeTempDir();
    }

    public function testPurgeCompleteNoLocks()
    {
        $expectedBackend = clone $this->backend;

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks();

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgePartlyNoLocks()
    {
        $expectedBackend = clone $this->backend;

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks( '/collection' );

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgeCompleteOutdatedResourceLockedSimple()
    {
        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/collection/res_1',
            new ezcWebdavLockDiscoveryProperty()
        );

        $this->backend->setProperty(
            '/collection/res_1',
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                            ezcWebdavRequest::DEPTH_ZERO,
                            new ezcWebdavPotentialUriContent(
                                'http://example.com/some_user',
                                true
                            ),
                            300, // 5 mins timeout
                            new ezcWebdavPotentialUriContent(
                                'opaquelocktoken:1234',
                                true
                            ),
                            null,
                            new ezcWebdavDateTime( '@' . ( time() - 600 ) )
                        ),
                    )
                )
            )
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks();

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgeCompleteOutdatedResourceLockedComplex()
    {
        $expectedLockDiscovery = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED,
                        ezcWebdavRequest::DEPTH_ZERO,
                        new ezcWebdavPotentialUriContent(
                            'http://example.com/some_user',
                            true
                        ),
                        300, // 5 mins timeout
                        new ezcWebdavPotentialUriContent(
                            'opaquelocktoken:1234',
                            true
                        ),
                        null,
                        new ezcWebdavDateTime()
                    ),
                )
            )
        );

        $actualLockDiscovery = clone $expectedLockDiscovery;
        $actualLockDiscovery->activeLock->append(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_SHARED,
                ezcWebdavRequest::DEPTH_ZERO,
                new ezcWebdavPotentialUriContent(
                    'http://example.com/some_user',
                    true
                ),
                300, // 5 mins timeout
                new ezcWebdavPotentialUriContent(
                    'opaquelocktoken:5678',
                    true
                ),
                null,
                new ezcWebdavDateTime( '@' . ( time() - 600 ) )
            )
        );

        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/collection/res_1',
            $expectedLockDiscovery
        );

        $this->backend->setProperty(
            '/collection/res_1',
            $actualLockDiscovery
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks();

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgeCompleteOutdatedCollectionLockedComplex()
    {
        $expectedLockDiscoveryParent = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED,
                        ezcWebdavRequest::DEPTH_ZERO,
                        new ezcWebdavPotentialUriContent(
                            'http://example.com/some_user',
                            true
                        ),
                        300, // 5 mins timeout
                        new ezcWebdavPotentialUriContent(
                            'opaquelocktoken:1234',
                            true
                        ),
                        null,
                        new ezcWebdavDateTime()
                    ),
                )
            )
        );
        $expectedLockDiscoveryChild = new ezcWebdavLockDiscoveryProperty();

        $actualLockDiscoveryParent = clone $expectedLockDiscoveryParent;
        $actualLockDiscoveryParent->activeLock->append(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_SHARED,
                ezcWebdavRequest::DEPTH_INFINITY,
                new ezcWebdavPotentialUriContent(
                    'http://example.com/some_user',
                    true
                ),
                300, // 5 mins timeout
                new ezcWebdavPotentialUriContent(
                    'opaquelocktoken:5678',
                    true
                ),
                null,
                new ezcWebdavDateTime( '@' . ( time() - 600 ) )
            )
        );

        $actualLockDiscoveryChild = clone $actualLockDiscoveryParent;
        $actualLockDiscoveryChild->activeLock->offsetUnset( 0 );
        $actualLockDiscoveryChild->activeLock->offsetGet( 1 )->lastAccess = null;
        $actualLockDiscoveryChild->activeLock->offsetGet( 1 )->baseUri = '/collection';

        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/collection',
            $expectedLockDiscoveryParent
        );
        $expectedBackend->setProperty(
            '/collection/res_1',
            $expectedLockDiscoveryChild
        );

        $this->backend->setProperty(
            '/collection',
            $actualLockDiscoveryParent
        );
        $this->backend->setProperty(
            '/collection/res_1',
            $actualLockDiscoveryChild
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks();

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgePartlyNoLocksSecured()
    {
        $expectedBackend = clone $this->backend;

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks( '/secure_collection' );

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgeCompleteOutdatedResourceLockedSimpleSecured()
    {
        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/secure_collection/res_1',
            new ezcWebdavLockDiscoveryProperty()
        );

        $this->backend->setProperty(
            '/secure_collection/res_1',
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                            ezcWebdavRequest::DEPTH_ZERO,
                            new ezcWebdavPotentialUriContent(
                                'http://example.com/some_user',
                                true
                            ),
                            300, // 5 mins timeout
                            new ezcWebdavPotentialUriContent(
                                'opaquelocktoken:1234',
                                true
                            ),
                            null,
                            new ezcWebdavDateTime( '@' . ( time() - 600 ) )
                        ),
                    )
                )
            )
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks();

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgeCompleteOutdatedResourceLockedComplexSecured()
    {
        $expectedLockDiscovery = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED,
                        ezcWebdavRequest::DEPTH_ZERO,
                        new ezcWebdavPotentialUriContent(
                            'http://example.com/some_user',
                            true
                        ),
                        300, // 5 mins timeout
                        new ezcWebdavPotentialUriContent(
                            'opaquelocktoken:1234',
                            true
                        ),
                        null,
                        new ezcWebdavDateTime()
                    ),
                )
            )
        );

        $actualLockDiscovery = clone $expectedLockDiscovery;
        $actualLockDiscovery->activeLock->append(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_SHARED,
                ezcWebdavRequest::DEPTH_ZERO,
                new ezcWebdavPotentialUriContent(
                    'http://example.com/some_user',
                    true
                ),
                300, // 5 mins timeout
                new ezcWebdavPotentialUriContent(
                    'opaquelocktoken:5678',
                    true
                ),
                null,
                new ezcWebdavDateTime( '@' . ( time() - 600 ) )
            )
        );

        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/secure_collection/res_1',
            $expectedLockDiscovery
        );

        $this->backend->setProperty(
            '/secure_collection/res_1',
            $actualLockDiscovery
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks();

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgeCompleteOutdatedCollectionLockedComplexSecured()
    {
        $expectedLockDiscoveryParent = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED,
                        ezcWebdavRequest::DEPTH_ZERO,
                        new ezcWebdavPotentialUriContent(
                            'http://example.com/some_user',
                            true
                        ),
                        300, // 5 mins timeout
                        new ezcWebdavPotentialUriContent(
                            'opaquelocktoken:1234',
                            true
                        ),
                        null,
                        new ezcWebdavDateTime()
                    ),
                )
            )
        );
        $expectedLockDiscoveryChild = new ezcWebdavLockDiscoveryProperty();

        $actualLockDiscoveryParent = clone $expectedLockDiscoveryParent;
        $actualLockDiscoveryParent->activeLock->append(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_SHARED,
                ezcWebdavRequest::DEPTH_INFINITY,
                new ezcWebdavPotentialUriContent(
                    'http://example.com/some_user',
                    true
                ),
                300, // 5 mins timeout
                new ezcWebdavPotentialUriContent(
                    'opaquelocktoken:5678',
                    true
                ),
                null,
                new ezcWebdavDateTime( '@' . ( time() - 600 ) )
            )
        );

        $actualLockDiscoveryChild = clone $actualLockDiscoveryParent;
        $actualLockDiscoveryChild->activeLock->offsetUnset( 0 );
        $actualLockDiscoveryChild->activeLock->offsetGet( 1 )->lastAccess = null;
        $actualLockDiscoveryChild->activeLock->offsetGet( 1 )->baseUri = '/secure_collection';

        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/secure_collection',
            $expectedLockDiscoveryParent
        );
        $expectedBackend->setProperty(
            '/secure_collection/res_1',
            $expectedLockDiscoveryChild
        );

        $this->backend->setProperty(
            '/secure_collection',
            $actualLockDiscoveryParent
        );
        $this->backend->setProperty(
            '/secure_collection/res_1',
            $actualLockDiscoveryChild
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks();

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgePartlyOutdatedResourceLockedSimple()
    {
        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/collection/res_1',
            new ezcWebdavLockDiscoveryProperty()
        );

        $this->backend->setProperty(
            '/collection/res_1',
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                            ezcWebdavRequest::DEPTH_ZERO,
                            new ezcWebdavPotentialUriContent(
                                'http://example.com/some_user',
                                true
                            ),
                            300, // 5 mins timeout
                            new ezcWebdavPotentialUriContent(
                                'opaquelocktoken:1234',
                                true
                            ),
                            null,
                            new ezcWebdavDateTime( '@' . ( time() - 600 ) )
                        ),
                    )
                )
            )
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks( '/collection' );

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgePartlyOutdatedResourceLockedComplex()
    {
        $expectedLockDiscovery = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED,
                        ezcWebdavRequest::DEPTH_ZERO,
                        new ezcWebdavPotentialUriContent(
                            'http://example.com/some_user',
                            true
                        ),
                        300, // 5 mins timeout
                        new ezcWebdavPotentialUriContent(
                            'opaquelocktoken:1234',
                            true
                        ),
                        null,
                        new ezcWebdavDateTime()
                    ),
                )
            )
        );

        $actualLockDiscovery = clone $expectedLockDiscovery;
        $actualLockDiscovery->activeLock->append(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_SHARED,
                ezcWebdavRequest::DEPTH_ZERO,
                new ezcWebdavPotentialUriContent(
                    'http://example.com/some_user',
                    true
                ),
                300, // 5 mins timeout
                new ezcWebdavPotentialUriContent(
                    'opaquelocktoken:5678',
                    true
                ),
                null,
                new ezcWebdavDateTime( '@' . ( time() - 600 ) )
            )
        );

        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/collection/res_1',
            $expectedLockDiscovery
        );

        $this->backend->setProperty(
            '/collection/res_1',
            $actualLockDiscovery
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks( '/collection' );

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }

    public function testPurgePartlyOutdatedCollectionLockedComplex()
    {
        $expectedLockDiscoveryParent = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED,
                        ezcWebdavRequest::DEPTH_ZERO,
                        new ezcWebdavPotentialUriContent(
                            'http://example.com/some_user',
                            true
                        ),
                        300, // 5 mins timeout
                        new ezcWebdavPotentialUriContent(
                            'opaquelocktoken:1234',
                            true
                        ),
                        null,
                        new ezcWebdavDateTime()
                    ),
                )
            )
        );
        $expectedLockDiscoveryChild = new ezcWebdavLockDiscoveryProperty();

        $actualLockDiscoveryParent = clone $expectedLockDiscoveryParent;
        $actualLockDiscoveryParent->activeLock->append(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_SHARED,
                ezcWebdavRequest::DEPTH_INFINITY,
                new ezcWebdavPotentialUriContent(
                    'http://example.com/some_user',
                    true
                ),
                300, // 5 mins timeout
                new ezcWebdavPotentialUriContent(
                    'opaquelocktoken:5678',
                    true
                ),
                null,
                new ezcWebdavDateTime( '@' . ( time() - 600 ) )
            )
        );

        $actualLockDiscoveryChild = clone $actualLockDiscoveryParent;
        $actualLockDiscoveryChild->activeLock->offsetUnset( 0 );
        $actualLockDiscoveryChild->activeLock->offsetGet( 1 )->lastAccess = null;
        $actualLockDiscoveryChild->activeLock->offsetGet( 1 )->baseUri = '/collection';

        $expectedBackend = clone $this->backend;

        $expectedBackend->setProperty(
            '/collection',
            $expectedLockDiscoveryParent
        );
        $expectedBackend->setProperty(
            '/collection/res_1',
            $expectedLockDiscoveryChild
        );

        $this->backend->setProperty(
            '/collection',
            $actualLockDiscoveryParent
        );
        $this->backend->setProperty(
            '/collection/res_1',
            $actualLockDiscoveryChild
        );

        $admin = new ezcWebdavLockAdministrator( $this->backend );
        $admin->purgeLocks( '/collection' );

        $this->assertEquals(
            $expectedBackend,
            $this->backend
        );
    }
}

?>
