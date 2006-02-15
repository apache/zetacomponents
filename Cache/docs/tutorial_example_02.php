<?php

require_once 'tutorial_autoload.php';

$optionsPlain = array(
    'ttl'   => 30,
);
$optionsArray = array(
    'ttl'   => 45,
);

ezcCacheManager::createCache( 'plain', '/tmp/cache/plain', 'ezcCacheStorageFilePlain', $optionsPlain );
ezcCacheManager::createCache( 'array', '/tmp/cache/array', 'ezcCacheStorageFileArray', $optionsArray );

$myId = 'unique_id_2';

$cache = ezcCacheManager::getCache( 'plain' );

if ( ( $plainData = $cache->restore( $myId ) ) === false )
{
    $plainData = "Plain cache stored on " . date( 'Y-m-d, H:m:s' );
    $cache->store( $myId, $plainData );

    sleep( 2 );
}

echo "Plain cache data:\n";
var_dump( $plainData );

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
