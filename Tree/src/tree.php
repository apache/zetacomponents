<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTree is an abstract class from which all the tree implementations
 * inherit.
 *
 * @property-read ezcTreeXmlDataStore $store
 *                The data store that is used for retrieving/storing data.
 * @property      bool                $prefetch
 *                Whether data pre-fetching is enabled.
 * @property      string              $nodeClassName
 *                Which class is used as tree node - this class *must* inherit
 *                the ezcTreeNode class.
 *
 * @package Tree
 * @version //autogentag//
 */
abstract class ezcTree implements ezcTreeVisitable
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array( 'prefetch' => false, 'nodeClassName' => 'ezcTreeNode' );

    /**
     * Contains whether a transaction has been started.
     *
     * @var bool
     */
    protected $inTransaction = false;

    /**
     * Contains whether we are in a transaction commit stage.
     *
     * @var bool
     */
    protected $inTransactionCommit = false;

    /**
     * Contains a list of transaction items.
     *
     * @var array(ezcTreeTransactionItem)
     */
    private $transactionList = array();

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'store':
            case 'nodeClassName':
            case 'prefetch':
                return $this->properties[$name];
        }
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @throws ezcBasePropertyPermissionException if a read-only property is
     *         tried to be modified.
     * @throws ezcBaseValueException if a the value for a property is out of
     *         range.
     * @throws ezcBaseInvalidParentClassException
     *         if the class name passed as replacement for the ezcTreeNode
     *         classs does not inherit from the ezcTreeNode class.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'store':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );

            case 'nodeClassName':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string that contains a class name' );
                }

                // Check if the passed classname actually implements the
                // correct parent class. We have to do that with reflection
                // here unfortunately
                $parentClass = new ReflectionClass( 'ezcTreeNode' );
                $handlerClass = new ReflectionClass( $value );
                if ( 'ezcTreeNode' !== $value && !$handlerClass->isSubclassOf( $parentClass ) )
                {
                    throw new ezcBaseInvalidParentClassException( 'ezcTreeNode', $value );
                }
                $this->properties[$name] = $value;
                break;

            case 'prefetch':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'boolean' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Creates a new tree node with node ID $id and $data
     *
     * This method returns by default an object of the ezcTreeNode class, 
     * however if a replacement is configured through the nodeClassName property
     * an object of that class is returned instead. This object is guaranteed
     * to inherit from ezcTreeNode.
     *
     * @param string $id
     * @param mixed  $data
     * @return instanceof(ezcTreeNode)
     */
    public function createNode( $id, $data )
    {
        $className = $this->properties['nodeClassName'];
        return new $className( $this, $id, $data );
    }

    /**
     * Implements the accept method for visitation
     *
     * @param ezcTreeVisitor $visitor
     */
    public function accept( ezcTreeVisitor $visitor )
    {
        $visitor->visit( $this );
        $this->getRootNode()->accept( $visitor );
    }

    /**
     * Returns whether the node with ID $id exists
     *
     * @param string $id
     * @return bool
     */
    abstract public function nodeExists( $id );

    /**
     * Returns the node identified by the ID $id
     *
     * @param string $id
     * @throws ezcTreeInvalidIdException if there is no node with ID $id
     * @return ezcTreeNode
     */
    public function fetchNodeById( $id )
    {
        if ( !$this->nodeExists( $id ) )
        {
            throw new ezcTreeInvalidIdException( $id );
        }
        $className = $this->properties['nodeClassName'];
        $node = new $className( $this, $id );

        // Obtain data from the store if prefetch is enabled
        if ( $this->prefetch )
        {
            $this->properties['store']->fetchDataForNode( $node );
        }
        return $node;
    }

    /**
     * Returns all the children of the node with ID $id.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    abstract public function fetchChildren( $id );

    /**
     * Returns the parent node of the node with ID $id.
     *
     * @param string $id
     * @return ezcTreeNode
     */
    abstract public function fetchParent( $id );

    /**
     * Returns all the nodes in the path from the root node to the node with ID
     * $id, including those two nodes.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    abstract public function fetchPath( $id );

    /**
     * Alias for fetchSubtreeDepthFirst().
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    abstract public function fetchSubtree( $id );

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Breadth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    abstract public function fetchSubtreeBreadthFirst( $id );

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Depth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    abstract public function fetchSubtreeDepthFirst( $id );

    /**
     * Returns the number of direct children of the node with ID $id
     *
     * @param string $id
     * @return int
     */
    abstract public function getChildCount( $id );

    /**
     * Returns the number of children of the node with ID $id, recursively
     *
     * @param string $id
     * @return int
     */
    abstract public function getChildCountRecursive( $id );

    /**
     * Returns the distance from the root node to the node with ID $id
     *
     * @param string $id
     * @return int
     */
    abstract public function getPathLength( $id );

    /**
     * Returns whether the node with ID $id has children
     *
     * @param string $id
     * @return bool
     */
    abstract public function hasChildNodes( $id );

    /**
     * Returns whether the node with ID $childId is a direct child of the node
     * with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    abstract public function isChildOf( $childId, $parentId );

    /**
     * Returns whether the node with ID $childId is a direct or indirect child
     * of the node with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    abstract public function isDecendantOf( $childId, $parentId );

    /**
     * Returns whether the nodes with IDs $child1Id and $child2Id are siblings
     * (ie, the share the same parent)
     *
     * @param string $child1Id
     * @param string $child2Id
     * @return bool
     */
    abstract public function isSiblingOf( $child1Id, $child2Id );

    /**
     * Sets a new node as root node, this wipes also out the whole tree
     *
     * @param ezcTreeNode $node
     */
    abstract public function setRootNode( ezcTreeNode $node );

    /**
     * Returns the root node
     *
     * @return ezcTreenode
     */
    abstract public function getRootNode();

    /**
     * Adds the node $childNode as child of the node with ID $parentId
     *
     * @param string $parentId
     * @paran ezcTreeNode $childNode
     */
    abstract public function addChild( $parentId, ezcTreeNode $childNode );

    /**
     * Deletes the node with ID $id from the tree, including all its children
     *
     * @param string $id
     */
    abstract public function delete( $id );

    /**
     * Moves the node with ID $id as child to the node with ID $targetParentId
     *
     * @param string $id
     * @param string $targetParentId
     */
    abstract public function move( $id, $targetParentId );

    /**
     * Starts an transaction in which all tree modifications are queued until 
     * the transaction is committed with the commit() method.
     */
    public function beginTransaction()
    {
        if ( $this->inTransaction )
        {
            throw new ezcTreeTransactionAlreadyStartedException;
        }
        $this->inTransaction = true;
        $this->transactionList = array();
    }

    /**
     * Commits the transaction by running the stored instructions to modify
     * the tree structure.
     */
    public function commit()
    {
        if ( !$this->inTransaction )
        {
            throw new ezcTreeTransactionNotStartedException;
        }
        $this->inTransaction = false;
        $this->inTransactionCommit = true;
        foreach ( $this->transactionList as $transactionItem )
        {
            switch ( $transactionItem->type )
            {
                case ezcTreeTransactionItem::ADD:
                    $this->addChild( $transactionItem->parentId, $transactionItem->node );
                    break;

                case ezcTreeTransactionItem::DELETE:
                    $this->delete( $transactionItem->nodeId );
                    break;

                case ezcTreeTransactionItem::MOVE:
                    $this->move( $transactionItem->nodeId, $transactionItem->parentId );
                    break;
            }
        }
        $this->inTransactionCommit = false;
        $this->fixateTransaction();
    }

    /**
     * Adds a new transaction item to the list
     *
     * @param ezcTreeTransactionItem $item
     */
    protected function addTransactionItem( ezcTreeTransactionItem $item )
    {
        $this->transactionList[] = $item;
    }

    /**
     * Rolls back the transaction by clearing all stored instructions.
     */
    public function rollback()
    {
        if ( !$this->inTransaction )
        {
            throw new ezcTreeTransactionNotStartedException;
        }
        $this->inTransaction = false;
        $this->transactionList = array();
    }
}
?>
