<?php
require_once 'tutorial_autoload.php';

$reader = new ezcTranslationTsBackend( dirname( __FILE__ ). '/translations' );
$reader->setOptions( array( 'format' => 'translation-[LOCALE].xml' ) );
$reader->initReader( 'nb_NO' );

$cacheObj = new ezcCacheStorageFileArray( dirname( __FILE__ ). '/translations-cache' );
$writer = new ezcTranslationCacheBackend( $cacheObj );
$writer->initWriter( 'nb_NO' );

foreach ( $reader as $contextName => $contextData )
{
    $writer->storeContext( $contextName, $contextData );
}

$reader->deInitReader();
$writer->deInitWriter();
?>
