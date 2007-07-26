<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * A container to store one tree modifying transaction item
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeTransactionItem extends ezcBaseStruct
{
    /**
     * Used when this transaction deals with adding nodes
     *
     * @var int
     */
    const ADD = 1;

    /**
     * Used when this transaction deals with deleting nodes
     *
     * @var int
     */
    const DELETE = 2;

    /**
     * Used when this transaction deals with moving nodes
     *
     * @var int
     */
    const MOVE = 3;

    /**
     * The item type.
     *
     * Either ADD, DELETE or MOVE
     *
     * @var int
     */
    public $type;

    /**
     * Contains the node this transaction item is for 
     *
     * Used for "add" items
     *
     * @var ezcTreeNode
     */
    public $node;

    /**
     * Contains the node ID this transaction item is for.
     *
     * Used for "move" and "delete" items 
     *
     * @var string
     */
    public $nodeId;

    /**
     * Contains the parent node ID this transaction item is for.
     *
     * Used for "add" and "move" items
     *
     * @var string
     */
    public $parentId;

    /**
     * Constructs an ezcTreeTransactionItem object.
     *
     * @param int $type Either ADD, DELETE or REMOVE
     * @param ezcTreeNode $node
     * @param string $nodeId
     * @param string $parentId
     */
    function __construct( $type, $node = null, $nodeId = null, $parentId = null )
    {
        $this->type = $type;
        $this->node = $node;
        $this->nodeId = $nodeId;
        $this->parentId = $parentId;
    }
}
?>
