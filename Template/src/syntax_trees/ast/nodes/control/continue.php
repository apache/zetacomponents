<?php
/**
 * File containing the ezcTemplateContinueAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a continue control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateContinueAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, returns the number of levels to continue.
     * This can be set to null if it should only continue the current level, ie.
     * <code>
     * continue;
     * </code>
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }

    /**
     * Returns the expression of this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->expression );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "continue";
    }

    /**
     * @inheritdocs
     * Calls visitContinueControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitContinueControl( $this );
    }
}
?>
