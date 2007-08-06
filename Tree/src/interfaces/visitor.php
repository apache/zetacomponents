<?php
/**
 * File containing the ezcTreeVisitor interface.
 *
 * @package Tree
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for visitor implementations that want to process
 * a tree using the Visitor design pattern.
 *
 * visit() is called on each of the nodes in the tree in a top-down,
 * depth-first fashion.
 *
 * Start the processing of the tree by calling accept() on the tree
 * passing the visitor object as the sole parameter.
 *
 * @package Tree
 * @version //autogen//
 */
interface ezcTreeVisitor
{
    /**
     * Visit the $visitable.
     *
     * Each node in the graph is visited once.
     *
     * @param ezcTreeVisitable $visitable
     * @return bool
     */
    public function visit( ezcTreeVisitable $visitable );
}
?>
