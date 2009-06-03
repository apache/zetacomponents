<?php

class ezcWebdavLockPluginClientTestAssertions013
{
    public function assertLockNullResourceNotRemoved( ezcWebdavMemoryBackend $backend )
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
}

return new ezcWebdavLockPluginClientTestAssertions013();

?>
