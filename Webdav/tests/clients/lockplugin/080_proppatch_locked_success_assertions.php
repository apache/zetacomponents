<?php

class ezcWebdavLockPluginClientTestAssertions080
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
        
        $prop = $backend->getProperty( '/collection/resource.html', 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->tokenInfos ),
            'Target parent lock info gone.'
        );
    }

    public function assertTargetPropertySet( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/collection/resource.html', 'authors', 'http://www.w3.com/standards/z39.50/' );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Desired property not set.'
        );
    }
}

return new ezcWebdavLockPluginClientTestAssertions080();

?>
