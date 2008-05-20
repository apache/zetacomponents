<?php

require_once 'tutorial_autoload.php';

class myCustomConfigurator extends ezcCacheStackConfigurator
{
    public static function configure( ezcCacheStack $stack )
    {
        // ... create your storages here or fetch from manager...
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'file',
                $fileStorage,
                1000000,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'apc',
                $apcStorage,
                1000,
                .3
            )
        );
    }
}

$stackOptions = array(
    'bubbleUpOnRestore' => true,
    'configurator'      => 'myCustomConfigurator',
);

$stack = new ezcCacheStack( 'stack' );
ezcCacheManager::createCache(
    'stack',
    'stack',
    'ezcCacheStack',
    $stackOptions
);

// ... somewhere else...

$stack = ezcCacheManager::getCache( 'stack' );

?>
