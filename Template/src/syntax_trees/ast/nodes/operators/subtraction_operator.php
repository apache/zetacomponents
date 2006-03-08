<?php
/**
 * File containing the ezcTemplateSubtractionOperatorAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents the PHP subtraction operator -
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateSubtractionOperatorAstNode extends ezcTemplateOperatorAstNode
{
    /**
     * Initialize operator code constructor with 2 parameters (binary).
     */
    public function __construct( $p1 = null, $p2 = null )
    {
        parent::__construct( self::OPERATOR_TYPE_BINARY );

        if( $p1 != null && $p2 != null )
        {
            $this->appendParameter( $p1 );
            $this->appendParameter( $p2 );
        }

    }

    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '-';
    }
}
?>
