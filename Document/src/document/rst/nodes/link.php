<?php
/**
 * File containing the ezcDocumentRstLinkNode struct
 *
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The base link AST node
 * 
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
