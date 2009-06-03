<?php

class ezcWebdavLockPluginClientTestAssertions041
{
    public function assertTargetGone( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertFalse(
            $backend->nodeExists( '/collection' )
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions041();

?>
