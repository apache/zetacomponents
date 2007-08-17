<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = new ezcTreeXml( 'files/example1.xml', $store );

$noble = $tree->fetchChildren( 'NobleGasses' );
echo "We found {$noble->size} noble gasses: \n";

foreach ( new ezcTreeNodeListIterator( $tree, $noble, true ) as $nodeId => $nodeData )
{
    echo "- {$nodeId}: {$nodeData} \n";
}
?>
