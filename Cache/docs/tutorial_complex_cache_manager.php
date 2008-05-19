<?php

require_once 'tutorial_autoload.php';

$options = array(
    'ttl'   => 30,
);

ezcCacheManager::createCache( 'array', '/tmp/cache/array', 'ezcCacheStorageFileArray', $options );

$exampleData = array( 
    'unique_id_3_a' => array( 'language' => 'en', 'section' => 'articles' ),
    'unique_id_3_b' => array( 'language' => 'de', 'section' => 'articles' ),
    'unique_id_3_c' => array( 'language' => 'no', 'section' => 'articles' ),
    'unique_id_3_d' => array( 'language' => 'de', 'section' => 'tutorials' ),
);

$cache = ezcCacheManager::getCache( 'array' );

foreach ( $exampleData as $myId => $exampleDataArr )
{
    if ( ( $data = $cache->restore( $myId, $exampleDataArr ) ) === false )
    {
        $cache->store( $myId, $exampleDataArr, $exampleDataArr );
    }
}

echo "Data items with attribute <section> set to <articles>: " .
     $cache->countDataItems( null, array( 'section' => 'articles' ) ) .
     "\n";
     
echo "Data items with attribute <language> set to <de>: " .
     $cache->countDataItems( null, array( 'language' => 'de' ) ) .
     "\n\n";

$cache->delete( null, array( 'language' => 'de' ) );

echo "Data items with attribute <section> set to <articles>: " .
     $cache->countDataItems( null, array( 'section' => 'articles' ) ) .
     "\n";
     
echo "Data items with attribute <language> set to <de>: " .
     $cache->countDataItems( null, array( 'language' => 'de' ) ) .
     "\n\n";

?>
