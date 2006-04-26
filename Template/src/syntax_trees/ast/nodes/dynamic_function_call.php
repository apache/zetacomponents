<?php
/**
 * File containing the ezcTemplateDynamicFunctionCallAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
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
}
?>
