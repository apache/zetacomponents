<?php

class ezcWebdavLockPluginClientTestAssertions012
{
    public function assertLockNullResourceRemoved( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertFalse(
            $backend->nodeExists( '/collection/resource.html' ),
            'Lock null resource /collection/resource.html not gone.'
        );
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection' ),
            'Collection /collection is gone.'
        );
    }

    public function assertLockDiscoveryPropertyNowhere( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockDiscoveryProperty',
            $prop,
            'Property has incorrect type.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            0,
            count( $prop->activeLock ),
            'Active lock element not removed correctly from root.'
        );
    }

    public function assertLockInfoPropertyNowhere( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNull(
            $prop
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions012();

?>
