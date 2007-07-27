<?php
class TestTranslateDataStore extends ezcTreeMemoryDataStore implements ezcTreeDataStore
{
    public function fetchDataForNode( ezcTreeNode $node )
    {
        if ( $node->id == 'vuur' )
        {
            $node->data = array( 'en' => 'fire', 'de' => 'feuer', 'no' => 'fyr' );
        }
        if ( $node->id == 'Be' )
        {
            $node->data = 'Beryllium';
        }
    }

    public function fetchDataForNodes( ezcTreeNodeList $nodeList )
    {
        /* This is a no-op as the data is already in the $node */
    }

    public function storeDataForNode( ezcTreeNode $node )
    {
        /* This is a no-op as the data is already in the $node */
    }
}

class TestExtendedTreeNode extends ezcTreeNode
{
}
?>
