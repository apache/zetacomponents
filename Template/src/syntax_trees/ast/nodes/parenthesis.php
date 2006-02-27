<?php
/**
 * File containing the ezcTemplateGenericStatementAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a function call.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateParenthesisAstNode extends ezcTemplateAstNode
{
    /**
     * The expression making up the statement.
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
     * Returns the expression of the statement for this element.
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
        return "parenthesis";
    }

    /**
     * @inheritdocs
     * Calls visitGenericStatement() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->expression === null )
        {
            throw new Exception( "Parenthesis does not have the \$expression variable set." );
        }
        $visitor->visitParenthesis( $this );
    }
}
?>
