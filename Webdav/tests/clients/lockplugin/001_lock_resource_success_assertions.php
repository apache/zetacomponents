<?php

function assertLockDiscoveryPropertyCorrect( ezcWebdavMemoryBackend $backend )
{
    $prop = $backend->getProperty( '/collection/resource.html', 'lockdiscovery' );
    PHPUnit_Framework_Assert::assertNotNull(
        $prop,
        'Lock discovery property not set.'
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

function assertLockInfoPropertyCorrect( ezcWebdavMemoryBackend $backend )
{
    $prop = $backend->getProperty( '/collection/resource.html', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );
    PHPUnit_Framework_Assert::assertNotNull(
        $prop,
        'Lock info property not set.'
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

function assertLockDiscoveryPropertyNowhereElse( ezcWebdavMemoryBackend $backend )
{
    $prop = $backend->getProperty( '/collection', 'lockdiscovery' );

    PHPUnit_Framework_Assert::assertNull(
        $prop
    );
}

function assertLockInfoPropertyNowhereElse( ezcWebdavMemoryBackend $backend )
{
    $prop = $backend->getProperty( '/collection', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

    PHPUnit_Framework_Assert::assertNull(
        $prop
    );
}

return array(
    'assertLockDiscoveryPropertyCorrect',
    'assertLockInfoPropertyCorrect',
);

?>
