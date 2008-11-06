<?php

class ezcWebdavLockPluginClientTestAssertions075
{
    public function assertLockNullStillExists( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/newresource' )
        );
    }

    public function assertLockNullStillCorrect( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection/newresource', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

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
        PHPUnit_Framework_Assert::assertTrue(
            $prop->null,
            'New collections appears to be lock null resource.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            'opaquelocktoken:5678',
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

return new ezcWebdavLockPluginClientTestAssertions075();

?>
