<?php

class ezcTemplateOutputVariableManager
{
    private $outputVariables = array();
    private $stackSize = 0;

    public function __construct()
    {
    }

    public function push( $name )
    {
        array_push( $this->outputVariables, array( $name, new ezcTemplateVariableAstNode( $name ) ) );
        ++$this->stackSize;
    }

    public function pop()
    {
        array_pop( $this->outputVariables );
        --$this->stackSize;
    }

    public function getName()
    {
        return $this->outputVariables[$this->stackSize - 1][0];
    }

    public function getAst()
    {
        return $this->outputVariables[$this->stackSize - 1][1];
    }

    public function getInitializationAst()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $this->getAst(), new ezcTemplateLiteralAstNode( "" ) ) );
    }



}


?>
