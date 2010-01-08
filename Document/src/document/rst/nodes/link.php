<?php
/**
 * File containing the ezcDocumentRstLinkNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The base link AST node
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
abstract class ezcDocumentRstLinkNode extends ezcDocumentRstNode
{
    /**
     * The target the link points too.
     *
     * @var string
     */
    public $target = false;
}

?>
