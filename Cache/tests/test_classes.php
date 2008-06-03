<?php

class testDelayedInitCacheManager implements ezcBaseConfigurationInitializer
{
    public static $tmpDir;

    static function configureObject( $identifier )
    {
        if ( $identifier !== false )
        {
            switch ( $identifier )
            {
                case 'simple':
                    ezcCacheManager::createCache( $identifier, self::$tmpDir, 'ezcCacheStorageFilePlain' );
                    break;
            }
        }
    }
}

?>
