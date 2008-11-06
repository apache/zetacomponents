<?php

class ezcWebdavLockPluginClientTestAssertions062
{
    public function assertCollectionCreated( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/newcollection' )
        );
    }

    public function assertCollectionLockedFromParent( ezcWebdavMemoryBackend $backend )
    {
        $parentProp = $backend->getProperty( '/collection', 'lockdiscovery' );
        $childProp  = $backend->getProperty( '/collection/newcollection', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotEquals(
            $parentProp,
            $childProp,
            'New collection did inherit parents lock.'
        );

        $prop = $backend->getProperty( '/collection/newcollection', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock info property null on new collection.'
        );
        PHPUnit_Framework_Assert::assertType(
            'ezcWebdavLockInfoProperty',
            $prop
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->tokenInfos ),
            'Token info element not present in new collection.'
        );
        PHPUnit_Framework_Assert::assertFalse(
            $prop->null,
            'New collections appears to be lock null resource.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            'opaquelocktoken:1234',
            $prop->tokenInfos[0]->token,
            'Incorrect lock token in new collections token info element.'
        );
        PHPUnit_Framework_Assert::assertNull(
            $prop->tokenInfos[0]->lockBase,
            'Incorrect lock base in new collections token info element.'
        );
        PHPUnit_Framework_Assert::assertNotNull(
            $prop->tokenInfos[0]->lastAccess,
            'Incorrect last access in new collections token info element.'
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions062();

?>
