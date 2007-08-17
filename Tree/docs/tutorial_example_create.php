<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = ezcTreeXml::create( 'files/example1.xml', $store );

$rootNode = $tree->createNode( 'Elements', 'Elements' );
$tree->setRootNode( $rootNode );

$nonMetal = $tree->createNode( 'NonMetals', 'Non-Metals' );
$rootNode->addChild( $nonMetal );
$nobleGasses = $tree->createNode( 'NobleGasses', 'Noble Gasses' );
$rootNode->addChild( $nobleGasses );

$nonMetal->addChild( $tree->createNode( 'H',  'Hydrogen' ) );
$nonMetal->addChild( $tree->createNode( 'C',  'Carbon' ) );
$nonMetal->addChild( $tree->createNode( 'N',  'Nitrogen' ) );
$nonMetal->addChild( $tree->createNode( 'O',  'Oxygen' ) );
$nonMetal->addChild( $tree->createNode( 'P',  'Phosphorus' ) );
$nonMetal->addChild( $tree->createNode( 'S',  'Sulfur' ) );
$nonMetal->addChild( $tree->createNode( 'Se', 'Selenium' ) );

$nobleGasses->addChild( $tree->createNode( 'F',  'Fluorine' ) );
$nobleGasses->addChild( $tree->createNode( 'Cl', 'Chlorine' ) );
$nobleGasses->addChild( $tree->createNode( 'Br', 'Bromine' ) );
$nobleGasses->addChild( $tree->createNode( 'I',  'Iodine' ) );
?>
