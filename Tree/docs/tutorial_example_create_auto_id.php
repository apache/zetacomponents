<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = ezcTreeXml::create( 'files/royals.xml', $store );
$tree->autoId = true;

$rootNode = $tree->createNode( null, 'Beatrix' );
$tree->setRootNode( $rootNode );

$willem = $tree->createNode( null, 'Willem-Alexander' );
$rootNode->addChild( $willem );
$friso = $tree->createNode( null, 'Friso' );
$rootNode->addChild( $friso );

echo $friso->id, "\n";

$willem->addChild( $tree->createNode( null, 'Catharina' ) );
$willem->addChild( $tree->createNode( null, 'Alexia' ) );
$willem->addChild( $tree->createNode( null, 'Ariane' ) );

$friso->addChild( $tree->createNode( null, 'Luana' ) );
$friso->addChild( $tree->createNode( null, 'Zaria' ) );
?>
