<?php

class ezcWebdavLockPluginClientTestAssertions075
{
    public function assertLockNullStillExists( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/newresource' )
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions075();

?>
