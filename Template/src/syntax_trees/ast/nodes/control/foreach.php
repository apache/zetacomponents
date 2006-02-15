<?php
/**
 * File containing the ezcTemplateForeachAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a foreach control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateForeachAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, will return the array to iterate over.
     * @var ezcTemplateAstNode
     */
    public $arrayExpression;

    /**
     * The variable element which holds the name for the key variable to create.
     * This can be set to null to disable the creation of the key variable.
     * @var ezcTemplateVariableAstNode
     */
    public $keyVariable;

    /**
     * The variable element which holds the name of the value variable to create.
     * @var ezcTemplateVariableAstNode
     */
    public $valueVariable;

    /**
     * The body element for the foreach control structure.
     * @var ezcTemplateBodyAstNode
     */

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $array = null,
                                 ezcTemplateVariableAstNode $key = null, ezcTemplateVariableAstNode $value = null,
                                 ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->arrayExpression = $array;
        $this->keyVariable = $key;
        $this->valueVariable = $value;
        $this->body = $body;
    }

    /**
     * Returns the array expression, key and value variable and the body element
     * for this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->arrayExpression, $this->keyVariable, $this->valueVariable, $this->body );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "foreach";
    }

    /**
     * @inheritdocs
     * Calls visitForeachControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->arrayExpression === null )
        {
            throw new Exception( "Foreach control element does not have the \$arrayExpression variable set." );
        }
        if ( $this->valueVariable === null )
        {
            throw new Exception( "Foreach control element does not have the \$valueVariable variable set." );
        }
        if ( $this->body === null )
        {
            throw new Exception( "Foreach control element does not have the \$body variable set." );
        }
        $visitor->visitForeachControl( $this );
    }
}
?>
