<?php

require_once 'client_test_setup.php';

class ezcWebdavClientTestContinuousSetup extends ezcWebdavClientTestSetup
{
    protected static $backend;

    protected static $lastTestSetId;

    public static function performSetup( ezcWebdavClientTest $test, $testSetId )
    {
        // echo "Last: " . self::$lastTestSetId . ". This: $testSetId\n";
        if (  $testSetId <= self::$lastTestSetId || self::$backend === null )
        {
            self::$backend       = self::setupBackend();
        }
        self::$lastTestSetId = $testSetId;

        $test->server  = self::getServer(
            new ezcWebdavBasicPathFactory( 'http://webdav' )
        );
        $test->backend = self::$backend;
    }

    protected static function setupBackend()
    {
        return require dirname( __FILE__ ) . '/scripts/test_generator_backend.php';
    }
}

?>
