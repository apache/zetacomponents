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
        if ( $node->id == 'Al' )
        {
            $node->data = 'Aluminium';
        }

        switch( $node->id )
        {
            case 'Aries':  $node->data = '♈'; break;
            case 'Taurus': $node->data = '♉'; break;
            case 'Gemini': $node->data = '♊'; break;
            case 'Cancer': $node->data = '♋'; break;
        }
        $node->dataFetched = true;
    }

    public function fetchDataForNodes( ezcTreeNodeList $nodeList )
    {
        foreach( $nodeList->nodes as $node )
        {
            $this->fetchDataForNode( $node );
        }
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
