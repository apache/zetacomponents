<?php

class ezcWebdavLockPluginClientTestAssertions014
{
    public function assertSourceGone( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertFalse(
            $backend->nodeExists( '/collection/resource.html' )
        );
    }

    public function assertDestinationParentStillCorrect( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/other_collection', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock discovery property removed from destination parent.'
        );
        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockDiscoveryProperty',
            $prop
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Active lock element removed from destination parent.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            'opaquelocktoken:5678',
            $prop->activeLock[0]->token->__toString(),
            'Active lock token on destination parent incorrect.'
        );
    }

    public function assertDestinationCorrect( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/other_collection/moved_resource.html' ) 
        );

        $prop = $backend->getProperty( '/other_collection/moved_resource.html', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock discovery property not available on destination.'
        );
        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockDiscoveryProperty',
            $prop
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Active lock element not available on destination.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            'opaquelocktoken:5678',
            $prop->activeLock[0]->token->__toString(),
            'Active lock token on destination incorrect.'
        );
    }

}

return new ezcWebdavLockPluginClientTestAssertions014();

?>
