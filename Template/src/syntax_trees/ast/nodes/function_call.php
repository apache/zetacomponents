<?php
/**
 * File containing the ezcTemplateFunctionCallAstNode class
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
class ezcTemplateFunctionCallAstNode extends ezcTemplateParameterizedAstNode
{
    /**
     * The name of the function to call.
     * @var string
     */
    public $name;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( $name, Array $functionArguments = null )
    {
        parent::__construct( 1, false );
        $this->name = $name;

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
        return $this->parameters;
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "call <{$this->name}>";
    }

    /**
     * @inheritdocs
     * Calls visitFunctionCall() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitFunctionCall( $this );
    }
}
?>
