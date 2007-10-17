<?php

require_once 'client_test_setup.php';

class ezcWebdavClientTestContinuousSetup extends ezcWebdavClientTestSetup
{
    protected static $pathFactory;

    protected static $backend;

    protected static $lastTestSuite;

    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        if ( basename( dirname( $testSetName ) ) !== self::$lastTestSuite )
        {
            self::$lastTestSuite = basename( dirname( $testSetName ) );
            self::$pathFactory   = new ezcWebdavBasicPathFactory( 'http://webdav' );
            self::$backend       = self::setupBackend();
        }

        $test->server  = self::getServer( self::$pathFactory );
        $test->backend = self::$backend;
    }

    protected static function setupBackend()
    {
        return require dirname( __FILE__ ) . '/scripts/test_generator_backend.php';
    }
}

?>
