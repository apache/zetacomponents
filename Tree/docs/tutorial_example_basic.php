<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = new ezcTreeXml( 'files/example1.xml', $store );

$f = $tree->fetchNodeById( 'F' );
echo $f->data, "<br/>\n"; // echos Fluorine
?>
