<?php

class ezcWebdavLockPluginClientTestAssertions065
{
    public function assertLockNullStillExists( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/newcollection' )
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions065();

?>
