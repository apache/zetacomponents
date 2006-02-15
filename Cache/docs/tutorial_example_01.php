<?php

require_once 'tutorial_autoload.php';

$options = array(
    'ttl'   => 30,
);

ezcCacheManager::createCache( 'simple', '/tmp/cache/plain', 'ezcCacheStorageFilePlain', $options );

$myId = 'unique_id_1';

$cache = ezcCacheManager::getCache( 'simple' );

if ( ( $data = $cache->restore( $myId ) ) === false )
{
    $data = "Plain cache stored on " . date( 'Y-m-d, H:i:s' );
    $cache->store( $myId, $data );
}

var_dump( $data );

?>
