<?php
/**
 * File containing the ezcTemplateAstNodeGenerator class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Transforms the TST tree to an AST tree.
 *
 * Implements the ezcTemplateTstNodeVisitor interface for visiting the nodes
 * and generating the appropriate ast nodes for them.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTstToAstTransformer implements ezcTemplateTstNodeVisitor
{
    public $programNode = null;

    public $functions; 

    public $type;

    public $parser;

    private $foundDelimiter = false;
    private $variableNames = array();
    private $delimiterVariable = null;
    private $delimiterSkip = null;
    private $delimiterOutput = null;
    private $writeDelimiterOutput = false;

    private $noProperty = false;

    private $isFunctionFromObject = false;

    public function __construct( $parser )
    {
        $this->functions = new ezcTemplateFunctions();
        $this->parser = $parser;
    }

    public function __destruct()
    {
    }
     private function getUniqueVariableName( $name )
     {
            if( !isset( $this->variableNames[$name] ) )
            {
                $this->variableNames[$name] = 1;
            }
            else
            {
                ++$this->variableNames[$name];
            }

            return "_ezcTemplate_" . $name . $this->variableNames[$name];
     }


    private function appendOperatorRecursively( ezcTemplateOperatorTstNode $type, ezcTemplateOperatorAstNode $astNode, $currentParameterNumber = 0)
    {
        $node = clone( $astNode );
        
        try
        {
            $appendNode = $type->parameters[ $currentParameterNumber ]->accept( $this );
            $node->appendParameter( $appendNode );
            $typeHint1 = $appendNode->typeHint;

            $currentParameterNumber++;

            if( $currentParameterNumber == sizeof( $type->parameters ) - 1 ) 
            {
                // The last node.
                $appendNode = $type->parameters[ $currentParameterNumber ]->accept( $this );
                $node->appendParameter( $appendNode );
            }
            else
            {
                // More than two parameters, so repeat.
                $appendNode = $this->appendOperatorRecursively( $type, $astNode, $currentParameterNumber );
                $node->appendParameter( $appendNode  );
            }

        }
        catch( Exception $e )
        {
            throw new ezcTemplateParserException( $type->source, $type->endCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VALUE );
        }
        /*
        $typeHint2 = $appendNode->typeHint;
        if( $typeHint1 != null && $typeHint2 != null )
        {
            $node->typeHint = $typeHint1 & $typeHint2;
            if( !$node->typeHint)
            {
                throw new ezcTemplateParserException( $type->source, $type->endCursor, $type->endCursor, "Expect the same operand types. (Both values or both arrays)" );
            }
        }
        */

        return $node;
    }

    private function checkSameBinaryTypeHint( $astNode, $type )
    {
        if( !( $astNode->parameters[0]->typeHint & $astNode->parameters[1]->typeHint ) )
        {
            throw new ezcTemplateParserException( $type->source, $type->endCursor, $type->endCursor, "Expect the same operand types. (Both values or both arrays)" );
        }
    }

    private function createBinaryOperatorAstNode( $type, ezcTemplateOperatorAstNode $astNode, $addParenthesis = true )
    {
        $astNode->appendParameter( $type->parameters[0]->accept( $this ) );
        $astNode->appendParameter( $type->parameters[1]->accept( $this ) );
        return ( $addParenthesis ?  new ezcTemplateParenthesisAstNode( $astNode ) : $astNode );
    }

    private function createUnaryOperatorAstNode( $type, ezcTemplateOperatorAstNode $astNode, $addParenthesis = true )
    {
        $astNode->appendParameter( $type->parameters[0]->accept( $this ));

        return ( $addParenthesis ?  new ezcTemplateParenthesisAstNode( $astNode ) : $astNode );
    }
 
    private function isAssignmentNode( $astNode )
    {
        if ( $astNode instanceof ezcTemplateAssignmentOperatorAstNode ) return true;
        if ( $astNode instanceof ezcTemplateIncrementOperatorAstNode )  return true;
        if ( $astNode instanceof ezcTemplateDecrementOperatorAstNode )  return true;

        return false;
    }

    private function addOutputNodeIfNeeded( ezcTemplateAstNode $astNode )
    {
        if( $this->isAssignmentNode( $astNode ) ||  $astNode instanceof ezcTemplateStatementAstNode )
        {
            return $astNode;
        }

        return $this->assignToOutput( $astNode );
        //return new ezcTemplateEchoAstNode( array( $astNode ) );
    }

    private function createBody( array $elements )
    {
        $body = new ezcTemplateBodyAstNode();

        foreach( $elements as $element )
        {
            $astNode = $element->accept( $this );
            if( is_array( $astNode ) )
            {
                foreach( $astNode as $ast )
                {
                    $body->appendStatement( $ast );
                }
            }
            else
            {
                $body->appendStatement( $astNode );
            }
        }

        return $body;
    }

    private function assignToOutput( $node )
    {
        if( $this->writeDelimiterOutput && $this->delimiterOutput !== null )
        {
            return new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( $this->delimiterOutput, $node ) );
        }
        
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( new ezcTemplateVariableAstNode( "_ezcTemplate_output" ), $node ) );
    }

    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $type )
    {
        die("visitCustomTstNode");
    }

    public function visitProgramTstNode( ezcTemplateProgramTstNode $type )
    {
        if ( $this->programNode === null )
        {
            //$this->programNode = $this->createBody( $type->elements );
            $this->programNode = new ezcTemplateBodyAstNode();

            $cb = new ezcTemplateAstBuilder;
            $cb->assign( "_ezcTemplate_output", "" ); 
            $cb->call ("return", $cb->variable( "_ezcTemplate_output" ) );
            $body = $cb->getAstNode();

            $this->programNode->appendStatement( $body->statements[0] );

            foreach( $type->elements as $element )
            {
                $astNode = $element->accept( $this );
                if( is_array( $astNode ) )
                {
                    foreach( $astNode as $ast )
                    {
                        $this->programNode->appendStatement( $ast);
                    }
                }
                else
                {
                    $this->programNode->appendStatement( $astNode );
                }
            }

            $this->programNode->appendStatement( $body->statements[1] );
        }
        else
        {
            die ("PANIC, program node is not null ");
        }
    }

    public function visitCycleControlTstNode( ezcTemplateCycleControlTstNode $cycle )
    {
        if( $cycle->name == "increment" || $cycle->name == "decrement" || $cycle->name == "reset" )
        {
            foreach( $cycle->variables as $var )
            {
                $this->noProperty = true;
                $b = new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "\$".$var->name . "->".$cycle->name, array() ) ); 
                $this->noProperty = false;

                return $b;
            }
        }

    }

    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $type )
    {
        return $this->assignToOutput( new ezcTemplateLiteralAstNode( $type->text ) );
        /*
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( new ezcTemplateVariableAstNode( "_ezcTemplate_output" ), new ezcTemplateLiteralAstNode( $type->text ) ) );
        //return new ezcTemplateEchoAstNode( array( new ezcTemplateLiteralAstNode( $type->text ) ) );
        */
    }

    public function visitEmptyBlockTstNode( ezcTemplateEmptyBlockTstNode $type )
    {
        return new ezcTemplateEolCommentAstNode( 'Result of empty block {}' );
    }

    public function visitParenthesisTstNode( ezcTemplateParenthesisTstNode $type )
    {
        $expression = $type->expressionRoot->accept( $this );
        $newNode = new ezcTemplateParenthesisAstNode( $expression );
        $newNode->typeHint = $expression->typeHint;
        return $newNode;
    }

    public function visitOutputBlockTstNode( ezcTemplateOutputBlockTstNode $type )
    {
        $expression = $type->expressionRoot->accept( $this ); 
        $output = new ezcTemplateOutputAstNode( $expression );

        return $this->assignToOutput( $output );
    }

    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $type )
    {
        $expression = $type->expressionRoot->accept( $this ); 
        return  new ezcTemplateGenericStatementAstNode( $expression );
    }

    public function visitLiteralTstNode( ezcTemplateLiteralTstNode $type )
    {
        // TODO REMOVE next line

        $newNode = new ezcTemplateLiteralAstNode( $type->value );
        $newNode->typeHint = is_array( $type->value ) ? ezcTemplateAstNode::TYPE_ARRAY : ezcTemplateAstNode::TYPE_VALUE;

        return $newNode; 
    }

    public function visitIdentifierTstNode( ezcTemplateIdentifierTstNode $type )
    {
        $newNode = new ezcTemplateIdentifierAstNode( $type->value );
        return $newNode; 
    }

    public function visitIntegerTstNode( ezcTemplateIntegerTstNode $type )
    {
        die("visitIntegerTstNode");
    }

    public function visitVariableTstNode( ezcTemplateVariableTstNode $type )
    {
        if( $this->parser->symbolTable->retrieve( $type->name ) == ezcTemplateSymbolTable::IMPORT) 
        {
            return new ezcTemplateVariableAstNode( "send->". $type->name );
        }

        
        if( !$this->noProperty && $this->parser->symbolTable->retrieve( $type->name ) == ezcTemplateSymbolTable::CYCLE ) 
        {
            $this->isCycle = true;
            return new ezcTemplateVariableAstNode( $type->name . "->v" );
        }

        return new ezcTemplateVariableAstNode( $type->name );
    }

    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $type )
    {
        //$echo = new ezcTemplateOutputAstNode( $type->text );
        return $this->assignToOutput( new ezcTemplateLiteralAstNode( $type->text ) );

        //$echo = new ezcTemplateEchoAstNode( array( new ezcTemplateLiteralAstNode( $type->text ) ) );
        //return $echo;
    }

    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $type )
    {
        if( $this->isFunctionFromObject )
        {
            $p = array();
            foreach( $type->parameters as $parameter )
            {
                $p[] = $parameter->accept($this);
            }
            
            $tf = new ezcTemplateFunctionCallAstNode( $type->name, $p );


            $tf->typeHint = ezcTemplateAstNode::TYPE_ARRAY | ezcTemplateAstNode::TYPE_VALUE;

            return $tf;
        }

        $paramAst = array();
        foreach( $type->parameters as $parameter )
        {
            $paramAst[] = $parameter->accept( $this );
        }

        try
        {
            return $this->functions->getAstTree( $type->name, $paramAst );
        }
        catch( Exception $e )
        {
            throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, $e->getMessage() ); 
        }
    }

    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $type )
    {
        return new ezcTemplateBlockCommentAstNode ( $type->commentText );
    }

    /** 
     * TST:
     * [Foreach]
     *  LiteralTstNode array
     *  string keyVariableName
     *  string itemVariableName
     *  array(Block) elements
     *
     * AST:
     * [Foreach]
     *  Expression arrayExpression
     *  ezcTemplateVariableAstNode keyVariable
     *  ezcTemplateVariableAstNode valueVariable
     *  Body statements
     */
    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $type )
    {
        $i = 0;
        $this->delimiterVariable = $delimiterVariable =  new ezcTemplateVariableAstNode( $this->getUniqueVariableName( "delim" ) ); 
        $this->delimiterOutput =  $delimiterOutput = new ezcTemplateVariableAstNode(  $this->getUniqueVariableName( "delimOut" ) );

        // Define the variable, _ezcTemplate_limit and set it to 0.
        $limitVar = null;

        $this->foundDelimiter = false; // If the foreach contains a delimiter, this value will be set to true after processing the body.

        // Process body.
        $body = $this->createBody( $type->elements );

        $this->delimiterVariable = $delimiterVariable;
        $this->delimiterOutput = $delimiterOutput;

        if( $type->limit !== null )
        {
            $limitVar = new ezcTemplateVariableAstNode( $this->getUniqueVariableName( "limit" ) );

            $assign = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                    $limitVar, new ezcTemplateLiteralAstNode( 0 ) ) );

            $astNode[$i++] = $assign;
        }


        if( $this->foundDelimiter )
        {
            // Assign the delimiter variable to 0 (above foreach).
            // $_ezcTemplate_delimiterCounter = 0
            $astNode[$i++] = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                              $this->delimiterVariable, new ezcTemplateLiteralAstNode( 0 ) ) );

            // Assign delimiter output to "" (above foreach)
            // $_ezcTemplate_delimiterOut = ""
            $astNode[$i++] = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                              $this->delimiterOutput, new ezcTemplateLiteralAstNode( "" ) ) );

            array_unshift( $body->statements, new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $this->delimiterOutput, new ezcTemplateLiteralAstNode( "" ) ) ) );

            $inc = new ezcTemplateIncrementOperatorAstNode( true );
            $inc->appendParameter( $this->delimiterVariable );
            array_unshift( $body->statements, new ezcTemplateGenericStatementAstNode( $inc ) );

            // output delimiter output (in foreach).
            // $_ezcTemplate_output .= $_ezcTemplate_delimiterOut;
            array_unshift( $body->statements, new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( 
                new ezcTemplateVariableAstNode( "_ezcTemplate_output" ), $this->delimiterOutput ) ) );
        }
 
        $astNode[$i] = new ezcTemplateForeachAstNode();

        if( $type->offset !== null )
        {
            $params[] = $type->array->accept( $this );
            if( !( $params[ sizeof( $params ) - 1 ]->typeHint & ezcTemplateAstNode::TYPE_ARRAY) )
            {
                throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ARRAY );
            }

            $params[] = $type->offset->accept( $this );

            $astNode[$i]->arrayExpression = $this->functions->getAstTree( "array_remove_first", $params);
        }
        else
        {
            $astNode[$i]->arrayExpression = $type->array->accept( $this );

            if( !( $astNode[$i]->arrayExpression->typeHint & ezcTemplateAstNode::TYPE_ARRAY) )
            {
                throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ARRAY );
            }
        }

        if( $type->keyVariableName  !== null )
        {
            $astNode[$i]->keyVariable = new ezcTemplateVariableAstNode( $type->keyVariableName );
        }

        $astNode[$i]->valueVariable = new ezcTemplateVariableAstNode( $type->itemVariableName );

        $astNode[$i]->body = $body; 
       

        // Increment by one, and do the limit check.
        if( $type->limit !== null )
        {
            $inc = new ezcTemplateIncrementOperatorAstNode( true );
            $inc->appendParameter( $limitVar );

            $astNode[$i]->body->statements[] = new ezcTemplateGenericStatementAstNode( $inc );

            $eq = new ezcTemplateEqualOperatorAstNode();
            $eq->appendParameter( $limitVar );
            $eq->appendParameter( $type->limit->accept($this) );

            $if = new ezcTemplateIfAstNode();
            $cb = new ezcTemplateConditionBodyAstNode();
            $cb->condition = $eq;
            $cb->body = new ezcTemplateBreakAstNode();
            $if->conditions[] = $cb;

            $astNode[$i]->body->statements[] = $if;
        }

        if ( $this->foundDelimiter )
        {
            $astNode[++$i] =  new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( 
                new ezcTemplateVariableAstNode( "_ezcTemplate_output" ), $this->delimiterOutput ) );
        }
                
        return $astNode;
    }

    public function visitDelimiterTstNode( ezcTemplateDelimiterTstNode $type ) 
    {
        $this->foundDelimiter = true;
        $this->writeDelimiterOutput =  true;

        // if( $counter % $modulo == $rest )
        $mod = new ezcTemplateModulusOperatorAstNode();
        $mod->appendParameter( $this->delimiterVariable );
        $mod->appendParameter( $type->modulo->accept( $this ) );

        $eq = new ezcTemplateEqualOperatorAstNode();
        $eq->appendParameter( $mod );
        $eq->appendParameter( $type->rest->accept( $this ) );

        $if = new ezcTemplateIfAstNode();
        $cb = new ezcTemplateConditionBodyAstNode();
        $cb->condition = $eq;

        // { // body
        // }
        $cb->body = $this->createBody( $type->children );
        $if->conditions[] = $cb;

        // else
/*
        $else = new ezcTemplateConditionBodyAstNode();
        $else->condition = null;
        $else->body = new ezcTemplateBodyAstNode();
        $else->body->appendStatement( new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $this->delimiterOutput, new ezcTemplateLiteralAstNode( "" ) ) ) );

        $if->conditions[] = $else;
        */


        $this->writeDelimiterOutput = false;
            return array($if );
    }


    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $type )
    {
        if( $type->name == "do" )
        {
            $astNode = new ezcTemplateDoWhileAstNode();
        }
        else
        {
            $astNode = new ezcTemplateWhileAstNode();
        }

        $cb = new ezcTemplateConditionBodyAstNode();
        $cb->condition = $type->condition->accept( $this );
        $cb->body = $this->createBody( $type->elements );

        $astNode->conditionBody = $cb; 

        return $astNode;
    }

    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $type )
    {
        $astNode = new ezcTemplateIfAstNode();

        $i = 0;
        foreach( $type->children as $child )
        {
            $astNode->conditions[$i++] = $child->accept( $this );
        }

        //$cb = $type->children[0]->accept( $this );
        //$astNode->conditions[0] = $cb;

        /*

        // First condition, the 'if'.
        $if = new ezcTemplateConditionBodyAstNode();
        $if->condition = null; //$type->condition->accept( $this );
        $if->body = $this->addOutputNodeIfNeeded( $type->children[0]->accept( $this ) );
        $astNode->conditions[0] = $if;
        */

        // Second condition, the 'elseif'.
        /*
        if( count( $type->elements ) == 3 )
        {
            $elseif = new ezcTemplateConditionBodyAstNode();
            $elseif->body = $this->addOutputNodeIfNeeded( $type->elements[1]->accept( $this ) );
            $astNode->conditions[1] = $else;

        }
        */
/*
        if( isset( $type->elements[1] ) )
        {
            $else = new ezcTemplateConditionBodyAstNode();
            $else->body = $this->addOutputNodeIfNeeded( $type->elements[1]->accept( $this ) );
            $astNode->conditions[2] = $else;
        }
        */

        return $astNode;
    }

    public function visitConditionBodyTstNode( ezcTemplateConditionBodyTstNode $type ) 
    {
        $cb = new ezcTemplateConditionBodyAstNode();
        $cb->condition = ( $type->condition !== null ? $type->condition->accept( $this ) : null );
        $cb->body = $this->createBody( $type->children );
        return $cb;
    }

    public function visitLoopTstNode( ezcTemplateLoopTstNode $type )
    {
        if( $type->name == "skip" )
        {
            $dec = new ezcTemplateGenericStatementAstNode( new ezcTemplateDecrementOperatorAstNode( true ) );
            $dec->expression->appendParameter( $this->delimiterVariable );

            return array( $dec,
                new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                              $this->delimiterOutput, new ezcTemplateLiteralAstNode( "" ) ) ), new ezcTemplateContinueAstNode() );
        }
        elseif( $type->name == "continue")
        { 
            return new ezcTemplateContinueAstNode();
        }
        elseif( $type->name == "break")
        {
            return new ezcTemplateBreakAstNode();
        }

        // STRANGE name
        throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->startCursor, "Unhandled loop control name: " . $type->name );
    }

    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $type )
    {

        $astNode = new ezcTemplateReferenceOperatorAstNode();
        $astNode->appendParameter( $type->parameters[0]->accept( $this ));

        $this->isFunctionFromObject = true;
        $astNode->appendParameter( $type->parameters[1]->accept( $this ));

        return $astNode;


        /*
        $astNode = new ezcTemplateObjectAccessOperatorAstNode();
        $astNode->appendParameter( $type->parameters[0]->accept( $this ));
        $astNode->appendParameter( new ezcTemplateCurlyBracesAstNode( $type->parameters[1]->accept( $this ) ) );

        return $astNode;
        */

    }


    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateArrayFetchOperatorAstNode() );
    }

    // return ezcTemplateTstNode;
    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $type )
    {
        return new ezcTemplateParenthesisAstNode( $this->appendOperatorRecursively( $type, new ezcTemplateAdditionOperatorAstNode) );
    }

    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $type )
    {
        return new ezcTemplateParenthesisAstNode($this->appendOperatorRecursively( $type, new ezcTemplateSubtractionOperatorAstNode) );
    }

    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $type )
    {
        return new ezcTemplateParenthesisAstNode($this->appendOperatorRecursively( $type, new ezcTemplateConcatOperatorAstNode) );
    }

    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $type )
    {
        return new ezcTemplateParenthesisAstNode($this->appendOperatorRecursively( $type, new ezcTemplateMultiplicationOperatorAstNode) );
    }

    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $type )
    {
        return new ezcTemplateParenthesisAstNode($this->appendOperatorRecursively( $type, new ezcTemplateDivisionOperatorAstNode) );
    }

    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $type )
    {
        return new ezcTemplateParenthesisAstNode($this->appendOperatorRecursively( $type, new ezcTemplateModulusOperatorAstNode) );
    }

    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $type )
    {
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateEqualOperatorAstNode() );
        return $astNode;
    }

    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $type )
    {
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateNotEqualOperatorAstNode() );
        return $astNode;
    }

    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateIdenticalOperatorAstNode() );
    }

    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateNotIdenticalOperatorAstNode() );
    }

    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateLessThanOperatorAstNode() );
    }

    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateGreaterThanOperatorAstNode() );
    }

    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateLessEqualOperatorAstNode() );
    }

    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateGreaterEqualOperatorAstNode() );
    }

    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateLogicalAndOperatorAstNode() );
    }

    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateLogicalOrOperatorAstNode() );
    }

    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $type )
    {
        $this->isCycle = false;
        $astNode = new ezcTemplateAssignmentOperatorAstNode(); 
        $astNode->appendParameter( $type->parameters[0]->accept( $this ) ); // Set cycle.
        $assignment = $type->parameters[1]->accept( $this );

        if( $this->isCycle && !($assignment->typeHint & ezcTemplateAstNode::TYPE_ARRAY) )
        {
            throw new ezcTemplateParserException( $type->source, $type->parameters[1]->startCursor, 
                $type->parameters[1]->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ARRAY );
        }

        $astNode->appendParameter( $assignment );
        return $astNode;
    }

    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $type )
    {
        $this->isCycle = false;
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateAdditionAssignmentOperatorAstNode(), false );
        if( $this->isCycle )
        {
            throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_OPERATOR_ON_CYCLE);
        }

        return $astNode;
    }
public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $type )
    {
        $this->isCycle = false;
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateSubtractionAssignmentOperatorAstNode(), false );
        if( $this->isCycle )
        {
            throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_OPERATOR_ON_CYCLE);
        }

        return $astNode;
    }

    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $type )
    {
        $this->isCycle = false;
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateMultiplicationAssignmentOperatorAstNode(), false );
        if( $this->isCycle )
        {
            throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_OPERATOR_ON_CYCLE);
        }

        return $astNode;
    }

    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $type )
    {
        $this->isCycle = false;
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateDivisionAssignmentOperatorAstNode(), false );
        if( $this->isCycle )
        {
            throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_OPERATOR_ON_CYCLE);
        }

        return $astNode;
    }

    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $type )
    {
        $this->isCycle = false;
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateConcatAssignmentOperatorAstNode(), false );
        if( $this->isCycle )
        {
            throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_OPERATOR_ON_CYCLE);
        }

        return $astNode;
    }

    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $type )
    {
        $this->isCycle = false;
        $astNode = $this->createBinaryOperatorAstNode( $type, new ezcTemplateModulusAssignmentOperatorAstNode(), false );
        if( $this->isCycle )
        {
            throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_OPERATOR_ON_CYCLE);
        }

        return $astNode;
    }

    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $type )
    {
        // Pre increment has the parameter in the constructor set to true.
        return $this->createUnaryOperatorAstNode( $type, new ezcTemplateIncrementOperatorAstNode( true ), false );
    }

    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $type )
    {
        // Pre increment has the parameter in the constructor set to false.
        return $this->createUnaryOperatorAstNode( $type, new ezcTemplateDecrementOperatorAstNode( true ), false );
    }

    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $type )
    {
        // Post increment has the parameter in the constructor set to false.
        return $this->createUnaryOperatorAstNode( $type, new ezcTemplateIncrementOperatorAstNode( false ), false );
    }

    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $type )
    {
        // Post increment has the parameter in the constructor set to false.
        return $this->createUnaryOperatorAstNode( $type, new ezcTemplateDecrementOperatorAstNode( false ), false );
    }

    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $type )
    {
        // Is the minus.
        return $this->createUnaryOperatorAstNode( $type, new ezcTemplateArithmeticNegationOperatorAstNode(), true );
    }

    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $type )
    {
        return $this->createUnaryOperatorAstNode( $type, new ezcTemplateLogicalNegationOperatorAstNode(), true );
    }

    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $type )
    {
        die ("visitInstanceOfOperatorTstNode");
    }

    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $type )
    {
        die("The visitBlockCommentTstNode is called, however this node shouldn't be in the TST tree. It's used for testing purposes.");
    }

    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $type )
    {
        die("The visitEolCommentTstNode is called, however this node shouldn't be in the TST tree. It's used for testing purposes.");
    }

    public function visitBlockTstNode( ezcTemplateBlockTstNode $type ) 
    {
        // Used abstract, but is parsed. Unknown.
        die("visitBlockTstNode");
    }

    public function visitDeclarationTstNode( ezcTemplateBlockTstNode $type ) 
    {
        if( $this->parser->symbolTable->retrieve( $type->variable->name ) == ezcTemplateSymbolTable::CYCLE ) 
        {
            $this->noProperty = true;
            $var = $type->variable->accept( $this );
            $a = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $var, new ezcTemplateNewAstNode( "ezcTemplateCycle()" ) ) );
            $this->noProperty = false;

            $expression = $type->expression === null ? new ezcTemplateConstantAstNode( "NULL") : $type->expression->accept($this);

            if( $type->expression !== null && !($expression->typeHint & ezcTemplateAstNode::TYPE_ARRAY ) )
            {
                throw new ezcTemplateParserException( $type->source, $type->expression->startCursor, 
                    $type->expression->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ARRAY );
            }

            $b =  new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $type->variable->accept($this), $expression ) );

            return array($a, $b);
        }
        elseif( $this->parser->symbolTable->retrieve( $type->variable->name ) == ezcTemplateSymbolTable::IMPORT ) 
        {
            $call = new ezcTemplateFunctionCallAstNode("isset", array( $type->variable->accept( $this ) ) );

            $if = new ezcTemplateIfAstNode();
            $cb = new ezcTemplateConditionBodyAstNode();
            $cb->condition = new ezcTemplateLogicalNegationOperatorAstNode( $call);
            $expression = $type->expression === null ? new ezcTemplateConstantAstNode( "NULL") : $type->expression->accept($this);
            $cb->body = new ezcTemplateGenericStatementAstNode(new ezcTemplateAssignmentOperatorAstNode( $type->variable->accept($this), $expression ) );

            $if->conditions[] = $cb;
            return $if;
        }

        $expression = $type->expression === null ? new ezcTemplateConstantAstNode( "NULL") : $type->expression->accept($this);
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $type->variable->accept($this), $expression ) );
    }

    public function visitSwitchTstNode( ezcTemplateSwitchTstNode $type )
    {
        $astNode = new ezcTemplateSwitchAstNode();
        $astNode->expression = $type->condition->accept( $this );

        foreach( $type->children as $child )
        {
            $res = $child->accept( $this );
            if( is_array( $res ) )
            {
                foreach( $res as $r )
                {
                    $astNode->cases[] = $r;
                }
            }
            else
            {
                $astNode->cases[] = $res;
            }
        }

        return $astNode;
    }

    public function visitCaseTstNode( ezcTemplateCaseTstNode $type ) 
    {
        // Default.
        if( $type->conditions === null  )
        {
            $default = new ezcTemplateDefaultAstNode();
            $default->body = $this->createBody( $type->children );
            $default->body->statements[] = new ezcTemplateBreakAstNode(); // Add break;
            return $default;
        }

        // Case, with multipe values. {case 1,2,3}, return as an array with astNodes.
        // Switch will create multiple cases: case 1: case2: case3: <my code>
        foreach ($type->conditions as $condition )
        {
            $cb = new ezcTemplateCaseAstNode();
            $cb->match = $condition->accept($this);
            $cb->body = new ezcTemplateBodyAstNode();
            
            $res[] = $cb;
        }

        $cb->body = $this->createBody( $type->children );
        $cb->body->statements[] = new ezcTemplateBreakAstNode();

        return $res;
        
      /* 
        $cb = new ezcTemplateConditionBodyAstNode();
        $cb->condition = ( $type->condition !== null ? $type->condition->accept( $this ) : null );
        $cb->body = $this->createBody( $type->children ); //$this->addOutputNodeIfNeeded( $type->children[0]->accept( $this ) );
        return $cb;
        */

/* 
        $condition = $type->condition->accept( $this );
        $body = $this->createBody( $type->elements );

        var_dump ( $cbbody );
        exit();
        */
    }

    public function visitIncludeTstNode( ezcTemplateIncludeTstNode $type )
    {
        $ast = array();

        // $t = clone \$this->manager; 
        $ast[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                $t = new ezcTemplateVariableAstNode( "t" ), 
                new ezcTemplateCloneAstNode( new ezcTemplateVariableAstNode( "this->template" ) ) ) 
            );


        // $t->send = new ezcTemplateVariableCollection();
        $ast[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                    $s = new ezcTemplateReferenceOperatorAstNode( $t, new ezcTemplateIdentifierAstNode( "send" ) ),
                    new ezcTemplateNewAstNode( "ezcTemplateVariableCollection" ) ) );

        // Send parameters
        foreach ( $type->send as $name => $expr )
        {
            if( $expr !== null )
            {
                $rhs = $expr->accept($this); 
            }
            else
            {
                if( $this->parser->symbolTable->retrieve( $name ) == ezcTemplateSymbolTable::IMPORT) 
                {
                    $rhs = new ezcTemplateVariableAstNode( "send->".$name );
                }
                else
                {
                    $rhs = new ezcTemplateVariableAstNode( $name );
                }
            }

            $ast[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                        new ezcTemplateReferenceOperatorAstNode( $s, new ezcTemplateIdentifierAstNode( $name ) ), 
                        $rhs ) );
        }
         
        // $ezcTemplate_output .= $t->process( <file> );
        $ast[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( 
            new ezcTemplateVariableAstNode( "_ezcTemplate_output" ), new ezcTemplateReferenceOperatorAstNode( $t , new ezcTemplateFunctionCallAstNode( "process", array( $type->file->accept($this) ) ) ) ) );

        $r = new ezcTemplateReferenceOperatorAstNode( $t, new ezcTemplateIdentifierAstNode( "receive" ) );
        foreach ( $type->receive as $oldName => $name )
        {
            if( is_numeric( $oldName ) ) $oldName = $name;
            $ast[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( 
                        new ezcTemplateVariableAstNode( $name ),
                        new ezcTemplateReferenceOperatorAstNode( $r, new ezcTemplateIdentifierAstNode( $oldName ) ) ) );
        }

        //unset ($t);
        $ast[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "unset", array( $t ) ) );

        return $ast;
    }

    public function visitReturnTstNode( ezcTemplateReturnTstNode $type )
    {
        $astNodes = array();
        foreach( $type->variables as $var => $expr )
        {
            $assign = new ezcTemplateAssignmentOperatorAstNode();
            $assign->appendParameter( new ezcTemplateVariableAstNode( "receive->" . $var ) );

            if( $expr === null )
            {
                $assign->appendParameter( new ezcTemplateVariableAstNode( $var ) );
            }
            else
            {
                $assign->appendParameter( $expr->accept($this) );
            }

            $astNodes[] = new ezcTemplateGenericStatementAstNode( $assign );
        }

        $astNodes[] = new ezcTemplateReturnAstNode( new ezcTemplateVariableAstNode( "_ezcTemplate_output" ) );
        return $astNodes;
    }

    public function visitArrayRangeOperatorTstNode( ezcTemplateArrayRangeOperatorTstNode $type ) 
    {
        return $this->appendFunctionCallRecursively( $type, "array_fill_range", true );
    }

    private function appendFunctionCallRecursively( ezcTemplateOperatorTstNode $type, $functionName, $checkNonArray = false, $currentParameterNumber = 0)
    {
        $paramAst = array();

        $paramAst[] = $type->parameters[ $currentParameterNumber ]->accept( $this );
        if( $checkNonArray && !( $paramAst[0]->typeHint & ezcTemplateAstNode::TYPE_VALUE ) )
        {
            throw new ezcTemplateParserException( $type->source, $type->parameters[$currentParameterNumber]->startCursor, 
                $type->parameters[$currentParameterNumber]->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VALUE_NOT_ARRAY );
        }

        $currentParameterNumber++;

        if( $currentParameterNumber == sizeof( $type->parameters ) - 1 ) 
        {
            // The last node.
            $paramAst[] = $type->parameters[ $currentParameterNumber ]->accept( $this );
            
        }
        else
        {
            // More than two parameters, so repeat.
            $paramAst[] = $this->appendFunctionCallRecursively( $type, $functionName, $checkNonArray, $currentParameterNumber );
        }

        if( $checkNonArray && !( $paramAst[1]->typeHint & ezcTemplateAstNode::TYPE_VALUE ) )
        {
            throw new ezcTemplateParserException( $type->source, $type->parameters[$currentParameterNumber]->startCursor, 
                $type->parameters[$currentParameterNumber]->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VALUE_NOT_ARRAY );
        }


        //return $this->functions->getAstTree( $functionName, $paramAst );

        $ast = $this->functions->getAstTree( $functionName, $paramAst );
        return $ast;
   }




}
?>
