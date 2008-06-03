<?php
require_once 'tutorial_autoload.php';

// on localhost with the default port
$handler = new ezcSearchSolrHandler;

// on another host with a different port
$handler = new ezcSearchSolrHandler( '10.0.2.184', 9123 );
?>
