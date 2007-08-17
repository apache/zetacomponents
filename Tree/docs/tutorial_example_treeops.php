<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = new ezcTreeXml( 'files/example1.xml', $store );

if ( $tree->fetchNodeById( 'F' )
          ->isDescendantOf( $tree->fetchNodeById( 'NonMetals' ) ) )
{
    echo "Flourine is a non-metal.<br/>\n";
}

if ( $tree->isDescendantOf( 'O', 'NonMetals' ) )
{
    echo "Oxygen is a non-metal.<br/>\n";
}

$nonMetals = $tree->fetchSubtree( 'NonMetals' );
echo "We found {$nonMetals->size} non-metals: \n";
foreach ( $nonMetals->nodes as $node )
{
    echo "- {$node->id}: {$node->data} \n";
}
?>
