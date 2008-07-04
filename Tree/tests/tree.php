<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 * @subpackage Tests
 */

/**
 * Require the test classes file
 */
require_once 'files/test_classes.php';

/**
 * @package Tree
 * @subpackage Tests
 */
abstract class ezcTreeTest extends ezcTestCase
{
    public function testGetRootNode1()
    {
        $tree = $this->setUpTestTree();

        $node = $tree->getRootNode();
        self::assertType( 'ezcTreeNode', $node );
        self::assertSame( '1', $node->id );
        self::assertSame( 'Node 1', $node->data );
    }

    public function testGetRootNode2()
    {
        $tree = $this->setUpEmptyTestTree();
        $node = $tree->getRootNode();
        self::assertSame( null, $node );
    }

    public function testTreeFetchById()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->nodeExists( '1' ) );

        $node8 = $tree->fetchNodeById( 8 ); // returns 8
        self::assertType( 'ezcTreeNode', $node8 );
        self::assertSame( '8', $node8->id );
        self::assertSame( 'Node 8', $node8->data );

        $node3 = $tree->fetchNodeById( '3' ); // returns 3
        self::assertType( 'ezcTreeNode', $node3 );
        self::assertSame( '3', $node3->id );
        self::assertSame( 'Node 3', $node3->data );
    }

    public function testGetUnknownProperty()
    {
        $tree = $this->setUpTestTree();

        try
        {
            $dummy = $tree->unknown;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testIssetStore()
    {
        $tree = $this->setUpTestTree();
        self::assertSame( true, isset( $tree->store ) ); 
    }

    public function testSetStore()
    {
        $tree = $this->setUpTestTree();

        try
        {
            $tree->store = new TestTranslateDataStore;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            self::assertSame( "The property 'store' is read-only.", $e->getMessage() );
        }
    }

    public function testSetAutoId()
    {
        $tree = $this->setUpTestTree();

        $tree->autoId = false;
        self::assertSame( false, $tree->autoId );
        $tree->autoId = true;
        self::assertSame( true, $tree->autoId );

        try
        {
            $tree->autoId = "foobar";
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value 'foobar' that you were trying to assign to setting 'autoId' is invalid. Allowed values are: boolean.", $e->getMessage() );
        }
    }

    public function testIssetNodeClassName()
    {
        $tree = $this->setUpTestTree();
        self::assertSame( true, isset( $tree->nodeClassName ) ); 
    }

    public function testSetNodeClassName()
    {
        $tree = $this->setUpTestTree();
        
        $tree->nodeClassName = 'TestExtendedTreeNode';
        self::assertSame( 'TestExtendedTreeNode', $tree->nodeClassName );
    }

    public function testSetNodeClassNameWrongValue1()
    {
        $tree = $this->setUpTestTree();
        
        try
        {
            $tree->nodeClassName = 42;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'nodeClassName' is invalid. Allowed values are: string that contains a class name.", $e->getMessage() );
        }
    }

    public function testSetNodeClassNameWrongValue2()
    {
        $tree = $this->setUpTestTree();
        
        try
        {
            $tree->nodeClassName = 'ezcTreeMemoryNode';
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBaseInvalidParentClassException $e )
        {
            self::assertSame( "Class 'ezcTreeMemoryNode' does not exist, or does not inherit from the 'ezcTreeNode' class.", $e->getMessage() );
        }
    }

    public function testIssetUnknownProperty()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( false, isset( $tree->unknown ) );
    }

    public function testSetUnknownProperty()
    {
        $tree = $this->setUpTestTree();

        try
        {
            $tree->unknown = 'whatever';
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testTreeFetchByUnknownId()
    {
        $tree = $this->setUpTestTree();

        try
        {
            $node = $tree->fetchNodeById( 42 );
            self::fail( "Expected exception was not thrown." );
        }
        catch ( ezcTreeUnknownIdException $e )
        {
            self::assertSame( "The node with ID '42' could not be found.", $e->getMessage() );
        }
    }

    public function testTreeIsChildOfOnNode()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->fetchNodeById( 2 )->isChildOf( $tree->fetchNodeById( 1 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 6 )->isChildOf( $tree->fetchNodeById( 2 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 8 )->isChildOf( $tree->fetchNodeById( 2 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 6 )->isChildOf( $tree->fetchNodeById( 4 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 7 )->isChildOf( $tree->fetchNodeById( 6 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 8 )->isChildOf( $tree->fetchNodeById( 6 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 7 )->isChildOf( $tree->fetchNodeById( 7 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 7 )->isChildOf( $tree->fetchNodeById( 8 ) ) );
    }

    public function testTreeIsChildOfOnNodeWithInvalidNodes()
    {
        $tree = $this->setUpTestTree();

        try
        {
            self::assertSame( true, $tree->fetchNodeById( 98 )->isChildOf( $tree->fetchNodeById( 99 ) ) );
        }
        catch ( ezcTreeUnknownIdException $e )
        {
            self::assertSame( "The node with ID '98' could not be found.", $e->getMessage() );
        }
    }

    public function testTreeIsChildOfOnTree()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->isChildOf( 2, 1 ) );
        self::assertSame( false, $tree->isChildOf( 6, 2 ) );
        self::assertSame( false, $tree->isChildOf( 8, 2 ) );
        self::assertSame( true, $tree->isChildOf( 6, 4 ) );
        self::assertSame( true, $tree->isChildOf( 7, 6 ) );
        self::assertSame( true, $tree->isChildOf( 8, 6 ) );
        self::assertSame( false, $tree->isChildOf( 7, 7 ) );
        self::assertSame( false, $tree->isChildOf( 7, 8 ) );
    }

    public function testTreeIsChildOfOnTreeWithInvalidNodes()
    {
        $tree = $this->setUpTestTree();

        try
        {
            self::assertSame( false, $tree->isChildOf( 98, 99 ) );
        }
        catch ( ezcTreeUnknownIdException $e )
        {
            self::assertSame( "The node with ID '98' could not be found.", $e->getMessage() );
        }
    }

    public function testTreeIsDecendantOfOnNode()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->fetchNodeById( 2 )->isDescendantOf( $tree->fetchNodeById( 1 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 6 )->isDescendantOf( $tree->fetchNodeById( 2 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 8 )->isDescendantOf( $tree->fetchNodeById( 2 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 8 )->isDescendantOf( $tree->fetchNodeById( 4 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 6 )->isDescendantOf( $tree->fetchNodeById( 4 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 7 )->isDescendantOf( $tree->fetchNodeById( 6 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 8 )->isDescendantOf( $tree->fetchNodeById( 6 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 7 )->isDescendantOf( $tree->fetchNodeById( 7 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 7 )->isDescendantOf( $tree->fetchNodeById( 8 ) ) );
    }

    public function testTreeIsDecendantOfOnTree()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->isDescendantOf( 2, 1 ) );
        self::assertSame( false, $tree->isDescendantOf( 6, 2 ) );
        self::assertSame( false, $tree->isDescendantOf( 8, 2 ) );
        self::assertSame( true, $tree->isDescendantOf( 6, 4 ) );
        self::assertSame( true, $tree->isDescendantOf( 8, 4 ) );
        self::assertSame( true, $tree->isDescendantOf( 7, 6 ) );
        self::assertSame( true, $tree->isDescendantOf( 8, 6 ) );
        self::assertSame( false, $tree->isDescendantOf( 7, 7 ) );
        self::assertSame( false, $tree->isDescendantOf( 7, 8 ) );
    }

    public function testTreeIsSiblingOfOnNode()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( false, $tree->fetchNodeById( 2 )->isSiblingOf( $tree->fetchNodeById( 1 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 6 )->isSiblingOf( $tree->fetchNodeById( 2 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 8 )->isSiblingOf( $tree->fetchNodeById( 2 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 4 )->isSiblingOf( $tree->fetchNodeById( 3 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 6 )->isSiblingOf( $tree->fetchNodeById( 4 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 7 )->isSiblingOf( $tree->fetchNodeById( 6 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 8 )->isSiblingOf( $tree->fetchNodeById( 6 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 7 )->isSiblingOf( $tree->fetchNodeById( 7 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 7 )->isSiblingOf( $tree->fetchNodeById( 8 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 6 )->isSiblingOf( $tree->fetchNodeById( 9 ) ) );
    }

    public function testTreeIsSiblingOfOnTree()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( false, $tree->isSiblingOf( 2, 1 ) );
        self::assertSame( false, $tree->isSiblingOf( 6, 2 ) );
        self::assertSame( false, $tree->isSiblingOf( 8, 2 ) );
        self::assertSame( true, $tree->isSiblingOf( 4, 3 ) );
        self::assertSame( false, $tree->isSiblingOf( 6, 4 ) );
        self::assertSame( false, $tree->isSiblingOf( 7, 6 ) );
        self::assertSame( false, $tree->isSiblingOf( 8, 6 ) );
        self::assertSame( false, $tree->isSiblingOf( 7, 7 ) );
        self::assertSame( true, $tree->isSiblingOf( 7, 8 ) );
        self::assertSame( false, $tree->isSiblingOf( 6, 9 ) );
    }

    public function testTreeHasChildrenOnNode()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->fetchNodeById( 1 )->hasChildNodes() );
        self::assertSame( false, $tree->fetchNodeById( 3 )->hasChildNodes() );
        self::assertSame( true, $tree->fetchNodeById( 4 )->hasChildNodes() );
        self::assertSame( false, $tree->fetchNodeById( 7 )->hasChildNodes() );
    }

    public function testTreeHasChildrenOnTree()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->hasChildNodes( 1 ) );
        self::assertSame( false, $tree->hasChildNodes( 3 ) );
        self::assertSame( true, $tree->hasChildNodes( 4 ) );
        self::assertSame( false, $tree->hasChildNodes( 7 ) );
    }

    public function testTreeGetChildCountOnNode()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( 4, $tree->fetchNodeById( 1 )->getChildCount() );
        self::assertSame( 0, $tree->fetchNodeById( 3 )->getChildCount() );
        self::assertSame( 1, $tree->fetchNodeById( 4 )->getChildCount() );
        self::assertSame( 0, $tree->fetchNodeById( 7 )->getChildCount() );
    }

    public function testTreeGetChildCountOnTree()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( 4, $tree->getChildCount( 1 ) );
        self::assertSame( 0, $tree->getChildCount( 3 ) );
        self::assertSame( 1, $tree->getChildCount( 4 ) );
        self::assertSame( 0, $tree->getChildCount( 7 ) );
    }

    public function testTreeGetChildCountRecursiveOnNode()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( 8, $tree->fetchNodeById( 1 )->getChildCountRecursive() );
        self::assertSame( 0, $tree->fetchNodeById( 3 )->getChildCountRecursive() );
        self::assertSame( 3, $tree->fetchNodeById( 4 )->getChildCountRecursive() );
        self::assertSame( 0, $tree->fetchNodeById( 7 )->getChildCountRecursive() );
    }

    public function testTreeGetChildCountRecursiveOnTree()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( 8, $tree->getChildCountRecursive( 1 ) );
        self::assertSame( 0, $tree->getChildCountRecursive( 3 ) );
        self::assertSame( 3, $tree->getChildCountRecursive( 4 ) );
        self::assertSame( 0, $tree->getChildCountRecursive( 7 ) );
    }

    public function testTreeGetPathLengthOnNode()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( 0, $tree->fetchNodeById( 1 )->getPathLength() );
        self::assertSame( 1, $tree->fetchNodeById( 2 )->getPathLength() );
        self::assertSame( 1, $tree->fetchNodeById( 4 )->getPathLength() );
        self::assertSame( 2, $tree->fetchNodeById( 6 )->getPathLength() );
        self::assertSame( 3, $tree->fetchNodeById( 7 )->getPathLength() );
    }

    public function testTreeGetPathLengthOnTree()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( 0, $tree->getPathLength( 1 ) );
        self::assertSame( 1, $tree->getPathLength( 2 ) );
        self::assertSame( 1, $tree->getPathLength( 4 ) );
        self::assertSame( 2, $tree->getPathLength( 6 ) );
        self::assertSame( 3, $tree->getPathLength( 7 ) );
    }

    public function testTreeFetchSubtreeOnNode()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchNodeById( 4 )->fetchSubtree();
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '7', $nodeList[7]->id );
        self::assertSame( '8', $nodeList[8]->id );
    }

    public function testTreeFetchSubtreeOnTree()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchSubtree( 4 );
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '7', $nodeList[7]->id );
        self::assertSame( '8', $nodeList[8]->id );
    }

    public function testTreeFetchSubtreeBreadthFirstOnNode()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchNodeById( 4 )->fetchSubtreeBreadthFirst();
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '7', $nodeList[7]->id );
        self::assertSame( '8', $nodeList[8]->id );
    }

    public function testTreeFetchSubtreeBreadthFirstOnTree()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchSubtreeBreadthFirst( 4 );
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '7', $nodeList[7]->id );
        self::assertSame( '8', $nodeList[8]->id );
    }

    public function testTreeFetchSubtreeDepthFirstOnNode()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchNodeById( 4 )->fetchSubtreeDepthFirst();
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '7', $nodeList[7]->id );
        self::assertSame( '8', $nodeList[8]->id );
    }

    public function testTreeFetchSubtreeDepthFirstOnTree()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchSubtreeDepthFirst( 4 );
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '7', $nodeList[7]->id );
        self::assertSame( '8', $nodeList[8]->id );
    }

    public function testTreeFetchChildrenOnNode()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchNodeById( 3 )->fetchChildren();
        self::assertSame( 0, $nodeList->size );

        $nodeList = $tree->fetchNodeById( 4 )->fetchChildren();
        self::assertSame( 1, $nodeList->size );
        self::assertSame( '6', $nodeList['6']->id );

        $nodeList = $tree->fetchNodeById( '6' )->fetchChildren();
        self::assertSame( 2, $nodeList->size );
        self::assertSame( '7', $nodeList['7']->id );
        self::assertSame( '8', $nodeList['8']->id );
    }

    public function testTreeFetchChildrenOnTree()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchChildren( 3 );
        self::assertSame( 0, $nodeList->size );

        $nodeList = $tree->fetchChildren( 4 );
        self::assertSame( 1, $nodeList->size );
        self::assertSame( '6', $nodeList['6']->id );

        $nodeList = $tree->fetchChildren( '6' );
        self::assertSame( 2, $nodeList->size );
        self::assertSame( '7', $nodeList['7']->id );
        self::assertSame( '8', $nodeList['8']->id );
    }

    public function testTreeFetchParentOnNode()
    {
        $tree = $this->setUpTestTree();

        $node = $tree->fetchParent( '3' );
        self::assertType( 'ezcTreeNode', $node );
        self::assertSame( '1', $node->id );
        self::assertSame( 'Node 1', $node->data );

        $node = $tree->fetchParent( '1' );
        self::assertSame( null, $node );

        $node = $tree->fetchParent( '8' );
        self::assertSame( '6', $node->id );
    }

    public function testTreeFetchParentOnTree()
    {
        $tree = $this->setUpTestTree();
        $node = $tree->fetchNodeById( '3' )->fetchParent();
        self::assertType( 'ezcTreeNode', $node );
        self::assertSame( '1', $node->id );
        self::assertSame( 'Node 1', $node->data );

        $node = $tree->fetchNodeById( '1' )->fetchParent();
        self::assertSame( null, $node );

        $node = $tree->fetchNodeById( '8' )->fetchParent();
        self::assertSame( '6', $node->id );
    }

    public function testTreeFetchPathOnNode()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchNodeById( '1' )->fetchPath();
        self::assertSame( 1, $nodeList->size );
        self::assertSame( '1', $nodeList['1']->id );

        $nodeList = $tree->fetchNodeById( 8 )->fetchPath();
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '1', $nodeList['1']->id );
        self::assertSame( '4', $nodeList['4']->id );
        self::assertSame( '6', $nodeList['6']->id );
        self::assertSame( '8', $nodeList['8']->id );

        self::assertSame( array( 1, 4, 6, 8 ), array_keys( $nodeList->nodes ) );
    }

    public function testTreeFetchPathOnTree()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchPath( '1' );
        self::assertSame( 1, $nodeList->size );
        self::assertSame( '1', $nodeList['1']->id );

        $nodeList = $tree->fetchPath( 8 );
        self::assertSame( 4, $nodeList->size );
        self::assertSame( '1', $nodeList['1']->id );
        self::assertSame( '4', $nodeList['4']->id );
        self::assertSame( '6', $nodeList['6']->id );
        self::assertSame( '8', $nodeList['8']->id );

        self::assertSame( array( 1, 4, 6, 8 ), array_keys( $nodeList->nodes ) );
    }

    public function testTreeMoveNode1()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( false, $tree->fetchNodeById( 4 )->isChildOf( $tree->fetchNodeById( 5 ) ) );

        $tree->move( '4', '5' ); // makes node 4 a child of node 5
        self::assertSame( true, $tree->isChildOf( 4, 5 ) );

        $nodeList = $tree->fetchNodeById( 8 )->fetchPath();
        self::assertSame( 5, $nodeList->size );
        self::assertSame( '1', $nodeList[1]->id );
        self::assertSame( '5', $nodeList[5]->id );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '8', $nodeList[8]->id );
        self::assertSame( true, $tree->fetchNodeById( 4 )->isSiblingOf( $tree->fetchNodeById( 9 ) ) );
    }

    public function testTreeMoveNode2()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( false, $tree->fetchNodeById( 4 )->isChildOf( $tree->fetchNodeById( 5 ) ) );

        $tree->move( '4', '9' ); // makes node 4 a child of node 5
        self::assertSame( true, $tree->isChildOf( 4, 9 ) );

        $nodeList = $tree->fetchNodeById( 8 )->fetchPath();
        self::assertSame( 6, $nodeList->size );
        self::assertSame( '1', $nodeList[1]->id );
        self::assertSame( '5', $nodeList[5]->id );
        self::assertSame( '9', $nodeList[9]->id );
        self::assertSame( '4', $nodeList[4]->id );
        self::assertSame( '6', $nodeList[6]->id );
        self::assertSame( '8', $nodeList[8]->id );
        self::assertSame( false, $tree->fetchNodeById( 4 )->isSiblingOf( $tree->fetchNodeById( 9 ) ) );
    }

    public function testTreeMoveNodeWithTransaction()
    {
        $tree = $this->setUpTestTree();

        $tree->beginTransaction();
        $tree->move( '4', '5' ); // makes node 4 a child of node 5

        self::assertSame( false, $tree->fetchNodeById( 4 )->isChildOf( $tree->fetchNodeById( 5 ) ) );
        self::assertSame( false, $tree->fetchNodeById( 4 )->isSiblingOf( $tree->fetchNodeById( 9 ) ) );

        $tree->commit();

        self::assertSame( true, $tree->fetchNodeById( 4 )->isChildOf( $tree->fetchNodeById( 5 ) ) );
        self::assertSame( true, $tree->fetchNodeById( 4 )->isSiblingOf( $tree->fetchNodeById( 9 ) ) );
    }

    public function testTreeInTransaction()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( false, $tree->inTransaction() );

        $tree->beginTransaction();

        self::assertSame( true, $tree->inTransaction() );
    }

    public function testTreeDeleteNode1()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->nodeExists( 5 ) );
        $tree->delete( '5' );
        self::assertSame( false, $tree->nodeExists( 5 ) );
        self::assertSame( 3, $tree->fetchNodeById( 1 )->getChildCount() );

        self::assertSame( true, $tree->nodeExists( '4' ) );
        self::assertSame( true, $tree->nodeExists( '6' ) );
        self::assertSame( true, $tree->nodeExists( '8' ) );
    }

    public function testTreeDeleteNode2()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->nodeExists( '4' ) );
        $tree->delete( '4' );
        self::assertSame( false, $tree->nodeExists( '4' ) );
        self::assertSame( false, $tree->nodeExists( '6' ) );
        self::assertSame( false, $tree->nodeExists( '7' ) );
        self::assertSame( false, $tree->nodeExists( '8' ) );
        self::assertSame( 3, $tree->fetchNodeById( '1' )->getChildCount() );
    }

    public function testTreeDeleteNodeWithTransaction()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->nodeExists( 5 ) );

        $tree->beginTransaction();
        $tree->delete( '5' );
        $tree->delete( '4' );

        self::assertSame( true, $tree->nodeExists( '4' ) );
        self::assertSame( true, $tree->nodeExists( '6' ) );
        self::assertSame( true, $tree->nodeExists( '8' ) );
        self::assertSame( 4, $tree->getChildCount( '1' ) );

        $tree->commit();

        self::assertSame( false, $tree->nodeExists( '4' ) );
        self::assertSame( false, $tree->nodeExists( '5' ) );
        self::assertSame( false, $tree->nodeExists( '6' ) );
        self::assertSame( false, $tree->nodeExists( '7' ) );
        self::assertSame( false, $tree->nodeExists( '8' ) );
        self::assertSame( 2, $tree->getChildCount( '1' ) );
    }

    public function testTreeDeleteNodeWithTransactionRollback()
    {
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->nodeExists( 5 ) );

        $tree->beginTransaction();
        $tree->delete( '5' );
        $tree->delete( '4' );

        self::assertSame( true, $tree->nodeExists( '4' ) );
        self::assertSame( true, $tree->nodeExists( '6' ) );
        self::assertSame( true, $tree->nodeExists( '8' ) );
        self::assertSame( 4, $tree->getChildCount( '1' ) );

        $tree->rollback();

        self::assertSame( true, $tree->nodeExists( '4' ) );
        self::assertSame( true, $tree->nodeExists( '5' ) );
        self::assertSame( true, $tree->nodeExists( '6' ) );
        self::assertSame( true, $tree->nodeExists( '7' ) );
        self::assertSame( true, $tree->nodeExists( '8' ) );
        self::assertSame( 8, $tree->getChildCountRecursive( '1' ) );
    }

    public function testTreeDeleteNodeAndAddNew()
    {
        $tree = $this->setUpTestTree();

        $tree->delete( '5' );
        self::assertSame( false, $tree->nodeExists( '5' ) );
        self::assertSame( false, $tree->nodeExists( '9' ) );

        $node1  = $tree->fetchNodeById( 1 );
        $cervus = $tree->createNode( 9, 'Cervus' );
        $node1->addChild( $cervus );
    }

    public function testTreeTransactionDoubleStart()
    {
        $tree = $this->setUpTestTree();

        $tree->beginTransaction();
        try
        {
            $tree->beginTransaction();
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcTreeTransactionAlreadyStartedException $e )
        {
            self::assertSame( "A transaction has already been started.", $e->getMessage() );
        }
    }

    public function testTreeTransactionCommitWithoutBegin()
    {
        $tree = $this->setUpTestTree();

        try
        {
            $tree->commit();
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcTreeTransactionNotStartedException $e )
        {
            self::assertSame( "A transaction is not active.", $e->getMessage() );
        }
    }

    public function testTreeTransactionRollbackWithoutBegin()
    {
        $tree = $this->setUpTestTree();

        try
        {
            $tree->rollback();
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcTreeTransactionNotStartedException $e )
        {
            self::assertSame( "A transaction is not active.", $e->getMessage() );
        }
    }

    public function testTreeNodeListIterator()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchNodeById( 4 )->fetchSubtree();
        self::assertSame( 4, $nodeList->size );

        foreach ( new ezcTreeNodeListIterator( $tree, $nodeList ) as $nodeId => $data )
        {
            self::assertSame( "Node $nodeId", $data );
        }
    }

    public function testTreeNodeListIteratorPrefetch()
    {
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchNodeById( 4 )->fetchSubtree();
        self::assertSame( 4, $nodeList->size );
        self::assertSame( 'Node 4', $nodeList['4']->data );

        foreach ( new ezcTreeNodeListIterator( $tree, $nodeList, true ) as $nodeId => $data )
        {
            self::assertSame( "Node $nodeId", $data );
        }
    }

    public function testSetRootNode()
    {
        $tree = $this->setUpTestTree();

        for ( $i = 1; $i < 10; ++$i )
        {
            self::assertSame( true, $tree->nodeExists( $i ) );
        }

        $tree->setRootNode( $root = $tree->createNode( 42, 'New Node' ) );

        for ( $i = 1; $i < 10; ++$i )
        {
            self::assertSame( false, $tree->nodeExists( $i ) );
        }
        self::assertSame( true, $tree->nodeExists( '42' ) );
    }

    public function testMissingDataException()
    {
        // not applicable from memory store as that always has data
        if ( get_class( $this ) !== 'ezcTreeMemoryTest' )
        {
            $tree = $this->setUpTestTree();

            $node = $tree->fetchNodeById( 9 );
            try
            {
                $data = $node->data;
                self::fail( "Expected exception not thrown." );
            }
            catch ( ezcTreeDataStoreMissingDataException $e )
            {
                self::assertSame( "The data store does not have data stored for the node with ID '9'.", $e->getMessage() );
            }
        }
    }

    private function addTestData( $tree )
    {
        $primates = array(
            'Hominoidea' => array(
                'Hylobatidae' => array(
                    'Hylobates' => array(
                        'Lar Gibbon',
                        'Agile Gibbon',
                        'Müller\'s Bornean Gibbon',
                        'Silvery Gibbon',
                        'Pileated Gibbon',
                        'Kloss\'s Gibbon',
                    ),
                    'Hoolock' => array(
                        'Western Hoolock Gibbon',
                        'Eastern Hoolock Gibbon',
                    ),
                    'Symphalangus' => array(),
                    'Nomascus' => array(
                        'Black Crested Gibbon',
                        'Eastern Black Crested Gibbon',
                        'White-cheecked Crested Gibbon',
                        'Yellow-cheecked Gibbon',
                    ),
                ),
                'Hominidae' => array(
                    'Pongo' => array(
                        'Bornean Orangutan',
                        'Sumatran Orangutan',
                    ), 
                    'Gorilla' => array(
                        'Western Gorilla' => array(
                            'Western Lowland Gorilla',
                            'Cross River Gorilla',
                        ),
                        'Eastern Gorilla' => array(
                            'Mountain Gorilla',
                            'Eastern Lowland Gorilla',
                        ),
                    ), 
                    'Homo' => array(
                        'Homo Sapiens' => array(
                            'Homo Sapiens Sapiens',
                            'Homo Superior'
                        ),
                    ),
                    'Pan' => array(
                        'Common Chimpanzee',
                        'Bonobo',
                    ),
                ),
            ),
        );

        $root = $tree->createNode( 'Hominoidea', 'Hominoidea' );
        $tree->setRootNode( $root );

        $this->addChildren( $root, $primates['Hominoidea'] );
    }

    private function addChildren( ezcTreeNode $node, array $children )
    {
        foreach( $children as $name => $child )
        {
            if ( is_array( $child ) )
            {
                $newNode = $node->tree->createNode( $name, $name );
                $node->addChild( $newNode );
                $this->addChildren( $newNode, $child );
            }
            else
            {
                $newNode = $node->tree->createNode( $child, $child );
                $node->addChild( $newNode );
            }
        }
    }

    public function testTreeCreateExtensive()
    {
        $tree = $this->setUpEmptyTestTree();
        self::assertSame( false, $tree->nodeExists( '1' ) );
        $this->addTestData( $tree );

        self::assertSame( true, $tree->nodeExists( 'Homo Sapiens Sapiens' ) );
        self::assertSame( true, $tree->isDescendantOf( 'Common Chimpanzee', 'Hominoidea' ) );
        self::assertSame( 4, $tree->getChildCount( 'Hominidae' ) );
        self::assertSame( 17, $tree->getChildCountRecursive( 'Hominidae' ) );
        self::assertSame( true, $tree->isSiblingOf( 'Gorilla', 'Homo' ) );
    }

    public function testTreeFetchSubtreeDepthFirst()
    {
        $tree = $this->setUpEmptyTestTree();
        $this->addTestData( $tree );

        $expected = array(
            'Gorilla', 'Western Gorilla', 'Western Lowland Gorilla', 
            'Cross River Gorilla', 'Eastern Gorilla', 'Mountain Gorilla', 
            'Eastern Lowland Gorilla' 
        );
        $list = $tree->fetchSubtreeDepthFirst( 'Gorilla' );
        $nodes = $list->nodes;
        self::assertSame( 7, $list->size );
        self::assertSame( 7, count( $nodes ) );

        // test with fetched nodes as base
        reset( $expected );
        foreach ( $nodes as $key => $item )
        {
            self::assertSame( current( $expected ), $key );
            next( $expected );
        }

        // test with expected array as base
        reset( $nodes );
        foreach( $expected as $key )
        {
            self::assertType( 'ezcTreeNode', current( $nodes ) );
            self::assertSame( current( $nodes )->id, $key );
            next( $nodes );
        }
    }

    public function testTreeFetchSubtreeBreadthFirst()
    {
        $tree = $this->setUpEmptyTestTree();
        $this->addTestData( $tree );

        $expected = array( 
            'Gorilla', 'Western Gorilla', 'Eastern Gorilla', 
            'Western Lowland Gorilla', 'Cross River Gorilla', 
            'Mountain Gorilla', 'Eastern Lowland Gorilla'
        );
        $list = $tree->fetchSubtreeBreadthFirst( 'Gorilla' );
        $nodes = $list->nodes;
        self::assertSame( 7, $list->size );
        self::assertSame( 7, count( $nodes ) );

        // test with fetched nodes as base
        reset( $expected );
        foreach ( $nodes as $key => $item )
        {
            self::assertSame( current( $expected ), $key );
            next( $expected );
        }

        // test with expected array as base
        reset( $nodes );
        foreach( $expected as $key )
        {
            self::assertType( 'ezcTreeNode', current( $nodes ) );
            self::assertSame( current( $nodes )->id, $key );
            next( $nodes );
        }
    }

    public function testTreeNullIdWithoutAutogen()
    {
        $tree = $this->setUpEmptyTestTree();
        try
        {
            $root = $tree->createNode( null, 'Hominoidea' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcTreeInvalidIdException $e )
        {
            self::assertSame( "The node ID '' contains the invalid character ''.", $e->getMessage() );
        }
    }

    public function testTreeNullIdWithAutogen()
    {
        $tree = $this->setUpEmptyTestTree( 'data', 'data', '_auto' );
        $tree->autoId = true;
        $root = $tree->createNode( null, 'Paenungulata' );
        self::assertSame( "1", $root->id );
        $tree->setRootNode( $root );

        $newNode = $tree->createNode( null, 'Hyracoidea' );
        $root->addChild( $newNode );
        self::assertSame( "2", $newNode->id );

        $newNode = $tree->createNode( null, 'Proboscidea' );
        $root->addChild( $newNode );
        self::assertSame( "3", $newNode->id );
    }

    public function testTreeNullIdWithAutogenWithReload()
    {
        $tree = $this->setUpEmptyTestTree( 'data', 'data', '_auto' );
        $tree->autoId = true;
        $root = $tree->createNode( null, 'Paenungulata' );
        $tree->setRootNode( $root );

        $newNode = $tree->createNode( null, 'Hyracoidea' );
        $root->addChild( $newNode );

        $newNode = $tree->createNode( null, 'Proboscidea' );
        $root->addChild( $newNode );
        self::assertSame( "3", $newNode->id );

        // start over
        $tree = $this->setUpTestTree( 'data', 'data', '_auto' );
        $tree->autoId = true;

        // fetch a node
        $node = $tree->fetchNodeById( 3 );
    }

}

?>
