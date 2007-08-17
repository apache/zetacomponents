<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = new ezcTreeXml( 'files/example1.xml', $store );

$memTree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
ezcTree::copy( $tree, $memTree );

echo $memTree->getChildCountRecursive( 'Elements' ), "\n";
?>
