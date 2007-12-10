<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = new ezcTreeXml( 'files/example1.xml', $store );

$visitor = new ezcTreeVisitorYUI( 'menu' );
$tree->accept( $visitor );
echo (string) $visitor;
?>
