<?php
class testDelayedInitCacheManager implements ezcBaseConfigurationInitializer
{
    static function configureObject( $identifier )
    {
        if ( $identifier !== false )
        {
            switch ( $identifier )
            {
                case 'simple':
                    ezcCacheManager::createCache( $identifier, '/tmp', 'ezcCacheStorageFilePlain' );
                    break;
            }
        }
    }
}
?>
