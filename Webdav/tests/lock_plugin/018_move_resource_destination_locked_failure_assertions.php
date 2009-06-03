<?php

class ezcWebdavLockPluginClientTestAssertions018
{
    public function assertSourceStillExists( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertTrue(
            $backend->nodeExists( '/collection/resource.html' )
        );
    }

    public function assertDestinationParentStillCorrect( ezcWebdavMemoryBackend $backend )
    {
        $prop = $backend->getProperty( '/other_collection', 'lockdiscovery' );

        PHPUnit_Framework_Assert::assertNotNull(
            $prop,
            'Lock discovery property set on destination parent.'
        );
        PHPUnit_Framework_Assert::assertEquals(
            1,
            count( $prop->activeLock ),
            'Active lock available not on destination parent.'
        );
    }

    public function assertDestinationNotExists( ezcWebdavMemoryBackend $backend )
    {
        PHPUnit_Framework_Assert::assertFalse(
            $backend->nodeExists( '/other_collection/moved_resource.html' ) 
        );
    }

}

return new ezcWebdavLockPluginClientTestAssertions018();

?>
