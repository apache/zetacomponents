<?php
/**
 * File containing the ezcTemplateRootAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents the root node of the AST tree. This node may contain settings of the template.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateRootAstNode extends ezcTemplateBodyAstNode
{
    public $cacheTemplate = false;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( Array $statements = null )
    {
        parent::__construct();
    }
}
?>
