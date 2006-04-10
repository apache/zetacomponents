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

    const TYPE_ARRAY = 1;
    const TYPE_VALUE = 2;

    public function __construct( $parser )
    {
        $this->functions = new ezcTemplateFunctions();
        $this->type = self::TYPE_ARRAY | self::TYPE_VALUE;
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
        
        $node->appendParameter( $type->parameters[ $currentParameterNumber ]->accept( $this ) );

        $currentParameterNumber++;

        if( $currentParameterNumber == sizeof( $type->parameters ) - 1 ) 
        {
            // The last node.
            $node->appendParameter( $type->parameters[ $currentParameterNumber ]->accept( $this ) );
        }
        else
        {
            // More than two parameters, so repeat.
            $node->appendParameter( $this->appendOperatorRecursively( $type, $astNode, $currentParameterNumber ) );
        }

        return $node;
    }

    private function createBinaryOperatorAstNode( $type, ezcTemplateOperatorAstNode $astNode, $addParenthesis = true )
    {
        $astNode->appendParameter( $type->parameters[0]->accept( $this ));

        if( !isset( $type->parameters[1] ) )
        {
            // TODO>
            var_dump ($type );
        }

        $astNode->appendParameter( $type->parameters[1]->accept( $this ));

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
            $cb->call ("echo", $cb->variable( "_ezcTemplate_output" ) );
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
        return new ezcTemplateParenthesisAstNode( $expression );
    }

    public function visitOutputBlockTstNode( ezcTemplateOutputBlockTstNode $type )
    {
        $expression = $type->expressionRoot->accept( $this ); 
        $output = new ezcTemplateOutputAstNode( $expression );

        return $this->assignToOutput( $output );
        //return new ezcTemplateEchoAstNode( array( $expression ) );
    }

    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $type )
    {
        $expression = $type->expressionRoot->accept( $this ); 
        return  new ezcTemplateGenericStatementAstNode( $expression );
    }

    public function visitLiteralTstNode( ezcTemplateLiteralTstNode $type )
    {
        $this->type = (is_array( $type->value ) ? self::TYPE_ARRAY : self::TYPE_VALUE );
        return new ezcTemplateLiteralAstNode( $type->value );
    }

    public function visitIntegerTstNode( ezcTemplateIntegerTstNode $type )
    {
        die("visitIntegerTstNode");
    }

    public function visitVariableTstNode( ezcTemplateVariableTstNode $type )
    {
        // Don't do array or value checking for variables.. (yet).
        $this->type = self::TYPE_ARRAY | self::TYPE_VALUE;

        if( !$this->noProperty && $this->parser->symbolTable->retrieve( $type->name ) == ezcTemplateSymbolTable::CYCLE ) 
        {
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
        $paramAst = array();
        foreach( $type->parameters as $parameter )
        {
            $paramAst[] = $parameter->accept( $this );
        }

        $this->type = self::TYPE_ARRAY | self::TYPE_VALUE;
        return $this->functions->getAstTree( $type->name, $paramAst );
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
            if( !($this->type & self::TYPE_ARRAY) )
            {
                throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ARRAY );
            }

            $params[] = $type->offset->accept( $this );

            $astNode[$i]->arrayExpression = $this->functions->getAstTree( "array_remove_first", $params);
        }
        else
        {
            $astNode[$i]->arrayExpression = $type->array->accept( $this );

            if( !($this->type & self::TYPE_ARRAY) )
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

        // STRANGE name, break, continue
        throw new ezcTemplateParserException( $type->source, $type->startCursor, $type->startCursor, "Unhandled loop control name: " . $type->name );
    }

    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $type )
    {
        $astNode = new ezcTemplateObjectAccessOperatorAstNode();
        $astNode->appendParameter( $type->parameters[0]->accept( $this ));
        $astNode->appendParameter( new ezcTemplateCurlyBracesAstNode( $type->parameters[1]->accept( $this ) ) );

        return $astNode;

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
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateEqualOperatorAstNode() );
    }

    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateNotEqualOperatorAstNode() );
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
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateAssignmentOperatorAstNode(), false );
    }

    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateAdditionAssignmentOperatorAstNode(), false );
    }

    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateSubtractionAssignmentOperatorAstNode(), false );
    }

    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateMultiplicationAssignmentOperatorAstNode(), false );
    }

    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateDivisionAssignmentOperatorAstNode(), false );
    }

    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateConcatAssignmentOperatorAstNode(), false );
    }

    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $type )
    {
        return $this->createBinaryOperatorAstNode( $type, new ezcTemplateModulusAssignmentOperatorAstNode(), false );
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

            //$b = new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( $var, array( $type->expression->accept($this ) ) ) ); 

            $expression = $type->expression === null ? new ezcTemplateConstantAstNode( "NULL") : $type->expression->accept($this);
            $b =  new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $type->variable->accept($this), $expression ) );
            

            return array($a, $b); // array( $a, $b );
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



    public function visitArrayRangeOperatorTstNode( ezcTemplateArrayRangeOperatorTstNode $type ) 
    {
        return $this->appendFunctionCallRecursively( $type, "array_fill_range", true );
    }

    private function appendFunctionCallRecursively( ezcTemplateOperatorTstNode $type, $functionName, $checkNonArray = false, $currentParameterNumber = 0)
    {
        $paramAst = array();

        $paramAst[] = $type->parameters[ $currentParameterNumber ]->accept( $this );
        if( $checkNonArray && !( $this->type & self::TYPE_VALUE ) )
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

        if( $checkNonArray && !( $this->type & self::TYPE_VALUE ) )
        {
            throw new ezcTemplateParserException( $type->source, $type->parameters[$currentParameterNumber]->startCursor, 
                $type->parameters[$currentParameterNumber]->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VALUE_NOT_ARRAY );
        }



        $this->type = self::TYPE_ARRAY;
        return $this->functions->getAstTree( $functionName, $paramAst );
   }




}
?>
