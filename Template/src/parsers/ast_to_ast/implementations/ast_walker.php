<?php
/**
 * File containing the ezcTemplateAstWalker
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * The entire AST tree, doing nothing.
 * 
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateAstWalker implements ezcTemplateAstNodeVisitor
{

    public $nodePath = array(); 

    public function __construct( )
    {
    }

    public function __destruct()
    {
    }

    public function visitLiteralAstNode( ezcTemplateLiteralAstNode $type )
    {
    }

    public function visitTextAstNode( ezcTemplateTextAstNode $type )
    {
    }

    public function visitTypeCastAstNode( ezcTemplateTypeCastAstNode $node )
    {
        array_unshift( $this->nodePath, $node );
        $node->value->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitConstantAstNode( ezcTemplateConstantAstNode $type )
    {
    }

    public function visitEolCommentAstNode( ezcTemplateEolCommentAstNode $comment )
    {
    }

    public function visitBlockCommentAstNode( ezcTemplateBlockCommentAstNode $comment )
    {
    }

    public function visitVariableAstNode( ezcTemplateVariableAstNode $var )
    {
    }

    public function visitDynamicVariableAstNode( ezcTemplateDynamicVariableAstNode $var )
    {
        array_unshift( $this->nodePath, $var );
        $var->nameExpression->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitDynamicStringAstNode( ezcTemplateDynamicStringAstNode $dynamic )
    {
        array_unshift( $this->nodePath, $dynamic );
        foreach ( $parameters as $parameter )
        {
            if ( !$parameter instanceof ezcTemplateLiteralAstNode )
            {
                $parameter->accept( $this );
            }
        }
        array_shift( $this->nodePath );
    }

    public function visitArrayFetchOperatorAstNode( ezcTemplateArrayFetchOperatorAstNode $operator )
    {
        array_unshift( $this->nodePath, $operator );
        $parameters = $operator->getParameters();
        $count = count( $parameters );
        for ( $i = 0; $i < $count; ++$i )
        {
            $parameters[$i]->accept( $this );
        }
        array_shift( $this->nodePath );
    }

    public function visitUnaryOperatorAstNode( ezcTemplateOperatorAstNode $operator )
    {
        $parameters = $operator->getParameters();
        if ( count( $parameters ) < $operator->minParameterCount )
        {
            throw new Exception( "The operator <" . get_class( $operator ) . " contains only " . count( $parameters ) . " parameters but should at least have {$operator->minParameterCount} parameters." );
        }

        array_unshift( $this->nodePath, $operator );
        $parameters[0]->accept( $this );
        array_shift( $this->nodePath );

    }

    public function visitBinaryOperatorAstNode( ezcTemplateOperatorAstNode $operator )
    {
        $parameters = $operator->getParameters();
        if ( count( $parameters ) < $operator->minParameterCount )
        {
            throw new Exception( "The operator <" . get_class( $operator ) . " contains only " . count( $parameters ) . " parameters but should at least have {$operator->minParameterCount} parameters." );
        }

        array_unshift( $this->nodePath, $operator );
        $parameters[0]->accept( $this );
        $parameters[1]->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitFunctionCallAstNode( ezcTemplateFunctionCallAstNode $fcall )
    {
        array_unshift( $this->nodePath, $fcall );
        foreach ( $fcall->getParameters() as $i => $parameter )
        {
            $parameter->accept( $this );
        }
        array_shift( $this->nodePath );
    }

    public function visitDynamicFunctionCallAstNode( ezcTemplateDynamicFunctionCallAstNode $fcall )
    {

        array_unshift( $this->nodePath, $fcall );
        $fcall->nameExpression->accept( $this );

        foreach ( $fcall->getParameters() as $i => $parameter )
        {
            $parameter->accept( $this );
        }

        array_shift( $this->nodePath );
    }

    public function visitBodyAstNode( ezcTemplateBodyAstNode $body )
    {
        array_unshift( $this->nodePath, $body );
        foreach ( $body->statements as $statement )
        {
            $statement->accept( $this );
        }
        array_shift( $this->nodePath );
    }

    public function visitGenericStatementAstNode( ezcTemplateGenericStatementAstNode $statement )
    {
        array_unshift( $this->nodePath, $statement );
        $statement->expression->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitIfAstNode( ezcTemplateIfAstNode $if )
    {
        array_unshift( $this->nodePath, $statement );
        foreach ( $if->conditions as $i => $conditionBody )
        {
            $condition = $conditionBody->condition;
            if ( $condition !== null )
            {
                $condition->accept( $this );
            }

            $conditionBody->body->accept( $this );
        }
        array_shift( $this->nodePath );
    }

    /**
     * Visits a code element containing while control structures.
     *
     * @param ezcTemplateWhileAstNode $while The code element containing the while control structure.
     */
    public function visitWhileAstNode( ezcTemplateWhileAstNode $while )
    {
        array_unshift( $this->nodePath, $while );
        $conditionBody = $while->conditionBody;
        $conditionBody->condition->accept( $this );

        $conditionBody->body->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitDoWhileAstNode( ezcTemplateDoWhileAstNode $while )
    {
        array_unshift( $this->nodePath, $while );
        $conditionBody = $while->conditionBody;
        $conditionBody->body->accept( $this );
        $conditionBody->condition->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitForAstNode( ezcTemplateForAstNode $for )
    {
        array_unshift( $this->nodePath, $for );
        $for->initial->accept( $this );
        $for->condition->accept( $this );
        $for->iteration->accept( $this );

        $for->body->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitForeachAstNode( ezcTemplateForeachAstNode $foreach )
    {
        array_unshift( $this->nodePath, $foreach );
        $foreach->arrayExpression->accept( $this );
        if ( $foreach->keyVariable !== null )
        {
            $foreach->keyVariable->accept( $this );
        }
        $foreach->valueVariable->accept( $this );
        $foreach->body->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitBreakAstNode( ezcTemplateBreakAstNode $break )
    {
    }

    public function visitContinueAstNode( ezcTemplateContinueAstNode $continue )
    {
    }

    public function visitReturnAstNode( ezcTemplateReturnAstNode $return )
    {
    }

    public function visitRequireAstNode( ezcTemplateRequireAstNode $require )
    {
    }

    public function visitRequireOnceAstNode( ezcTemplateRequireOnceAstNode $require )
    {
    }

    public function visitIncludeAstNode( ezcTemplateIncludeAstNode $include )
    {
    }

    public function visitIncludeOnceAstNode( ezcTemplateIncludeOnceAstNode $include )
    {
    }

    public function visitSwitchAstNode( ezcTemplateSwitchAstNode $switch )
    {
        array_unshift( $this->nodePath, $switch );
        $switch->expression->accept( $this );
        foreach ( $switch->cases as $case )
        {
            $case->accept( $this );
        }
        array_shift( $this->nodePath );
    }

    public function visitCaseAstNode( ezcTemplateCaseAstNode $case )
    {
        array_unshift( $this->nodePath, $case );
        $case->match->accept( $this );
        $case->body->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitDefaultAstNode( ezcTemplateDefaultAstNode $default )
    {
        array_unshift( $this->nodePath, $default );
        $default->body->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitConditionBodyAstNode( ezcTemplateConditionBodyAstNode $cond )
    {
    }

    public function visitTryAstNode( ezcTemplateTryAstNode $try )
    {
        array_unshift( $this->nodePath, $try );
        $try->body->accept( $this );

        foreach ( $try->catches as $catch )
        {
            $catch->accept( $this );
        }
        array_shift( $this->nodePath );
    }

    public function visitCatchAstNode( ezcTemplateCatchAstNode $catch )
    {
        array_unshift( $this->nodePath, $catch );
        $catch->variableExpression->accept( $this );
        $catch->body->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitEchoAstNode( ezcTemplateEchoAstNode $echo )
    {
        array_unshift( $this->nodePath, $echo );
        $outputList = $echo->getOutputList();
        foreach ( $outputList as $i => $output )
        {
            $output->accept( $this );
        }
        array_shift( $this->nodePath );
    }

    public function visitPrintAstNode( ezcTemplatePrintAstNode $print )
    {
        array_unshift( $this->nodePath, $print );
        $print->expression->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitIssetAstNode( ezcTemplateIssetAstNode $isset )
    {
    }

    public function visitUnsetAstNode( ezcTemplateUnsetAstNode $unset )
    {
    }

    public function visitEmptyAstNode( ezcTemplateEmptyAstNode $empty )
    {
        array_unshift( $this->nodePath, $empty );
        $empty->expression->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitParenthesisAstNode( ezcTemplateParenthesisAstNode $parenthesis )
    {
        array_unshift( $this->nodePath, $parenthesis );
        $parenthesis->expression->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitCurlyBracesAstNode( ezcTemplateCurlyBracesAstNode $curly )
    {
        array_unshift( $this->nodePath, $curly );
        $curly->expression->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitNopAstNode( ezcTemplateNopAstNode $node )
    {
    }
}
?>
