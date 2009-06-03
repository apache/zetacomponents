<?php

class ezcWebdavLockPluginClientTestAssertions074
{
    public function assertCollectionNotCreated( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertFalse(
            $backend->nodeExists( '/collection/newresource' )
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions074();

?>
