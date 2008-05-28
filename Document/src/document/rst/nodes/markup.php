<?php
/**
 * File containing the ezcDocumentRstParagraphNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The abstract inline markup base AST node
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
abstract class ezcDocumentRstMarkupNode extends ezcDocumentRstNode
{
    /**
     * Indicator wheather this is an open or closing tag.
     * 
     * @var bool
     */
    public $openTag;
}

?>
