<?php
/**
 * File containing the ezcTemplateArrayFetchOperatorAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents the PHP array access operator [..]
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @todo ezcTemplateArrayAccessOperatorAstNode is probably a more correct name.
 */
class ezcTemplateArrayFetchOperatorAstNode extends ezcTemplateOperatorAstNode
{
    /**
     * Initialize operator code constructor with 2 parameters (binary).
     */
    public function __construct( ezcTemplateAstNode $array = null, Array $fetches = null )
    {
        parent::__construct( self::OPERATOR_TYPE_BINARY );
        // This is a special binary operator since it allows more than two parameters.
        // Each extra parameter will be considered an additional array lookup
        $this->maxParameterCount = false;

        if ( $array !== null )
        {
            $this->appendParameter( $array );
            if ( $fetches !== null )
            {
                foreach ( $fetches as $fetch )
                {
                    $this->appendParameter( $fetch );
                }
            }
        }
    }

    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '[..]';
    }

    /**
     * @inheritdocs
     * Calls visitArrayFetchOperator() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $count = count( $this->parameters );
        if ( $count >= 2 )
        {
            $visitor->visitArrayFetchOperator( $this );
        }
        else
        {
            throw new Exception( "Operator must have 2 or more operands but this has {$count}" );
        }
    }
}
?>
