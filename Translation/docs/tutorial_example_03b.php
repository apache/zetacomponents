<?php
require_once 'tutorial_example_03.php';

$manager = new ezcTranslationManager( $backend );
$manager->addFilter( ezcTranslationBorkFilter::getInstance() );
$search = $manager->getContext( 'nl_NL', 'search' );
$params = array( 'search_string' => 'appelmoes', 'matches' => 4 );
echo $search->getTranslation( "Search for '%search_string' returned %matches matches.", $params ), "\n";

$manager = new ezcTranslationManager( $backend );
$manager->addFilter( ezcTranslationLeetFilter::getInstance() );
$search = $manager->getContext( 'nl_NL', 'search' );
$params = array( 'search_string' => 'appelmoes', 'matches' => 4 );
echo $search->getTranslation( "Search for '%search_string' returned %matches matches.", $params ), "\n";
?>
