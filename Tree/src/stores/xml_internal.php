<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeXml is an implementation of a tree backend that operates on
 * an XML file.
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeXmlInternalDataStore extends ezcTreeXmlDataStore
{
    /**
     * Retrieves the data for the node $node from the data store and assigns it
     * to the node's 'data' property.
     *
     * @param ezcTreeNode $node
     */
    public function fetchDataForNode( ezcTreeNode $node )
    {
        $id = $node->id;
        $elem = $this->dom->getElementById( "id$id" );
        $node->data = $elem->getElementsByTagNameNS( 'http://components.ez.no/Tree/data', 'data' )->item(0)->firstChild->data;
    }

    /**
     * Retrieves the data for all the nodes in the node list $nodeList and
     * assigns this data to the nodes' 'data' properties.
     *
     * @param ezcTreeNodeList $nodeList
     */
    public function fetchDataForNodes( ezcTreeNodeList $nodeList )
    {
    }

    /**
     * Stores the data in the node to the data store.
     *
     * @param ezcTreeNode $node
     */
    public function storeDataForNode( ezcTreeNode $node )
    {
        $id = $node->id;
        $elem = $this->dom->getElementById( "id$id" );
        $dataNode = $elem->ownerDocument->createElement( 'etd:data', $node->data );
        $elem->appendChild( $dataNode );
    }
}
?>
