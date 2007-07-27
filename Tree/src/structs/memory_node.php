<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * A container to store one memory tree node with meta data
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeMemoryNode extends ezcBaseStruct
{
    /**
     * The parent ezcTreeMemoryNode
     *
     * @var ezcTreeMemoryNode
     */
    public $parent;

    /**
     * The encapsulated ezcTreeNode
     *
     * @var ezcTreeNode
     */
    public $node;

    /**
     * Contains the children of this node
     *
     * @var array(string=>ezcTreeMemoryNode)
     */
    public $children;

    /**
     * Constructs an ezcTreeMemoryNode object.
     *
     * @param ezcTreeNode       $node
     * @param array(string=>ezcTreeMemoryNode) $children
     * @param ezcTreeMemoryNode $parent
     */
    function __construct( ezcTreeNode $node, array $children, ezcTreeMemoryNode $parent = null  )
    {
        $this->node = $node;
        $this->children = $children;
        $this->parent = $parent;
    }
}
?>
