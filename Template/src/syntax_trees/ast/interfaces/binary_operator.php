<?php
/**
 * File containing the ezcTemplateBinaryOperatorAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 *
 */
abstract class ezcTemplateBinaryOperatorAstNode extends ezcTemplateOperatorAstNode
{
    public function __construct( $parameter1 = null, $parameter2 = null )
    {
        parent::__construct( self::OPERATOR_TYPE_BINARY );

        if( $parameter1 != null && $parameter2 != null )
        {
            $this->appendParameter( $parameter1 );
            $this->appendParameter( $parameter2 );
        }
        elseif( $parameter1 != null )
        {
            throw new Exception( "The binary operator expects zero or two parameters." );
        }
    }
}
?>
