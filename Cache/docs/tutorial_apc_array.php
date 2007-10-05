<?php

require_once 'tutorial_autoload.php';

$options = array(
    'ttl'   => 45,
);

ezcCacheManager::createCache( 'array', '/tmp/cache/array', 'ezcCacheStorageFileApcArray', $optionsArray );

$cache = ezcCacheManager::getCache( 'array' );

if ( ( $arrayData = $cache->restore( $myId ) ) === false )
{
    $arrayData = array( 
        $plainData,
        "Array cache stored on " . date( 'Y-m-d, H:m:s'),
        true,
        23
    );
    $cache->store( $myId, $arrayData );
}

echo "Array cache data:\n";
var_dump( $arrayData );

?>
