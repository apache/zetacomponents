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


    public function visitBlockTstNode( ezcTemplateBlockTstNode $type ) 
    {
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
            $this->rootNode = new ezcTemplateBodyAstNode();

            foreach( $type->elements as $element )
            {
                $this->rootNode->appendStatement( new ezcTemplateEchoAstNode( array( $element->accept( $this ) ) ) );
            }
        }
        else
        {
            die ("PANIC, root node is not null ");
        }


        /*
        if( $this->rootNode === null )
        {
            $this->rootNode = new ezcTemplateBodyAstNode();

            $this->push( $this->rootNode );
        }
        else
        {
            die( "Multiple root nodes?" );
        }

        foreach( $type->elements as $element )
        {
            // Point to the root node;
            $this->currentNode = $this->rootNode;

            $element->accept( $this );
        }
        */
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
        die("visitVariableTstNode");
    }

    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $type )
    {
        // Add a text entry.
        $type =  new ezcTemplateTypeAstNode( $type->text );
        return $type;
        //$echo = new ezcTemplateEchoAstNode( array( new ezcTemplateTypeAstNode( $type->text ) ) );
        //return $echo;
    }

    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $type )
    {
        die("visitFunctionCallTstNode");
    }

    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $type )
    {
        die("visitDocCommentTstNode");
    }

    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $type )
    {
        die("visitBlockCommentTstNode");
    }

    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $type )
    {
        die("visitEolCommentTstNode");
    }

    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $type )
    {
        die("visitForeachLoopTstNode");
    }

    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $type )
    {
        die ("visitWhileLoopTstNode");
    }

    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $type )
    {
        die ("visitIfConditionTstNode");
    }

    public function visitLoopTstNode( ezcTemplateLoopTstNode $type )
    {
        die ("visitLoopTstNode");
    }

    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $type )
    {
        die ("visitPropertyFetchOperatorTstNode");
    }

    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $type )
    {
        die("visitArrayFetchOperatorTstNode");
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
        $equal = new ezcTemplateEqualOperatorAstNode();
        $equal->appendParameter( $type->parameters[0]->accept( $this ));
        $equal->appendParameter( $type->parameters[1]->accept( $this ));

        return new ezcTemplateParenthesisAstNode( $equal );
    }

    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $type )
    {
        $equal = new ezcTemplateNotEqualOperatorAstNode();
        $equal->appendParameter( $type->parameters[0]->accept( $this ));
        $equal->appendParameter( $type->parameters[1]->accept( $this ));

        return new ezcTemplateParenthesisAstNode( $equal );
    }

    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $type )
    {
        die ("visitIdenticalOperatorTstNode");
    }

    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $type )
    {
        die ("visitNotIdenticalOperatorTstNode");
    }

    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $type )
    {
        die ("visitLessThanOperatorTstNode");
    }

    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $type )
    {
        die ("visitGreaterThanOperatorTstNode");
    }

    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $type )
    {
        die ("visitLessEqualOperatorTstNode");
    }

    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $type )
    {
        die ("visitGreaterEqualOperatorTstNode");
    }

    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $type )
    {
        die ("visitLogicalAndOperatorTstNode");
    }

    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $type )
    {
        die ("visitLogicalOrOperatorTstNode");
    }

    public function visitConditionalOperatorTstNode( ezcTemplateConditionalOperatorTstNode $type )
    {
        die ("visitConditionalOperatorTstNode");
    }

    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $type )
    {
        die ("visitAssignmentOperatorTstNode");
    }

    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $type )
    {
        die ("visitPlusAssignmentOperatorTstNode");
    }

    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $type )
    {
        die ("visitMinusAssignmentOperatorTstNode");
    }

    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $type )
    {
        die ("visitMultiplicationAssignmentOperatorTstNode");
    }

    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $type )
    {
        die ("visitDivisionAssignmentOperatorTstNode");
    }

    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $type )
    {
        die("visitConcatAssignmentOperatorTstNode");
    }

    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $type )
    {
        die ("visitModuloAssignmentOperatorTstNode");
    }

    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $type )
    {
        die ("visitPreIncrementOperatorTstNode");
    }

    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $type )
    {
        die ("visitPreDecrementOperatorTstNode");
    }

    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $type )
    {
        die ("visitPostIncrementOperatorTstNode");
    }

    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $type )
    {
        die ("visitPostDecrementOperatorTstNode");
    }

    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $type )
    {
        die ("visitNegateOperatorTstNode");
    }

    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $type )
    {
        die ("visitLogicalNegateOperatorTstNode");
    }

    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $type )
    {
        die ("visitInstanceOfOperatorTstNode");
    }

}
?>
