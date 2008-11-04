<?php

class ezcWebdavLockPluginClientTestAssertions004
{
    public function assertLockDiscoveryPropertyCorrect( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection/newcollection', 'lockdiscovery' );
        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock discovery property not set.'
        );
        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockDiscoveryProperty',
            $prop,
            'Lock discovery property has incorrect type.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Number of activeLock elements incorrect.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            new ezcWebdavPotentialUriContent(
                'http://example.com/some/user',
                true
            ),
            $prop->activeLock[0]->owner,
            'Lock owner not correct.'
        );
    }

    public function assertLockInfoPropertyCorrect( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection/newcollection', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );
        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock info property not set.'
        );
        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockInfoProperty',
            $prop,
            'Lock discovery property has incorrect type.'
        );
        PHPUnit_Framework_Assert::assertTrue(
            $prop->null,
            'Null resource not defined as such.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->tokenInfos ),
            'Number of tokenInfo elements incorrect.'
        );
        PHPUnit_Framework_Assert::assertNull(
            $prop->tokenInfos[0]->lockBase,
            'Lock base set, although lock is root.'
        );
        PHPUnit_Framework_Assert::assertNotNull(
            $prop->tokenInfos[0]->lastAccess,
            'Last access time not set, although lock is root.'
        );
    }

    public function assertLockDiscoveryPropertyNowhereElse( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNull(
            $prop
        );
    }

    public function assertLockInfoPropertyNowhereElse( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNull(
            $prop
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions004();

?>
