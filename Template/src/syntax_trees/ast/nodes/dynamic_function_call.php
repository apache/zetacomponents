<?php
/**
 * File containing the ezcTemplateDynamicFunctionCallAstNode class
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
class ezcTemplateDynamicFunctionCallAstNode extends ezcTemplateParameterizedAstNode
{
    /**
     * The expression which will, when evaluated, return the name of the
     * function.
     * @var ezcTemplateAstNode
     */
    public $nameExpression;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $nameExpression = null, Array $functionArguments = null )
    {
        parent::__construct( 1, false );

        $this->nameExpression = $nameExpression;
        if ( $functionArguments !== null )
        {
            foreach ( $functionArguments as $argument )
            {
                $this->appendParameter( $argument );
            }
        }
    }

    /**
     * Returns the parameters of the function call.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array_merge( array( $this->nameExpression ), $this->parameters );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "call";
    }

    /**
     * @inheritdocs
     * Calls visitFunctionCall() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->nameExpression === null )
        {
            throw new Exception( "Function call element does not have the \$nameExpression variable set." );
        }
        $visitor->visitFunctionCall( $this );
    }
}
?>
