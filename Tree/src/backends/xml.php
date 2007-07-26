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
class ezcTreeXml extends ezcTree implements ezcTreeBackend
{
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

    private $dom;

    private $xmlFile;

    /**
     * Constructs a new ezcTreeXml object
     */
    public function __construct( $xmlFile, ezcTreeXmlDataStore $store )
    {
        parent::__construct();
        $dom = new DomDocument();
        $dom->load( $xmlFile );
        $dom->relaxNGValidateSource( self::relaxNG );

        $store->setDomTree( $dom );

        $this->dom = $dom;
        $this->xmlFile = $xmlFile;
        $this->properties['store'] = $store;
    }

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

    private function saveFile()
    {
        $this->dom->save( $this->xmlFile );
    }

    public function nodeExists( $id )
    {
        $elem = $this->dom->getElementById( "id$id" );
        return ( $elem !== NULL ) ? true : false;
    }

    private function getNodeById( $id )
    {
        $node = $this->dom->getElementById( "id$id" );
        if ( !$node )
        {
            throw new ezcTreeInvalidIdException( $id );
        }
        return $node;
    }

    public function fetchChildren( $id )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        foreach ( $this->fetchChildRecords( $id ) as $record )
        {
            $list->addNode( new $className( $this, $record['id'] ) );
        }
        return $list;
    }

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


    private function fetchChildRecords( $nodeId )
    {
        $childNodes = array();
        $elem = $this->getNodeById( $nodeId );
        $children = $elem->childNodes;
        foreach ( $children as $child )
        {
            if ( $child->nodeType === XML_ELEMENT_NODE && $child->tagName == "node" )
            {
                $id = $child->getAttribute( 'id' );
                $childNodes[] = array( 'id' => substr( $id, 2 ) );
            }
        }
        return $childNodes;
    }

    private function addChildNodes( $list, $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        foreach ( $this->fetchChildRecords( $nodeId ) as $record )
        {
            $list->addNode( new $className( $this, $record['id'] ) );
            $this->addChildNodes( $list, $record['id'] );
        }
    }

    public function fetchSubtree( $nodeId )
    {
        return $this->fetchSubtreeDepthFirst( $nodeId );
    }

    public function fetchSubtreeBreadthFirst( $nodeId )
    {
    }

    public function fetchSubtreeDepthFirst( $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $nodeId ) );
        $this->addChildNodes( $list, $nodeId );
        return $list;
    }

    public function fetchSubtreeTopological( $nodeId )
    {
    }



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

    private function countChildNodes( &$count, $nodeId )
    {
        foreach ( $this->fetchChildRecords( $nodeId ) as $record )
        {
            $count++;
            $this->countChildNodes( $count, $record['id'] );
        }
    }

    public function getChildCountRecursive( $id )
    {
        $count = 0;
        $this->countChildNodes( $count, $id );
        return $count;
    }

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

    public function isSiblingOf( $child1Id, $child2Id )
    {
        $elem1 = $this->getNodeById( $child1Id );
        $elem2 = $this->getNodeById( $child2Id );
        return (
            ( $child1Id !== $child2Id ) && 
            ( $elem1->parentNode->getAttribute( 'id' ) === $elem2->parentNode->getAttribute( 'id' ) )
        );
    }

    public function setRootNode( ezcTreeNode $node )
    {
        $document = $this->dom->documentElement;

        // remove old root node(s)
        foreach ( $document->childNodes as $child )
        {
            echo $child->tagName, "\n";
        }

        // Create new root node
        $root = $this->dom->createElement( 'node' );
        $root->setAttributeNode( new DOMAttr( 'id', "id{$node->id}" ) );
        $root->setIdAttribute( 'id', true );
        $document->appendChild( $root );
        $this->store->storeDataForNode( $node, $node->data );
        $this->saveFile();
    }

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

    public function delete( $id )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::DELETE, null, $id ) );
            return;
        }

        // locate node to move
        $nodeToDelete = $this->getNodeById( $id );

        // Use the parent to remove the child
        $nodeToDelete->parentNode->removeChild( $nodeToDelete );

        if ( !$this->inTransactionCommit )
        {
            $this->saveFile();
        }
    }

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
