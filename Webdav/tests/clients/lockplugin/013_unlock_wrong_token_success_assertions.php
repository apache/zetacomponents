<?php

class ezcWebdavLockPluginClientTestAssertions013
{
    public function assertLockNullResourceRemoved( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/resource.html' ),
            'Lock null resource /collection/resource.html gone.'
        );
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection' ),
            'Collection /collection is gone.'
        );
    }

    public function assertLockDiscoveryPropertyStillCorrect( ezcWebdavMemoryBackend $backend )
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

        $prop = $backend->getProperty( '/collection/resource.html', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockDiscoveryProperty',
            $prop,
            'Property has incorrect type.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Active lock element not present in null resource anymore.'
        );
    }

    public function assertLockInfoPropertyStillCorrect( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNull(
            $prop
        );

        $prop = $backend->getProperty( '/collection/resource.html', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop
        );
        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockInfoProperty',
            $prop
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->tokenInfos ),
            'Number of token info elements incorrect.'
        );
        PHPUnit_Framework_Assert::assertTrue(
            $prop->null,
            'Lock null resource is not null anymore.'
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions013();

?>
