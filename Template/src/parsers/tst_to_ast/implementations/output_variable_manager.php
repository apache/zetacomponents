<?php

class ezcTemplateOutputVariableManager
{
    private $outputVariables = array();
    private $stackSize = 0;

    public function __construct( $initialValue = null )
    {
        if ( is_object( $initialValue ) &&
             $initialValue instanceof ezcTemplateAstNode )
        {
            $this->initialValue = $initialValue;
        }
        else
        {
            $this->initialValue = new ezcTemplateLiteralAstNode( $initialValue );
        }
    }

    public function push( $name, $astNode = null )
    {
        if ( $astNode === null )
        {
            $astNode = new ezcTemplateVariableAstNode( $name );
        }
        array_push( $this->outputVariables, array( 'name'    => $name,
                                                   'ast'     => $astNode,
                                                   'is_used' => false ) );
        ++$this->stackSize;
    }

    public function pop()
    {
        if ( count( $this->outputVariables ) == 0 )
        {
            throw new ezcTemplateInternalException( "Attempted pop() on an empty stack of variables" );
        }

        array_pop( $this->outputVariables );
        --$this->stackSize;
    }

    public function getName()
    {
        return $this->outputVariables[$this->stackSize - 1]['name'];
    }

    public function getAst()
    {
        $this->outputVariables[$this->stackSize - 1]['is_used'] = true;
        return clone $this->outputVariables[$this->stackSize - 1]['ast'];
    }

    public function isUsed()
    {
        return $this->outputVariables[$this->stackSize - 1]['is_used'];
    }

    public function getInitializationAst()
    {
        return new ezcTemplateGenericStatementAstNode(
            new ezcTemplateAssignmentOperatorAstNode( $this->getAst(),
                                                      clone $this->initialValue )
            );
    }

    public function getConcatAst( $concatValue )
    {
        return new ezcTemplateGenericStatementAstNode(
            new ezcTemplateConcatAssignmentOperatorAstNode( $this->getAst(),
                                                            $concatValue )
            );
    }


}


?>
