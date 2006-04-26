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

    public function checkAndSetTypeHint()
    {
        if( $this->parameters[0]->typeHint & self::TYPE_ARRAY && $this->parameters[1]->typeHint & self::TYPE_VALUE )
        {
            $this->typeHint = self::TYPE_VALUE;
            return;
        }
        else
        {
            if ( $this->parameters[0]->typeHint == null || $this->parameters[1]->typeHint == null  )
            {
                if( $this->parameters[0]->typeHint == null ) echo "FOUND: ".get_class( $this->parameters[0] );
                if( $this->parameters[1]->typeHint == null ) echo "FOUND: ". get_class( $this->parameters[1] );

                echo ("ONE OF THE PARAMETERS was null. array_fetch_operator.php ");
                $this->typeHint = self::TYPE_VALUE;
                return;
            }
        }

        throw new ezcTemplateTypeHintException();
    }
 

    /**
     * @inheritdocs
     * Calls visitArrayFetchOperator() of the ezcTemplateBasicAstNodeVisitor interface.
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitArrayFetchOperatorAstNode( $this );
    }
}
?>
