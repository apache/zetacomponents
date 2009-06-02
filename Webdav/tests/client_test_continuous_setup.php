<?php

require_once 'client_test_setup.php';

class ezcWebdavClientTestContinuousSetup extends ezcWebdavClientTestSetup
{
    protected $backend;

    public function performSetup( ezcWebdavClientTest $test, $testSetId )
    {
        if ( $this->backend === null )
        {
            $this->backend       = $this->setupBackend();
        }

        $test->server  = self::getServer(
            new ezcWebdavBasicPathFactory( 'http://webdav' )
        );
        $test->backend = $this->backend;
    }

    protected function setupBackend()
    {
        return require dirname( __FILE__ ) . '/scripts/test_generator_backend.php';
    }
}

?>
