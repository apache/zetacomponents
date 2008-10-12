<?php

require_once 'client_test_setup.php';

class ezcWebdavClientTestRfcLockSetup extends ezcWebdavClientTestSetup
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        $pathFactory  = new ezcWebdavBasicPathFactory( 'http://www.foo.bar' );

        $testSetName = basename( $testSetName );
        switch( $testSetName )
        {
            case '001_lock_1':
            case '002_lock_2':
                $customPathFactory = self::getSetup1( $test );
                break;
            default:
                throw new RuntimeException( "Could not find setup for test set '$testSetName'." );
        }

        $test->server = self::getServer(
            ( $customPathFactory === null ? $pathFactory : $customPathFactory )
        );
        $test->server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration()
        );
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
}

?>
