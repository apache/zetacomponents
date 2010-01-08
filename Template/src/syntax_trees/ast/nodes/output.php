<?php
/**
 * File containing the ezcTemplateOutputAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a node that should be sent to the output.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateOutputAstNode extends ezcTemplateAstNode
{
    /**
     * The expression that should be output. 
     *
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Whether the output should be sent as raw (no context escaping).
     *
     * @var bool
     */
    public $isRaw;

    /**
     * Constructs a new output node.
     *
     * @param ezcTemplateAstNode $expression
     */
    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }
}
?>
