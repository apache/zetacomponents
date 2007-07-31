<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeNodeListIterator implements an iterator over a ezcTreeNodeList
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeNodeListIterator implements Iterator
{
    /**
     * Holds the nodes of this list.
     *
     * @var array(ezcTreeNode)
     */
    private $nodeList;

    /**
     * Holds a link to the tree that contains the nodes that are iterated over.
     *
     * This is used for accessing the data store so that data can be fetched
     * on-demand.
     *
     * @var ezcTree
     */
    private $tree;

    /**
     * Constructs a new ezcTreeNodeListIterator object over $nodeList
     *
     * The $tree argument is used so that data can be fetched on-demand.
     *
     * @param ezcTree         $tree
     * @param ezcTreeNodeList $nodeList
     */
    public function __construct( ezcTree $tree, ezcTreeNodeList $nodeList )
    {
        $this->tree = $tree;
        if ( $tree->prefetch )
        {
            $this->tree->store->fetchDataForNodes( $nodeList );
        }
        $this->nodeList = $nodeList->getNodes();
    }

    /**
     * Rewinds the internal pointer back to the start of the nodelist
     */
    public function rewind()
    {
        reset( $this->nodeList );
        if ( count( $this->nodeList ) )
        {
            $this->valid = true;
        }
        else 
        {
            $this->valid = false;
        }
    }

    /**
     * Returns the node ID of the current node.
     *
     * @return string
     */
    public function key()
    {
        return key( $this->nodeList );
    }

    /**
     * Returns the data belonging to the current node, and fetches the data in
     * case on-demand fetching is required.
     *
     * @return mixed
     */
    public function current()
    {
        $node = current( $this->nodeList );
        return $node->data;
    }

    /**
     * Advances the internal pointer to the next node in the nodelist
     */
    public function next()
    {
        $nextElem = next( $this->nodeList );
        if ( $nextElem === false )
        {
            $this->valid = false;
        }
    }

    /**
     * Returns whether the internal pointer is still valid
     *
     * It returns false when the end of list has been reached
     *
     * @return bool
     */
    public function valid()
    {
        return $this->valid;
    }
}
?>
