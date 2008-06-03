<?php
require_once 'tutorial_autoload.php';

$handler = new ezcSearchSolrHandler;
$manager = new ezcSearchEmbeddedManager;

$session = new ezcSearchSession( $handler, $manager );
?>
