<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeNode represents a node in a tree.
 *
 * The methods that operate on nodes (fetchChildren, fetchPath, ...,
 * isSiblingOf) are all marshalled to calls on the tree (that is stored in the
 * $tree private variable) itself.
 *
 * @property-read string $id          The ID that uniquely identifies a node
 * @property      mixed  $data        The data belonging to a node
 * @property-read bool   $dataFetched Whether the data for this node has been
 *                                    fetched.
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeNode
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Holds a link to the tree that this node is part of
     *
     * @var ezcTree
     */
    private $tree;

    /**
     * Constructs a new ezcTreeNode object with ID $id on tree $tree
     *
     * @param ezcTree $tree
     * @param string  $id
     * @param mixed   $data
     */
    public function __construct( ezcTree $tree, $id )
    {
        $this->tree = $tree;
        $this->properties['id'] = (string) $id;

        if ( func_num_args() === 2 )
        {
            $this->properties['data'] = null;
            $this->properties['dataFetched'] = false;

            if ( $tree->prefetch )
            {
                $tree->store->fetchDataForNode( $this );
            }
        }
        else
        {
            $this->properties['data'] = func_get_arg( 2 );
            $this->properties['dataFetched'] = true;
        }
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'data':
                if ( $this->properties['dataFetched'] === false )
                {
                    // fetch the data on the fly
                    $this->tree->store->fetchDataForNode( $this );
                }
                // break intentionally missing
            case 'id':
            case 'dataFetched':
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
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'id':
            case 'dataFetched':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );

            case 'data':
                $this->properties[$name] = $value;
                $this->properties['dataFetched'] = true;
                return;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Adds the node $node as child of the current node to the tree
     *
     * @param ezcTreeNode $node
     */
    public function addChild( ezcTreeNode $node )
    {
        $this->tree->addChild( $this->id, $node );
    }

    /**
     * Returns all the children of this node
     *
     * @return ezcTreeNodeList
     */
    public function fetchChildren()
    {
        return $this->tree->fetchChildren( $this->id );
    }

    /**
     * Returns all the nodes in the path from the root node to this node
     *
     * @return ezcTreeNodeList
     */
    public function fetchPath()
    {
        return $this->tree->fetchPath( $this->id );
    }

    /**
	 * Alias for fetchSubtreeDepthFirst().
     *
     * @see fetchSubtreeDepthFirst
     * @return ezcTreeNodeList
     */
    public function fetchSubtree()
    {
        return $this->fetchSubtreeDepthFirst();
    }

    /**
     * Returns this node and all its children, sorted accoring to the
     * Breadth-first sorting algorithm.
     *
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeBreadthFirst()
    {
        return $this->tree->fetchSubtreeBreadthFirst( $this->id );
    }

    /**
     * Returns this node and all its children, sorted accoring to the
     * Depth-first sorting algorithm.
     *
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeDepthFirst()
    {
        return $this->tree->fetchSubtreeDepthFirst( $this->id );
    }

    /**
     * Returns this node and all its children, sorted accoring to the
     * Toplological sorting algorithm.
     *
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeTopological()
    {
        return $this->tree->fetchSubtreeTopological( $this->id );
    }

    /**
     * Returns the number of direct children of this node
     *
     * @return int
     */
    public function getChildCount()
    {
        return $this->tree->getChildCount( $this->id );
    }

    /**
     * Returns the number of children of this node, recursively iterating over
     * the children
     *
     * @return int
     */
    public function getChildCountRecursive()
    {
        return $this->tree->getChildCountRecursive( $this->id );
    }

    /**
     * Returns the distance from the root node to this node
     *
     * @return int
     */
    public function getPathLength()
    {
        return $this->tree->getPathlength( $this->id );
    }

    /**
     * Returns whether this node has children
     *
     * @return bool
     */
    public function hasChildNodes()
    {
        return $this->tree->hasChildNodes( $this->id );
    }

    /**
     * Returns whether this node is a direct child of the $parentNode node
     *
     * @return bool
     */
    public function isChildOf( ezcTreeNode $parentNode )
    {
        return $this->tree->isChildOf( $this->id, $parentNode->id );
    }

    /**
     * Returns whether this node is a direct or indirect child of the
     * $parentNode node
     *
     * @return bool
     */
    public function isDecendantOf( ezcTreeNode $parentNode )
    {
        return $this->tree->isDecendantOf( $this->id, $parentNode->id );
    }

    /**
     * Returns whether this node, and the $child2Node node are are siblings
     * (ie, the share the same parent)
     *
     * @return bool
     */
    public function isSiblingOf( ezcTreeNode $child2Node )
    {
        return $this->tree->isSiblingOf( $this->id, $child2Node->id );
    }
}
?>
