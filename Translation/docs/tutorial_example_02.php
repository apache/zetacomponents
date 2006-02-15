<?php
require_once 'tutorial_autoload.php';

$backend = new ezcTranslationTsBackend( dirname( __FILE__ ). '/translations' );
$backend->setOptions( array( 'format' => 'translation-[LOCALE].xml' ) );

$manager = new ezcTranslationManager( $backend );
$dutch = $manager->getContext( 'nl_NL', 'search' );
$norsk = $manager->getContext( 'nb_NO', 'search' );

$params = array( 'search_string' => 'appelmoes', 'matches' => 4 );
echo $dutch->getTranslation( "Search for '%search_string' returned %matches matches.", $params ), "\n";

$params = array( 'fruit' => 'epplet' );
echo $norsk->getTranslation( "The %fruit is round.", $params ), "\n";
?>
