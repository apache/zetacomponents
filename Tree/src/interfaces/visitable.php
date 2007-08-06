<?php
/**
 * File containing the ezcTreeVisitable interface.
 *
 * @package Tree
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for visitable tree elements that can be visited
 * by ezcTreeVisitor implementations for processing using the
 * Visitor design pattern.
 *
 * All elements that will be part of the tree must
 * implement this interface.
 *
 * {@link http://en.wikipedia.org/wiki/Visitor_pattern Information on the Visitor pattern.}
 *
 * @package Tree
 * @version //autogen//
 */
interface ezcTreeVisitable
{
    /**
     * Accepts the visitor.
     *
     * @param ezcTreeVisitor $visitor
     */
    public function accept( ezcTreeVisitor $visitor );
}
?>
