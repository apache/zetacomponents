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
    public $rootNode = null;

    public $pathToCurrentNode = array();

    public $stackSize = 0; 

    public function __construct( )
    {
    }

    public function __destruct()
    {
    }

    public function push( $node )
    {
        array_push( $this->pathToCurrentNode, $this->rootNode );
        $this->stackSize++;
    }

    public function pop()
    {
        $this->stackSize--;
        return array_pop( $this->pathToCurrentNode );
    }

    public function last()
    {
        return $this->pathToCurrentNode[ $this->stackSize - 1];
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

        return new ezcTemplateEchoAstNode( array( $astNode ) );
    }

    private function createBody( array $elements )
    {
        $body = new ezcTemplateBodyAstNode();

        foreach( $elements as $element )
        {
            $astNode = $element->accept( $this );

            if( $this->isAssignmentNode( $astNode ) )
            {
                // Assignments are just a generic statements, which don't need echo-ing.
                $body->appendStatement( new ezcTemplateGenericStatementAstNode( $astNode ) );
            }
            elseif ( $astNode instanceof ezcTemplateStatementAstNode )
            {
                // Statements don't need echoing, and are not generic.
                $body->appendStatement($astNode );
            }
            else
            {
                // Expressions need a echo.
                $body->appendStatement( new ezcTemplateEchoAstNode( array( $astNode  ) ) );
            }
        }

        return $body;
    }


    public function visitBlockTstNode( ezcTemplateBlockTstNode $type ) 
    {
        // Should be abstract.
        die("visitBlockTstNode");
    }

    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $type )
    {
        die("visitCustomTstNode");
    }

    public function visitRootTstNode( ezcTemplateRootTstNode $type )
    {
        if ( $this->rootNode === null )
        {
            $this->rootNode = $this->createBody( $type->elements );
        }
        else
        {
            die ("PANIC, root node is not null ");
        }
    }

    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $type )
    {
        die ("visitLiteralBlockTstNode");
    }

    public function visitExpressionBlockTstNode( ezcTemplateExpressionBlockTstNode $type )
    {
        $expression = $type->expressionRoot->accept( $this ); 

        return $expression;
/*

        $lastElement->appendStatement( $echo );

        $this->push( $echo );

        $type->element->accept( $this );
        */
    }

    public function visitTypeTstNode( ezcTemplateTypeTstNode $type )
    {
        return new ezcTemplateTypeAstNode( $type->value );
    }

    public function visitIntegerTstNode( ezcTemplateIntegerTstNode $type )
    {
        die("visitIntegerTstNode");
    }

    public function visitVariableTstNode( ezcTemplateVariableTstNode $type )
    {
        return new ezcTemplateVariableAstNode( $type->name );
    }

    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $type )
    {
        $echo = new ezcTemplateEchoAstNode( array( new ezcTemplateTypeAstNode( $type->text ) ) );
        return $echo;
    }

    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $type )
    {
        die("visitFunctionCallTstNode");
    }

    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $type )
    {
        return new ezcTemplateBlockCommentAstNode ( $type->commentText );
    }

    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $type )
    {
        // NOT USED.
        die("visitBlockCommentTstNode");
    }

    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $type )
    {
        // NOT USED.
        die("visitEolCommentTstNode");
    }

    /** 
     * TST:
     * [Foreach]
     *  TypeTstNode array
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
        $astNode = new ezcTemplateForeachAstNode();

        $astNode->arrayExpression = $type->array->accept( $this );

        if( $type->keyVariableName  !== null )
        {
            $astNode->keyVariable = new ezcTemplateVariableAstNode( $type->keyVariableName );
        }

        $astNode->valueVariable = new ezcTemplateVariableAstNode( $type->itemVariableName );

        $astNode->body = $this->createBody( $type->elements );

        return $astNode;
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

        // First condition, the 'if'.
        $if = new ezcTemplateConditionBodyAstNode();
        $if->condition = $type->condition->accept( $this );
        $if->body = $this->addOutputNodeIfNeeded( $type->elements[0]->accept( $this ) );
        $astNode->conditions[0] = $if;

        // Second condition, the 'elseif'.
        /*
        if( count( $type->elements ) == 3 )
        {
            $elseif = new ezcTemplateConditionBodyAstNode();
            $elseif->body = $this->addOutputNodeIfNeeded( $type->elements[1]->accept( $this ) );
            $astNode->conditions[1] = $else;

        }
        */

        if( isset( $type->elements[1] ) )
        {
            var_dump ( $type->condition );
            $else = new ezcTemplateConditionBodyAstNode();
            $else->body = $this->addOutputNodeIfNeeded( $type->elements[1]->accept( $this ) );
            $astNode->conditions[2] = $else;
        }

        return $astNode;
    }

    public function visitLoopTstNode( ezcTemplateLoopTstNode $type )
    {
        // STRANGE name, break, continue
        die ("visitLoopTstNode");
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

    public function visitConditionalOperatorTstNode( ezcTemplateConditionalOperatorTstNode $type )
    {
        die ("visitConditionalOperatorTstNode");
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
        die ("visitNegateOperatorTstNode");
    }

    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $type )
    {
        return $this->createUnaryOperatorAstNode( $type, new ezcTemplateLogicalNegationOperatorAstNode(), false );
    }

    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $type )
    {
        die ("visitInstanceOfOperatorTstNode");
    }

}
?>
