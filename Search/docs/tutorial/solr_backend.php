<?php
require_once 'tutorial_autoload.php';

// on localhost with the default port
$backend = new ezcSearchSolrHandler;

// on another host with a different port
$backend = new ezcSearchSolrHandler( '10.0.2.184', 9123 );
?>
