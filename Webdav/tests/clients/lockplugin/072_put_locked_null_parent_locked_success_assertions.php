<?php

class ezcWebdavLockPluginClientTestAssertions072
{
    public function assertCollectionCreated( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/newresource' )
        );
    }

    public function assertCollectionLockedFromParent( ezcWebdavMemoryBackend $backend )
    {
        $parentProp = $backend->getProperty( '/collection', 'lockdiscovery' );
        $childProp  = $backend->getProperty( '/collection/newresource', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotEquals(
            $parentProp,
            $childProp,
            'New collection did inherit parents lock.'
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions072();

?>
