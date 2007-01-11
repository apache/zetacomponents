<?php
/**
 * File containing the ezcTemplateAstWalker
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * The entire AST tree, doing nothing.
 * 
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateAstWalker implements ezcTemplateAstNodeVisitor
{

    /**
     * A stack that keeps the path of nodes to the current position.  The first element (0) contains the last 
     * executed node. The second element, the second last node, etc.
     *
     * @var array(ezcTemplateAstNode)
     */
    public $nodePath = array(); 


    /**
     * The amount of statements in the last, second last, etc. position / level.
     *
     * @var array(int)
     */
    public $statements = array();

    /**
     * The offset of the statements. Default it's 0. When a statement is inserted, the offset should also increase.
     *
     * @var array(int)
     */
    public $offset = array();

    public function __construct( )
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return void
     */
    public function visitLiteralAstNode( ezcTemplateLiteralAstNode $type )
    {
    }

    /**
     * @return void
     */
    public function visitLiteralArrayAstNode( ezcTemplateLiteralArrayAstNode $type )
    {
    }


    /**
     * @return void
     */
    public function visitOutputAstNode( ezcTemplateOutputAstNode $type )
    {
        array_unshift( $this->nodePath, $type );

        $this->acceptAndUpdate( $type->expression );

        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitTypeCastAstNode( ezcTemplateTypeCastAstNode $node )
    {
        array_unshift( $this->nodePath, $node );
        $this->acceptAndUpdate( $node->value );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitConstantAstNode( ezcTemplateConstantAstNode $type )
    {
    }

    /**
     * @return void
     */
    public function visitEolCommentAstNode( ezcTemplateEolCommentAstNode $comment )
    {
    }

    /**
     * @return void
     */
    public function visitBlockCommentAstNode( ezcTemplateBlockCommentAstNode $comment )
    {
    }

    /**
     * @return void
     */
    public function visitVariableAstNode( ezcTemplateVariableAstNode $var )
    {
    }

    /**
     * @return void
     */
    public function visitDynamicVariableAstNode( ezcTemplateDynamicVariableAstNode $var )
    {
        array_unshift( $this->nodePath, $var );
        $this->acceptAndUpdate( $var->nameExpression );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitDynamicStringAstNode( ezcTemplateDynamicStringAstNode $dynamic )
    {
        throw new ezcTemplateInternalException( "TODO: dynamicstring Ast node , tree walker" );

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

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function visitUnaryOperatorAstNode( ezcTemplateOperatorAstNode $operator )
    {
        $parameters = $operator->getParameters();
        if ( count( $parameters ) < $operator->minParameterCount )
        {
            throw new ezcTemplateInternalException( "The operator <" . get_class( $operator ) . " contains only " . count( $parameters ) . " parameters but should at least have {$operator->minParameterCount} parameters." );
        }

        array_unshift( $this->nodePath, $operator );

        $this->acceptAndUpdate( $operator->parameters[0] );
       
        array_shift( $this->nodePath );

    }

    /**
     * @return void
     */
    public function visitBinaryOperatorAstNode( ezcTemplateOperatorAstNode $operator )
    {
        $parameters = $operator->getParameters();
        if ( count( $parameters ) < $operator->minParameterCount )
        {
            throw new ezcTemplateInternalException( "The operator <" . get_class( $operator ) . " contains only " . count( $parameters ) . " parameters but should at least have {$operator->minParameterCount} parameters." );
        }

        array_unshift( $this->nodePath, $operator );
        $this->acceptAndUpdate( $operator->parameters[0] );
        $this->acceptAndUpdate( $operator->parameters[1] );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
public function visitFunctionCallAstNode( ezcTemplateFunctionCallAstNode $fcall )
    {
        array_unshift( $this->nodePath, $fcall );
        foreach ( $fcall->getParameters() as $i => $parameter )
        {
            $this->acceptAndUpdate( $fcall->parameters[$i] );
        }
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitBodyAstNode( ezcTemplateBodyAstNode $body )
    {
        array_unshift( $this->nodePath, $body );
        array_unshift( $this->statements, 0);
        array_unshift( $this->offset, 0);

        $b = clone( $body );

        for( $i = 0; $i < sizeof( $b->statements ); $i++)
        {
            $this->statements[0] = $i;
            $this->acceptAndUpdate( $b->statements[$i]  );
        }

        $body = $b;

        array_shift( $this->offset );
        array_shift( $this->statements );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitRootAstNode( ezcTemplateRootAstNode &$body )
    {
        array_unshift( $this->nodePath, $body );
        array_unshift( $this->statements, 0);
        array_unshift( $this->offset, 0);

        $b = clone( $body );

        for( $i = 0; $i < sizeof( $b->statements ); $i++)
        {
            $this->statements[0] = $i;
            $this->acceptAndUpdate( $b->statements[$i] );
        }

        // XXX Test this, this may be wrong.
        // $body = $b;

        array_shift( $this->offset );
        array_shift( $this->statements );
        array_shift( $this->nodePath );
    }


    /**
     * @return void
     */
    public function visitGenericStatementAstNode( ezcTemplateGenericStatementAstNode $statement )
    {
        array_unshift( $this->nodePath, $statement );

        $this->acceptAndUpdate( $statement->expression );

        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
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
     * @return void
     */
    public function visitDynamicBlockAstNode( ezcTemplateDynamicBlockAstNode $statement )
    {
        array_unshift( $this->nodePath, $statement );

        $this->acceptAndUpdate( $statement->body );

        array_shift( $this->nodePath );
    }


    /**
     * Visits a code element containing while control structures.
     *
     * @param ezcTemplateWhileAstNode $while The code element containing the while control structure.
     * @return void
     */
    public function visitWhileAstNode( ezcTemplateWhileAstNode $while )
    {
        array_unshift( $this->nodePath, $while );
        $conditionBody = $while->conditionBody;

        $this->acceptAndUpdate( $conditionBody->condition );
        $this->acceptAndUpdate( $conditionBody->body );

        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function visitBreakAstNode( ezcTemplateBreakAstNode $break )
    {
    }

    /**
     * @return void
     */
    public function visitContinueAstNode( ezcTemplateContinueAstNode $continue )
    {
    }

    /**
     * @return void
     */
    public function visitReturnAstNode( ezcTemplateReturnAstNode $return )
    {
    }

    /**
     * @return void
     */
    public function visitRequireAstNode( ezcTemplateRequireAstNode $require )
    {
    }

    /**
     * @return void
     */
    public function visitRequireOnceAstNode( ezcTemplateRequireOnceAstNode $require )
    {
    }

    /**
     * @return void
     */
    public function visitIncludeAstNode( ezcTemplateIncludeAstNode $include )
    {
    }

    /**
     * @return void
     */
    public function visitIncludeOnceAstNode( ezcTemplateIncludeOnceAstNode $include )
    {
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function visitCaseAstNode( ezcTemplateCaseAstNode $case )
    {
        array_unshift( $this->nodePath, $case );
        $this->acceptAndUpdate( $case->match );
        $this->acceptAndUpdate( $case->body );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitDefaultAstNode( ezcTemplateDefaultAstNode $default )
    {
        array_unshift( $this->nodePath, $default );
        $this->acceptAndUpdate( $default->body );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitConditionBodyAstNode( ezcTemplateConditionBodyAstNode $cond )
    {
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function visitCatchAstNode( ezcTemplateCatchAstNode $catch )
    {
        array_unshift( $this->nodePath, $catch );

        $this->acceptAndUpdate( $catch->variableExpression );
        $this->acceptAndUpdate( $catch->body );

        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function visitPrintAstNode( ezcTemplatePrintAstNode $print )
    {
        array_unshift( $this->nodePath, $print );
        $this->acceptAndUpdate( $print->expression );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitIssetAstNode( ezcTemplateIssetAstNode $isset )
    {
    }

    /**
     * @return void
     */
    public function visitUnsetAstNode( ezcTemplateUnsetAstNode $unset )
    {
    }

    /**
     * @return void
     */
    public function visitEmptyAstNode( ezcTemplateEmptyAstNode $empty )
    {
        array_unshift( $this->nodePath, $empty );
        $this->acceptAndUpdate( $empty->expression );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitParenthesisAstNode( ezcTemplateParenthesisAstNode $parenthesis )
    {
        array_unshift( $this->nodePath, $parenthesis );
        $this->acceptAndUpdate( $parenthesis->expression );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitCurlyBracesAstNode( ezcTemplateCurlyBracesAstNode $curly )
    {
        array_unshift( $this->nodePath, $curly );
        $this->acceptAndUpdate( $parenthesis->expression );
        array_shift( $this->nodePath );
    }

    /**
     * @return void
     */
    public function visitIdentifierAstNode( ezcTemplateIdentifierAstNode $node )
    {
    }

    /**
     * @return void
     */
    public function visitNewAstNode( ezcTemplateNewAstNode $node )
    {
    }

    /**
     * @return void
     */
    public function visitCloneAstNode( ezcTemplateCloneAstNode $node )
    {
    }

    /**
     * @return void
     */
    public function visitPhpCodeAstNode( ezcTemplatePhpCodeAstNode $node )
    {
    }

    /**
     * @return void
     */
    public function visitThrowExceptionAstNode( ezcTemplateThrowExceptionAstNode $node )
    {
        array_unshift( $this->nodePath, $node );
        $this->acceptAndUpdate( $node->message );
        array_shift( $this->nodePath );
    }


    /**
     * @return void
     */
    public function visitNopAstNode( ezcTemplateNopAstNode $node )
    {
    }

    /**
     * @param ezcTemplateAstNode $node  Notice that the parameter will be changed.
     * @return void
     */
    protected function acceptAndUpdate( ezcTemplateAstNode &$node )
    {
        $ret = $node->accept( $this );
        if ( $ret !== null ) $node = $ret;
    }
}
?>
