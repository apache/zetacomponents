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



    public function visitBlockTstNode( ezcTemplateBlockTstNode $type ) 
    {
    }


    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $type )
    {
    }


    public function visitRootTstNode( ezcTemplateRootTstNode $type )
    {
        if ( $this->rootNode === null )
        {
            $this->rootNode = new ezcTemplateBodyAstNode();

            foreach( $type->elements as $element )
            {
                //var_dump ($element );
                
                $this->rootNode->appendStatement( $element->accept( $this ) );
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
    }

    public function visitExpressionBlockTstNode( ezcTemplateExpressionBlockTstNode $type )
    {
        //$lastElement = $this->last();

        // Append an echo.
        // TODO: It's probably a generic statement.

        $expression = $type->element->accept( $this ); 

        $echo = new ezcTemplateEchoAstNode( array( $expression ) );// array( new ezcTemplateTypeAstNode( $type->text ) ) );

        return $echo;
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
    }

    public function visitVariableTstNode( ezcTemplateVariableTstNode $type )
    {
    }

    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $type )
    {
        // Add a text entry.
        $echo = new ezcTemplateEchoAstNode( array( new ezcTemplateTypeAstNode( $type->text ) ) );

        return $echo;
    }

    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $type )
    {
    }

    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $type )
    {
    }

    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $type )
    {
    }

    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $type )
    {
    }

    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $type )
    {
    }

    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $type )
    {
    }

    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $type )
    {
    }

    public function visitLoopTstNode( ezcTemplateLoopTstNode $type )
    {
    }

    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $type )
    {
    }

    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $type )
    {
    }

    // return ezcTemplateTstNode;
    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $type )
    {
        /*
        $this->last()->append( $plus );
        $this->push( $plus );
        */

        $plus = new ezcTemplateAdditionOperatorAstNode();// array( new ezcTemplateTypeAstNode( $type->text ) ) );

        $a = $type->parameters[0]->accept( $this );
        $b = $type->parameters[1]->accept( $this );

        $plus->appendParameter( $a );
        $plus->appendParameter( $b );

        return $plus;


        //appendParameter( 1, 2 );

        /*
        $type->element->accept( $this );


        // Add a text entry.
        $echo = new ezcTemplateEchoAstNode( array( new ezcTemplateTypeAstNode( $type->text ) ) );
        $currentNode = $this->last();
        $currentNode->appendStatement( $echo );
        */

    }

    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $type )
    {
    }

    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $type )
    {
    }

    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $type )
    {
    }

    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $type )
    {
    }

    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $type )
    {
    }

    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $type )
    {
    }

    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $type )
    {
    }

    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $type )
    {
    }

    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $type )
    {
    }

    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $type )
    {
    }

    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $type )
    {
    }

    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $type )
    {
    }

    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $type )
    {
    }

    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $type )
    {
    }

    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $type )
    {
    }

    public function visitConditionalOperatorTstNode( ezcTemplateConditionalOperatorTstNode $type )
    {
    }

    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $type )
    {
    }

    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $type )
    {
    }

    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $type )
    {
    }

    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $type )
    {
    }

    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $type )
    {
    }

    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $type )
    {
    }

    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $type )
    {
    }

    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $type )
    {
    }

    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $type )
    {
    }

    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $type )
    {
    }

    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $type )
    {
    }

    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $type )
    {
    }

    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $type )
    {
    }

    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $type )
    {
    }

}
?>
