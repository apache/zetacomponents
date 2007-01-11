<?php
/**
 * File containing the ezcTemplateDefaultAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a default case control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDefaultAstNode extends ezcTemplateCaseAstNode
{
    /**
     * The body element for the default case.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateBodyAstNode $body = null )
    {
        ezcTemplateStatementAstNode::__construct();
        $this->body = $body;
    }
}
?>
