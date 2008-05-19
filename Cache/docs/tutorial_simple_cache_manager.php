<?php

require_once 'tutorial_autoload.php';

$options = array(
    'ttl'   => 30,
);

ezcCacheManager::createCache( 'simple', '/tmp/cache/plain', 'ezcCacheStorageFilePlain', $options );

$myId = 'unique_id_1';
$mySecondId = 'id_2';

$cache = ezcCacheManager::getCache( 'simple' );

if ( ( $dataOfFirstItem = $cache->restore( $myId ) ) === false )
{
    $dataOfFirstItem = "Plain cache stored on " . date( 'Y-m-d, H:i:s' );
    $cache->store( $myId, $dataOfFirstItem );
}

if ( ( $dataOfSecondItem = $cache->restore( $mySecondId ) ) === false )
{
    $dataOfSecondItem = "Plain cache 2 stored on " . date( 'Y-m-d, H:i:s' );
    $cache->store( $mySecondId, $dataOfSecondItem );
}

var_dump( $dataOfFirstItem, $dataOfSecondItem );

?>
