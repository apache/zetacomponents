<?php
/**
 * File containing the ezcTemplateCatchAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a catch control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateCatchAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The name of the exception class to catch.
     * @var string
     */
    public $className;

    /**
     * The expression which holds the variable name to use.
     * @var ezcTemplateVariableAstNode
     */
    public $variableExpression;

    /**
     * The body element for the catch statement.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( $className, ezcTemplateVariableAstNode $var, ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();

        if ( !is_string( $className ) )
        {
            throw new ezcBaseValueException( "className", $className, 'string' );
        }
        $this->className = $className;
        $this->variableExpression = $var;
        $this->body = $body;
    }

    /**
     * Returns the expression for the variable and the body of this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->variableExpression, $this->body );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "catch";
    }

    /**
     * @inheritdocs
     * Calls visitCatchControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->variableExpression === null )
        {
            throw new Exception( "Catch control element does not have the \$variableExpression variable set." );
        }
        if ( $this->body === null )
        {
            throw new Exception( "Catch control element does not have the \$body variable set." );
        }
        $visitor->visitCatchControl( $this );
    }
}
?>
