<?php
/**
 * File containing the ezcTemplateConditionalOperatorSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for conditional choice expressions.
 *
 * An conditional operator looks like:
 * <code>
 * <condition> ? <result if true> : <result if false>
 * </code>
 * The condition will be evaluated and if true will use the first result
 * as the return value, and the second if false.
 *
 * This parser is needed to properly parse this operator since the generic
 * operator precedence is not enough. The problem comes from the fact that
 * the operator has two markers (? and :) which would be seen as two different
 * operators.
 *
 * When using the parser remember to start it  on the exact location of the
 * question mark (?), this is expected by the parser.
 * ie.
 * <code>
 * if ( $cursor->current() == "?" )
 * {
 *     $parser->parse( ... );
 * }
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateConditionalOperatorSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * State which reads in the branch for a true condition. This is the
     * starting state.
     */
    const STATE_TRUE_BRANCH = 1;
    /**
     * State which reads in the branch for a false condition.
     */
    const STATE_FALSE_BRANCH = 2;

    /**
     * The conditional element operator object if the parser was succesful.
     * @var ezcTemplateConditionalOperatorTstNodeElement
     */
    public $operator;

    /**
     * Passes control to parent and sets STATE_TRUE_BRANCH as the current state.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->state = self::STATE_TRUE_BRANCH;
    }

    /**
     * Figures out if the end as been reached and returns true if it has.
     *
     * The end is reached when it finds the character : when in
     * STATE_TRUE_BRANCH state or by checking the parent parser when in
     * STATE_FALSE_BRANCH state.
     */
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        if ( $this->parser->debug )
            echo "conditional::atEnd() state:<", var_export( $this->state, true ), "> current:<", $cursor->current(), ">@", $cursor->position, "\n";
        switch ( $this->state )
        {
            case self::STATE_TRUE_BRANCH:
            {
                if ( $cursor->current() == ':' )
                {
                    if ( !$finalize )
                        return true;

                    if ( $this->parser->debug )
                        echo "conditional::atEnd() state:<", var_export( $this->state, true ), "> at end due to :\n";
                    $this->fetch->endCursor = clone $operator->endCursor;
                    return true;
                }
                break;
            }
            case self::STATE_FALSE_BRANCH:
            {
                // There is no known end marker for the 'false' branch
                // Instead the expression parser will end the expression for
                // operators with less precedence or if the parent parser has
                // a known end marker.
                if ( $this->parentParser !== null )
                    return $this->parentParser->atEnd( $cursor, $operator, $finalize );
                break;
            }
            default:
                throw new Exception( "Illegal state reached in ezcTemplateConditionalOperatorSourceToTstParser::atEnd() with state value <" . var_export( $this->state, true ) . ">" );
        }
        if ( $this->parser->debug )
            echo "conditional::atEnd() state:<", var_export( $this->state, true ), "> not at end yet\n";
        return false;
    }

    /**
     * Parses the conditions by using the generic expression parser first when in
     * the STATE_TRUE_BRANCH state and then when in the STATE_FALSE_BRANCH state.
     *
     * The expression will callback the atEnd() function to figure out if the
     * end is reached or not.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( $this->parser->debug )
            echo "Starting a conditional operator parser ?:\n";

        // $cursor will be update as the parser continues
        $this->operator = $this->parser->createConditionalOperator( $this->startCursor, $cursor );

        // skip the ? character
        $cursor->advance();

        // Read expression for first state (STATE_TRUE_BRANCH).
        if ( $cursor->atEnd() )
        {
            return false;
        }

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // The expression should not stop yet
        if ( $this->atEnd( $cursor, null ) )
            return false;

        // Check for expression, the parser will call self::atEnd() to check for end of expression.
        $expressionParser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
        // Make sure it stops on operators with lower precedence than the
        // ?: operator.
        $expressionParser->minPrecedence = $this->operator->precedence;
        $expressionCursor = clone $cursor;
        if ( !$this->parseRequiredType( $expressionParser ) )
            return false;

        $rootOperator = $this->lastParser->currentOperator;
        if ( $rootOperator instanceof ezcTemplateOperatorTstNode )
        {
            $rootOperator = $rootOperator->getRoot();

            if ( $this->parser->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n conditional 'true' expression yielded:\n";
                echo ezcTemplateTstTreeDump::dump( $rootOperator );
                echo "\n\n\n";
                // *** DEBUG END ***
            }

        }
        elseif ( $rootOperator instanceof ezcTemplateTypeTstNode )
        {
            if ( $this->parser->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n conditional 'true' expression yielded:\n";
                echo "<", $rootOperator->value, ">\n";
                echo "\n\n\n";
                // *** DEBUG END ***
            }
        }
        $this->operator->appendParameter( $rootOperator );

        // ********** Next state ***********
        // Now check for next state (STATE_FALSE_BRANCH)

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // If the next marker is not a colon (:) it is a failed parse attempt
        if ( $cursor->current() != ':' )
        {
            if ( $this->parser->debug )
            {
                echo "Check for : failed\n";
                echo "<", $cursor->subString(), ">\n";
            }
            return false;
        }

        if ( $this->parser->debug )
            echo "Found conditional branch operator :\n";
        $cursor->advance();

        $this->state = self::STATE_FALSE_BRANCH;

        if ( $this->parser->debug )
            echo "next state <", $cursor->subString(), ">\n";

        // Check for expression, the parser will call self::atEnd() to check for end of expression.
        $expressionParser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
        // Make sure it stops on operators with lower precedence than the
        // ?: operator.
        $expressionParser->minPrecedence = $this->operator->precedence;
        $expressionCursor = clone $cursor;
        if ( !$this->parseRequiredType( $expressionParser ) )
            return false;

        $rootOperator = $this->lastParser->currentOperator;
        if ( $rootOperator instanceof ezcTemplateOperatorTstNode )
        {
            $rootOperator = $rootOperator->getRoot();

            if ( $this->parser->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n conditional 'false' expression yielded:\n";
                echo ezcTemplateTstTreeDump::dump( $rootOperator );
                echo "\n\n\n";
                // *** DEBUG END ***
            }

        }
        elseif ( $rootOperator instanceof ezcTemplateTypeTstNode )
        {
            if ( $this->parser->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n conditional 'false' expression yielded:\n";
                echo "<", $rootOperator->value, ">\n";
                echo "\n\n\n";
                // *** DEBUG END ***
            }
        }
        $this->operator->appendParameter( $rootOperator );
        return true;
    }
}

?>
