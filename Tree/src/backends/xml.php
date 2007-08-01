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
 * @property-read ezcTreeXmlDataStore $store
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeXml extends ezcTree
{
    /**
     * Contains the relax-NG schema to validate the tree XML
     *
     * @const string relaxNG
     */
    const relaxNG = '<?xml version="1.0" encoding="UTF-8"?>
<grammar xmlns:etd="http://components.ez.no/Tree/data" ns="http://components.ez.no/Tree" xmlns="http://relaxng.org/ns/structure/1.0" datatypeLibrary="http://www.w3.org/2001/XMLSchema-datatypes">
  <start>
    <element name="tree">
      <optional>
        <ref name="node"/>
      </optional>
    </element>
  </start>
  <define name="node">
    <element name="node">
      <attribute name="id">
        <data type="ID"/>
      </attribute>
      <optional>
        <element name="etd:data">
          <text/>
        </element>
      </optional>
      <zeroOrMore>
        <ref name="node"/>
      </zeroOrMore>
    </element>
  </define>
</grammar>';

    /**
     * Contains the DOM Tree that all operations will be done on.
     *
     * When the tree object is constructed the XML is parsed with DOM and
     * stored into this member variable. When the tree is modified the changes
     * are then flushed to disk with the saveFile() method.
     *
     * @var DOMDocument $dom
     */
    private $dom;

    /**
     * The file name that contains the tree as XML string
     *
     * @var string $xmlFile
     */
    private $xmlFile;

    /**
     * Constructs a new ezcTreeXml object from the XML data in $xmlFile and using
     * the $store to retrieve data from.
     *
     * @param string $xmlFile
     * @param ezcTreeXmlDataStore $store
     */
    public function __construct( $xmlFile, ezcTreeXmlDataStore $store )
    {
        $dom = new DomDocument();
        $dom->load( $xmlFile );
        $dom->relaxNGValidateSource( self::relaxNG );

        $store->setDomTree( $dom );

        $this->dom = $dom;
        $this->xmlFile = $xmlFile;
        $this->properties['store'] = $store;
    }

    /**
     * Creates a new XML tree in the file $xmlFile using $store as data store
     *
     * @param string $xmlFile
     * @param ezcTreeXmlDataStore $store
     * @return ezcTreeXml
     */
    public static function create( $xmlFile, ezcTreeXmlDataStore $store )
    {
        $dom = new DomDocument( '1.0', 'utf-8' );

        $element = $dom->createElement( 'tree' );
        $element->setAttributeNode( new DOMAttr( 'xmlns', 'http://components.ez.no/Tree' ) );
        $element->setAttributeNode( new DOMAttr( 'xmlns:etd', 'http://components.ez.no/Tree/data' ) );

        $dom->appendChild($element);

        $dom->save( $xmlFile );
        return new ezcTreeXml( $xmlFile, $store );
    }

    /**
     * Saves the internal DOM representation of the tree back to disk
     */
    public function saveFile()
    {
        $this->dom->save( $this->xmlFile );
    }

    /**
     * Returns whether the node with ID $id exists
     *
     * @param string $id
     * @return bool
     */
    public function nodeExists( $id )
    {
        $elem = $this->dom->getElementById( "id$id" );
        return ( $elem !== NULL ) ? true : false;
    }

    /**
     * Retrieves a DOMElement containing the node with node ID $id
     *
     * @param string $id
     * @return DOMElement
     */
    private function getNodeById( $id )
    {
        $node = $this->dom->getElementById( "id$id" );
        if ( !$node )
        {
            throw new ezcTreeInvalidIdException( $id );
        }
        return $node;
    }

    /**
     * Fetches all the child "node" DOM elements of the node with ID $nodeId.
     *
     * @param $nodeId
     * @return array(string)
     */
    private function fetchChildIds( $nodeId )
    {
        $childNodes = array();
        $elem = $this->getNodeById( $nodeId );
        $children = $elem->childNodes;
        foreach ( $children as $child )
        {
            if ( $child->nodeType === XML_ELEMENT_NODE && $child->tagName == "node" )
            {
                $id = $child->getAttribute( 'id' );
                $childNodes[] = substr( $id, 2 );
            }
        }
        return $childNodes;
    }

    /**
     * Returns all the children of the node with ID $id.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchChildren( $id )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        foreach ( $this->fetchChildIds( $id ) as $childId )
        {
            $list->addNode( new $className( $this, $childId ) );
        }
        return $list;
    }

    /**
     * Returns all the nodes in the path from the root node to the node with ID
     * $id, including those two nodes.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchPath( $id )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $id ) );

        $elem = $this->dom->getElementById( "id$id" );
        $elem = $elem->parentNode;

        while ( $elem !== null && $elem->nodeType == XML_ELEMENT_NODE && $elem->tagName == 'node' )
        {
            $id = substr( $elem->getAttribute( 'id' ), 2 );
            $list->addNode( new $className( $this, $id ) );
            $elem = $elem->parentNode;
        }
        return $list;
    }

    /**
     * Adds the children nodes of the node with ID $nodeId to the
     * ezcTreeNodeList $list.
     *
     * @param ezcTreeNodeList $list
     * @param string          $nodeId
     */
    private function addChildNodes( ezcTreeNodeList $list, $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        foreach ( $this->fetchChildIds( $nodeId ) as $childId )
        {
            $list->addNode( new $className( $this, $childId ) );
            $this->addChildNodes( $list, $childId );
        }
    }

    /**
     * Alias for fetchSubtreeDepthFirst().
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtree( $nodeId )
    {
        return $this->fetchSubtreeDepthFirst( $nodeId );
    }

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Breadth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeBreadthFirst( $nodeId )
    {
    }

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Depth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeDepthFirst( $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $nodeId ) );
        $this->addChildNodes( $list, $nodeId );
        return $list;
    }

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Topological sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeTopological( $nodeId )
    {
    }

    /**
     * Returns the number of direct children of the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getChildCount( $id )
    {
        $count = 0;
        $elem = $this->getNodeById( $id );
        $children = $elem->childNodes;
        foreach ( $children as $child )
        {
            if ( $child->nodeType === XML_ELEMENT_NODE && $child->tagName == "node" )
            {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Adds the number of children with for the node with ID $nodeId nodes to
     * $count recursively.
     *
     * @param int &$count
     * @param string $nodeId
     */
    private function countChildNodes( &$count, $nodeId )
    {
        foreach ( $this->fetchChildIds( $nodeId ) as $childId )
        {
            $count++;
            $this->countChildNodes( $count, $childId );
        }
    }

    /**
     * Returns the number of children of the node with ID $id, recursively
     *
     * @param string $id
     * @return int
     */
    public function getChildCountRecursive( $id )
    {
        $count = 0;
        $this->countChildNodes( $count, $id );
        return $count;
    }

    /**
     * Returns the distance from the root node to the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getPathLength( $id )
    {
        $elem = $this->getNodeById( $id );
        $elem = $elem->parentNode;
        $length = -1;

        while ( $elem !== null && $elem->nodeType == XML_ELEMENT_NODE )
        {
            $elem = $elem->parentNode;
            $length++;
        }
        return $length;
    }

    /**
     * Returns whether the node with ID $id has children
     *
     * @param string $id
     * @return bool
     */
    public function hasChildNodes( $id )
    {
        $elem = $this->getNodeById( $id );
        $children = $elem->childNodes;
        foreach ( $children as $child )
        {
            if ( $child->nodeType === XML_ELEMENT_NODE && $child->tagName == "node" )
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns whether the node with ID $childId is a direct child of the node
     * with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    public function isChildOf( $childId, $parentId )
    {
        $elem = $this->getNodeById( $childId );
        $parentElem = $elem->parentNode;
        $id = $parentElem->getAttribute( 'id' );
        if ( $id === "id$parentId" )
        {
            return true;
        }
        return false;
    }

    /**
     * Returns whether the node with ID $childId is a direct or indirect child
     * of the node with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    public function isDecendantOf( $childId, $parentId )
    {
        $elem = $this->getNodeById( $childId );
        $elem = $elem->parentNode;

        while ( $elem !== null && $elem->nodeType == XML_ELEMENT_NODE )
        {
            $id = $elem->getAttribute( 'id' );
            if ( $id === "id$parentId" )
            {
                    return true;
            }
            $elem = $elem->parentNode;
        }
        return false;
    }

    /**
     * Returns whether the nodes with IDs $child1Id and $child2Id are siblings
     * (ie, the share the same parent)
     *
     * @param string $child1Id
     * @param string $child2Id
     * @return bool
     */
    public function isSiblingOf( $child1Id, $child2Id )
    {
        $elem1 = $this->getNodeById( $child1Id );
        $elem2 = $this->getNodeById( $child2Id );
        return (
            ( $child1Id !== $child2Id ) && 
            ( $elem1->parentNode->getAttribute( 'id' ) === $elem2->parentNode->getAttribute( 'id' ) )
        );
    }

    /**
     * Sets a new node as root node, this wipes also out the whole tree
     *
     * @param ezcTreeNode $node
     */
    public function setRootNode( ezcTreeNode $node )
    {
        $document = $this->dom->documentElement;

        // remove old root node(s)
        foreach ( $document->childNodes as $child )
        {
            if ( $child->nodeType == XML_ELEMENT_NODE && $child->tagName === 'node' )
            {
                $id = substr( $child->getAttribute( 'id' ), 2 );
                $this->delete( $id );
            }
        }
        $this->store->deleteDataForAllNodes();

        // Create new root node
        $root = $this->dom->createElement( 'node' );
        $root->setAttributeNode( new DOMAttr( 'id', "id{$node->id}" ) );
        $root->setIdAttribute( 'id', true );
        $document->appendChild( $root );
        $this->store->storeDataForNode( $node, $node->data );
        $this->saveFile();
    }

    /**
     * Adds the node $childNode as child of the node with ID $parentId
     *
     * @param string $parentId
     * @paran ezcTreeNode $childNode
     */
    public function addChild( $parentId, ezcTreeNode $childNode )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::ADD, $childNode, null, $parentId ) );
            return;
        }

        // locate parent node
        $elem = $this->getNodeById( $parentId );

        // Create new DOM node
        $child = $this->dom->createElement( 'node' );
        $child->setAttributeNode( new DOMAttr( 'id', "id{$childNode->id}" ) );
        $child->setIdAttribute( 'id', true );

        // Append to parent node
        $elem->appendChild( $child );
        $this->store->storeDataForNode( $childNode, $childNode->data );

        if ( !$this->inTransactionCommit )
        {
            $this->saveFile();
        }
    }

    /**
     * Deletes the node with ID $id from the tree, including all its children
     *
     * @param string $id
     */
    public function delete( $id )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::DELETE, null, $id ) );
            return;
        }

        // Delete all the associated data
        $nodeList = $this->fetchSubtree( $id );
        $this->store->deleteDataForNodes( $nodeList );

        // locate node to move
        $nodeToDelete = $this->getNodeById( $id );

        // Remove the ID on all children by hand as this would crash in PHP <= 5.2.3
        $nodeToDelete->removeAttribute( "id" );

        $children = $nodeToDelete->getElementsByTagName( 'node' );
        foreach ( $children as $child )
        {
            $child->removeAttribute( "id" );
        }

        // Use the parent to remove the child
        $nodeToDelete->parentNode->removeChild( $nodeToDelete );

        if ( !$this->inTransactionCommit )
        {
            $this->saveFile();
        }
    }

    /**
     * Moves the node with ID $id as child to the node with ID $targetParentId
     *
     * @param string $id
     * @param string $targetParentId
     */
    public function move( $id, $targetParentId )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::MOVE, null, $id, $targetParentId ) );
            return;
        }

        // locate node to move
        $nodeToMove = $this->getNodeById( $id );

        // locate new parent
        $parent = $this->getNodeById( $targetParentId );

        $parent->appendChild( $nodeToMove );

        if ( !$this->inTransactionCommit )
        {
            $this->saveFile();
        }
    }

    public function fixateTransaction()
    {
        $this->saveFile();
    }
}
?>
