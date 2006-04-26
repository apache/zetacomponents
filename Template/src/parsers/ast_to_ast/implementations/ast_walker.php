<?php
/**
 * File containing the ezcTemplateAstWalker
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
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

    public function visitOutputAstNode( ezcTemplateOutputAstNode $type )
    {
        array_unshift( $this->nodePath, $type );

        $this->acceptAndUpdate( $type->expression );

        array_shift( $this->nodePath );
    }

    public function visitTypeCastAstNode( ezcTemplateTypeCastAstNode $node )
    {
        array_unshift( $this->nodePath, $node );
        $this->acceptAndUpdate( $node->value );
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
        $this->acceptAndUpdate( $var->nameExpression );
        array_shift( $this->nodePath );
    }

    public function visitDynamicStringAstNode( ezcTemplateDynamicStringAstNode $dynamic )
    {
        die("TODO: dynamicstring Ast node , tree walker");

        array_unshift( $this->nodePath, $dynamic );
        foreach ( $parameters as $parameter )
        {
            if ( !$parameter instanceof ezcTemplateLiteralAstNode )
            {
                $this->acceptAndUpdate( $parameter );
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
            $this->acceptAndUpdate( $operator->parameters[$i] );
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

        $this->acceptAndUpdate( $operator->parameters[0] );
       
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
        $this->acceptAndUpdate( $operator->parameters[0] );
        $this->acceptAndUpdate( $operator->parameters[1] );
        array_shift( $this->nodePath );
    }

    public function visitFunctionCallAstNode( ezcTemplateFunctionCallAstNode $fcall )
    {
        array_unshift( $this->nodePath, $fcall );
        foreach ( $fcall->getParameters() as $i => $parameter )
        {
            $this->acceptAndUpdate( $fcall->parameters[$i] );
        }
        array_shift( $this->nodePath );
    }

    public function visitDynamicFunctionCallAstNode( ezcTemplateDynamicFunctionCallAstNode $fcall )
    {

        array_unshift( $this->nodePath, $fcall );
        $this->acceptAndUpdate( $fcall->nameExpression );

        foreach ( $fcall->getParameters() as $i => $parameter )
        {
            $this->acceptAndUpdate( $fcall->parameters[$i] ); 
        }

        array_shift( $this->nodePath );
    }

    public function visitBodyAstNode( ezcTemplateBodyAstNode $body )
    {
        array_unshift( $this->nodePath, $body );

        for( $i = 0; $i < sizeof( $body->statements ); $i++)
        {
            $this->acceptAndUpdate( $body->statements[$i] );
        }
/*
        foreach ( $body->statements as $statement )
        {
            $ret = $statement->accept( $this );
        }
        */
        array_shift( $this->nodePath );
    }

    public function visitGenericStatementAstNode( ezcTemplateGenericStatementAstNode $statement )
    {
        array_unshift( $this->nodePath, $statement );

        $this->acceptAndUpdate( $statement->expression );

        array_shift( $this->nodePath );
    }

    public function visitIfAstNode( ezcTemplateIfAstNode $if )
    {
        array_unshift( $this->nodePath, $if );

        foreach ( $if->conditions as $i => $conditionBody )
        {
            $condition = $conditionBody->condition;
            if ( $condition !== null )
            {
                $this->acceptAndUpdate( $if->conditions[$i]->condition );
            }

            $this->acceptAndUpdate( $conditionBody->body );
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

        $this->acceptAndUpdate( $conditionBody->condition );
        $this->acceptAndUpdate( $conditionBody->body );

        array_shift( $this->nodePath );
    }

    public function visitDoWhileAstNode( ezcTemplateDoWhileAstNode $while )
    {
        die(" Remove Do while ");

        array_unshift( $this->nodePath, $while );
        $conditionBody = $while->conditionBody;
        $conditionBody->body->accept( $this );
        $conditionBody->condition->accept( $this );
        array_shift( $this->nodePath );
    }

    public function visitForAstNode( ezcTemplateForAstNode $for )
    {
        die(" Remove FOR ");

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

        $this->acceptAndUpdate( $foreach->arrayExpression );

        if ( $foreach->keyVariable !== null )
        {
            $this->acceptAndUpdate( $foreach->keyVariable );
        }

        $this->acceptAndUpdate( $foreach->valueVariable );
        $this->acceptAndUpdate( $foreach->body );

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

        $this->acceptAndUpdate( $switch->expression );

        foreach ( $switch->cases as $key => $case )
        {
            $this->acceptAndUpdate( $case );
        }
        array_shift( $this->nodePath );
    }

    public function visitCaseAstNode( ezcTemplateCaseAstNode $case )
    {
        array_unshift( $this->nodePath, $case );
        $this->acceptAndUpdate( $case->match );
        $this->acceptAndUpdate( $case->body );
        array_shift( $this->nodePath );
    }

    public function visitDefaultAstNode( ezcTemplateDefaultAstNode $default )
    {
        array_unshift( $this->nodePath, $default );
        $this->acceptAndUpdate( $default->body );
        array_shift( $this->nodePath );
    }

    public function visitConditionBodyAstNode( ezcTemplateConditionBodyAstNode $cond )
    {
    }

    public function visitTryAstNode( ezcTemplateTryAstNode $try )
    {
        array_unshift( $this->nodePath, $try );
        $try->body->accept( $this );
        $this->acceptAndUpdate( $try->body );

        foreach ( $try->catches as $key => $catch )
        {
            $this->acceptAndUpdate( $try->catches[$key] );
        }
        array_shift( $this->nodePath );
    }

    public function visitCatchAstNode( ezcTemplateCatchAstNode $catch )
    {
        array_unshift( $this->nodePath, $catch );

        $this->acceptAndUpdate( $catch->variableExpression );
        $this->acceptAndUpdate( $catch->body );

        array_shift( $this->nodePath );
    }

    public function visitEchoAstNode( ezcTemplateEchoAstNode $echo )
    {
        array_unshift( $this->nodePath, $echo );
        $outputList = $echo->getOutputList();
        foreach ( $outputList as $i => $output )
        {
            $this->acceptAndUpdate( $echo->outputList[$i] );
        }
        array_shift( $this->nodePath );
    }

    public function visitPrintAstNode( ezcTemplatePrintAstNode $print )
    {
        array_unshift( $this->nodePath, $print );
        $this->acceptAndUpdate( $print->expression );
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
        $this->acceptAndUpdate( $empty->expression );
        array_shift( $this->nodePath );
    }

    public function visitParenthesisAstNode( ezcTemplateParenthesisAstNode $parenthesis )
    {
        array_unshift( $this->nodePath, $parenthesis );
        $this->acceptAndUpdate( $parenthesis->expression );
        array_shift( $this->nodePath );
    }

    public function visitCurlyBracesAstNode( ezcTemplateCurlyBracesAstNode $curly )
    {
        array_unshift( $this->nodePath, $curly );
        $this->acceptAndUpdate( $parenthesis->expression );
        array_shift( $this->nodePath );
    }

    public function visitIdentifierAstNode( ezcTemplateIdentifierAstNode $node )
    {
    }

    public function visitNewAstNode( ezcTemplateNewAstNode $node )
    {
    }

    public function visitCloneAstNode( ezcTemplateCloneAstNode $node )
    {
    }


    public function visitNopAstNode( ezcTemplateNopAstNode $node )
    {
    }

    protected function acceptAndUpdate( ezcTemplateAstNode &$node )
    {
        $ret = $node->accept( $this );
        if( $ret !== null ) $node = $ret;
    }
}
?>
