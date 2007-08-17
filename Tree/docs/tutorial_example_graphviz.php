<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = new ezcTreeXml( 'files/example1.xml', $store );

$visitor = new ezcTreeVisitorGraphViz;
$tree->accept( $visitor );
file_put_contents( 'files/graphviz.dot', (string) $visitor );
?>
