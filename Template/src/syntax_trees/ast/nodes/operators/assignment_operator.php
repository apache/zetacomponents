<?php
/**
 * File containing the ezcTemplateAssignmentOperatorAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents the PHP assignment operator =
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateAssignmentOperatorAstNode extends ezcTemplateBinaryOperatorAstNode
{
    /**
     * Initialize operator code constructor with 2 parameters (binary).
     */
    /*public function __construct()
    {
        parent::__construct( self::OPERATOR_TYPE_BINARY );
    }
    */

    public function checkAndSetTypeHint()
    {
        $symbolTable = ezcTemplateSymbolTable::getInstance();

        $this->typeHint = $this->parameters[1]->typeHint;

        if( $this->parameters[0] instanceof ezcTemplateVariableAstNode )
        {
            $symbolTable->setTypeHint( $this->parameters[0]->name, $this->typeHint );
        }

        /*


        $first = true;
        foreach( $this->parameters as $parameter )
        {
            if( $parameter->typeHint == null )
            {
                
                exit( get_class( $parameter ) . " is null" ); 
            }

            if( $first )
            {
                $this->typeHint = $parameter->typeHint;
                $first = false;
            }
            else
            {
                $this->typeHint &= $parameter->typeHint;

                if( !( $this->typeHint & self::TYPE_VALUE  ) )
                {
                    throw new Exception ("Typehint failure");
                }
            }
        }
        */
    }


    
    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '=';
    }
}
?>
