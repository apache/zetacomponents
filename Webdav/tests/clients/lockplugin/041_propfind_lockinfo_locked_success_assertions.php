<?php

class ezcWebdavLockPluginClientTestAssertions041
{
    public function assertTargetStillThere( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection' )
        );
    }

    public function assertTargetStillLocked( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock discovery property removed from source.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Target active lock gone.'
        );
        
        $prop = $backend->getProperty( '/collection', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->tokenInfos ),
            'Target lock info gone.'
        );
    }

    public function assertTargetChildStillThere( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/resource.html' )
        );
    }

    public function assertTargetChildStillLocked( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection/resource.html', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock discovery property removed from source.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Target child active lock gone.'
        );
        
        $prop = $backend->getProperty( '/collection/resource.html', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->tokenInfos ),
            'Target child lock info gone.'
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions041();

?>
