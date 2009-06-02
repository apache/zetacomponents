<?php

require_once 'client_test_setup.php';
require_once 'classes/client_test_lock_auth.php';

class ezcWebdavClientTestRfcLockSetup extends ezcWebdavClientTestSetup
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        $test->server = self::getServer(
            new ezcWebdavBasicPathFactory( 'http://example.com' )
        );
        $test->server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration(
                new ezcWebdavLockPluginOptions(
                    array( 'lockTimeout' => 604800 )
                )
            )
        );
        $test->server->auth = new ezcWebdavClientTestRfcLockAuth();

        $testSetName = basename( $testSetName );

        switch( $testSetName )
        {
            case 1:
                $customPathFactory = self::getSetup1( $test );
                break;
            case 2:
                $customPathFactory = self::getSetup2( $test );
                break;
            case 3:
                $customPathFactory = self::getSetup3( $test );
                break;
            case 4:
                $customPathFactory = self::getSetup4( $test );
                break;
            case 5:
                $customPathFactory = self::getSetup5( $test );
                break;
            case 6:
                $customPathFactory = self::getSetup6( $test );
                break;
            case 7:
                $customPathFactory = self::getSetup6( $test );
                break;
            case 8:
                $customPathFactory = self::getSetup8( $test );
                break;
            case 9:
                $customPathFactory = self::getSetup9( $test );
                break;
            default:
                throw new RuntimeException( "Could not find setup for test set '$testSetName'." );
        }
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
        $test->server->auth->tokenAssignement = array(
            '' => array(
                'opaquelocktoken:e71d4fae-5dec-22d6-fea5-00a0c91e6be4' => true,
            ),
        );
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
                                'http://example.com/~ejw/contact.html',
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
        $test->server->auth->tokenAssignement = array(
            '' => array(
                'opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4' => true,
                'opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77' => true,
            ),
        );

        $test->backend->addContents(
            array(
                'othercontainer' => array(
                    'C2' => array(),
                ),
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
                                'opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4',
                                true
                            )
                        ),
                    )
                )
            )
        );
        $test->backend->setProperty(
            '/othercontainer',
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
                                'opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77',
                                true
                            )
                        ),
                    )
                )
            )
        );
        $test->backend->setProperty(
            '/othercontainer/C2',
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                            ezcWebdavRequest::DEPTH_INFINITY,
                            new ezcWebdavPotentialUriContent(
                                'Someone else'
                            ),
                            40,
                            new ezcWebdavPotentialUriContent(
                                'some lock token'
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
        $test->server->auth->tokenAssignement = array(
            '' => array(
                'opaquelocktoken:a515cfa4-5da4-22e1-f5b5-00a0451e6bf7' => true,
            ),
        );

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
                            'http://example.com/~ejw/contact.html',
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
    }

    protected static function getSetup6( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend( false );

        $test->backend->addContents(
            array(
                'container' => array(
                    'front.html' => '',
                    'R2'         => '',
                    'resource3'  => '',
                ),
            )
        );

        // Properties for /container

        $test->backend->setProperty(
            '/container',
            new ezcWebdavCreationDateProperty(
                new ezcWebdavDateTime( '1997-12-01T17:42:21-0800' )
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDisplayNameProperty( 'Example collection' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetContentTypeProperty( 'httpd/unix-directory' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetEtagProperty( 'e81e84d5197f72cd038aa2a768d15247' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetLastModifiedProperty(
                new ezcWebdavDateTime( 'Mon, 15 Aug 2005 15:13:00 +0000' )
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetContentLengthProperty( '4096' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavResourceTypeProperty()
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDeadProperty(
                'http://ns.example.com/boxschema/',
                'bigbox',
                <<<EOT
<R:bigbox xmlns:R="http://ns.example.com/boxschema/">
  <R:BoxType>Box type A</R:BoxType>
</R:bigbox>
EOT
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDeadProperty(
                'http://ns.example.com/boxschema/',
                'author',
                <<<EOT
<R:author xmlns:R="http://ns.example.com/boxschema/">
  <R:Name>Hadrian</R:Name>
</R:author>
EOT
            )
        );

        // Properties for /container/front.html

        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavCreationDateProperty(
                new ezcWebdavDateTime( '1997-12-01T18:27:21-0800' )
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavDisplayNameProperty( 'Example HTML resource' )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetContentTypeProperty( 'text/html' )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetEtagProperty( 'zzyzx' )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetLastModifiedProperty(
                new ezcWebdavDateTime( 'Mon, 12 Jan 1998 09:25:56 +0000' )
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetContentLengthProperty( '4525' )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavResourceTypeProperty()
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavDeadProperty(
                'http://ns.example.com/boxschema/',
                'bigbox',
                <<<EOT
<R:bigbox xmlns:R="http://ns.example.com/boxschema/">
  <R:BoxType>Box type B</R:BoxType>
</R:bigbox>
EOT
            )
        );

        // Properties for /container/R2

        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavCreationDateProperty(
                new ezcWebdavDateTime( '2003-05-27T11:27:00+0000' )
            )
        );
        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavDisplayNameProperty( 'R2' )
        );
        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavGetContentTypeProperty( 'httpd/unix-directory' )
        );
        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavGetEtagProperty( '08f842b302fbfbfde8049178085e6972' )
        );
        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavGetLastModifiedProperty(
                new ezcWebdavDateTime( 'Mon, 15 Aug 2005 15:13:00 +0000' )
            )
        );
        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavGetContentLengthProperty( '4096' )
        );
        $test->backend->setProperty(
            '/container/R2',
            new ezcWebdavResourceTypeProperty(
                ezcWebdavResourceTypeProperty::TYPE_COLLECTION
            )
        );

        // Properties for /container/resource3

        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavCreationDateProperty(
                new ezcWebdavDateTime( '2003-05-27T11:27:00' )
            )
        );
        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavDisplayNameProperty( 'resource3' )
        );
        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavGetContentTypeProperty( 'application/octet-stream' )
        );
        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavGetEtagProperty( 'a952a3dcd83383fc7dbacee5f21106cb' )
        );
        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavGetLastModifiedProperty(
                new ezcWebdavDateTime( 'Mon, 15 Aug 2005 15:13:00 +0000' )
            )
        );
        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavGetContentLengthProperty( '0' )
        );
        $test->backend->setProperty(
            '/container/resource3',
            new ezcWebdavResourceTypeProperty()
        );
    }

    protected static function getSetup8( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend( false );

        $test->backend->addContents(
            array(
                'container' => array(
                ),
            )
        );

        // Properties for /container

        $test->backend->setProperty(
            '/container',
            new ezcWebdavCreationDateProperty(
                new ezcWebdavDateTime( '1997-12-01T17:42:21-0800' )
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDisplayNameProperty( 'Example collection' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetContentTypeProperty( 'httpd/unix-directory' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetEtagProperty( 'e81e84d5197f72cd038aa2a768d15247' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetLastModifiedProperty(
                new ezcWebdavDateTime( 'Mon, 15 Aug 2005 15:13:00 +0000' )
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavGetContentLengthProperty( '4096' )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavResourceTypeProperty()
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDeadProperty(
                'http://ns.example.com/boxschema/',
                'bigbox',
                <<<EOT
<R:bigbox xmlns:R="http://ns.example.com/boxschema/">
  <R:BoxType>Box type A</R:BoxType>
</R:bigbox>
EOT
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDeadProperty(
                'http://ns.example.com/boxschema/',
                'author',
                <<<EOT
<R:author xmlns:R="http://ns.example.com/boxschema/">
  <R:Name>Hadrian</R:Name>
</R:author>
EOT
            )
        );
    }
}

?>
