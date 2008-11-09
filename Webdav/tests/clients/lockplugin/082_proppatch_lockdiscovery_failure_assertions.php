<?php

class ezcWebdavLockPluginClientTestAssertions082
{
    public function assertTargetStillExisst( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/resource.html' )
        );
    }

    public function assertTargetStillLocked( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection/resource.html', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock discovery property removed from target.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Target parent active lock gone.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            'opaquelocktoken:1234',
            $prop->activeLock[0]->token->__toString()
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions082();

?>
