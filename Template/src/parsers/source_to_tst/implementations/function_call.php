<?php
/**
 * File containing the ezcTemplateFunctionCallSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for function calls.
 *
 * An calls looks like:
 * <code>
 * <function name> LEFT_PARENTHESIS <parameter 1> [, <parameter 2> ...] RIGHT_PARENTHESIS
 * e.g.
 * str_replace( " ", "_", $str )
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateFunctionCallSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * No starting brace for function call.
     */
    const STATE_NO_STARTING_BRACE = 1;

    /**
     * No ending brace for function call.
     */
    const STATE_NO_ENDING_BRACE = 2;

    /**
     * A comma is required between parameters, it is missing.
     */
    const STATE_MISSING_COMMA = 3;

    /**
     * No expresssion was found for parameter.
     */
    const STATE_NO_EXPRESSION = 4;

    /**
     * The function call object if the parser was succesful.
     * @var ezcTemplateFunctionCallTstNode
     */
    public $functionCall;

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->readingParameter = false;
    }

    /**
     * Figures out if the end as been reached and returns true if it has.
     *
     * The end is reached when it finds the character ].
     */
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        if ( $cursor->current() == ')' )
        {
//            if ( !$finalize )
                return true;

            $endCursor = clone $cursor;
            $cursor->advance( 1 );
            if ( $operator !== null )
            {
                $this->functionCall->endCursor = clone $operator->endCursor;
                $this->functionCall->appendParameter( $operator );
                $this->parser->reportElementCursor( $this->functionCall->startCursor, $this->functionCall->endCursor, $this->functionCall );
            }
            else
            {
                $this->functionCall->endCursor = $endCursor;
            }
            return true;
        }
        else if ( $this->readingParameter &&
                  $cursor->current() == ',' )
        {
            return true;
        }
        return false;
    }

    /**
     * Parses the function call and the parameters, the parameters are parsed
     * using the generic expression parser.
     * The expression will callback the atEnd() function to figure out if the
     * end is reached or not.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $failedParser = null;

        // $cursor will be update as the parser continues
        $this->functionCall = $this->parser->createFunctionCall( $this->startCursor, $cursor );

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        $matches = $cursor->pregMatch( "#^[a-zA-Z_][a-zA-Z0-9_]*#" );
        if ( $matches === false )
            return false;

        $this->functionCall->name = $matches[0][0];
        $cursor->advance( strlen( $matches[0][0] ) );

        // skip whitespace and comments
        if ( !$this->findNextElement() )
        {
            return false;
        }

        if ( $cursor->current() != '(' )
        {
            $this->operationState = self::STATE_NO_STARTING_BRACE;
            return false;
        }

        // skip the ( character
        $cursor->advance();
        $this->status = self::PARSE_PARTIAL_SUCCESS;

        $i = 0;
        $this->parameterCount = 0;
        while ( !$cursor->atEnd() )
        {
            $this->operationState = self::STATE_NO_ENDING_BRACE;
            // skip whitespace and comments
            if ( !$this->findNextElement() )
                return false;

            if ( $cursor->current() == ')' )
            {
                $this->functionCall->endCursor = clone $cursor;
                $cursor->advance( 1 );
                $this->parser->reportElementCursor( $this->functionCall->startCursor, $this->functionCall->endCursor, $this->functionCall );
                return true;
            }

            if ( $i > 0 )
            {
                if ( $cursor->current() != ',' )
                {
                    $this->operationState = self::STATE_MISSING_COMMA;
                    return false;
                }

                // skip whitespace and comments
                if ( !$this->findNextElement() )
                    return false;

                $cursor->advance();
            }
            ++$i;
            ++$this->parameterCount;

            $this->operationState = false;
            $this->readingParameter = true;
            // Check for expression, the parser will call self::atEnd() to check for end of expression.
            $expressionStartCursor = clone $cursor;
            $expressionParser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
            $expressionParser->allowIdentifier = true;
            if ( !$this->parseRequiredType( $expressionParser ) )
                return false;

            $rootOperator = $this->lastParser->currentOperator;
            if ( $rootOperator instanceof ezcTemplateOperatorTstNode )
            {
                $rootOperator = $rootOperator->getRoot();

                if ( $this->parser->debug )
                {
                    // *** DEBUG START ***
                    echo "\n\n\n parameter expression yielded:\n";
                    echo "<", $expressionStartCursor->subString( $cursor->position ), ">\n";
                    echo $rootOperator->outputTree();
                    echo "\n\n\n";
                    // *** DEBUG END ***
                }
            }
            if ( $rootOperator === null )
            {
                $this->operationState = self::STATE_NO_EXPRESSION;
                return false;
            }
            $this->functionCall->appendParameter( $rootOperator );

            $this->readingParameter = false;
        }
        return false;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_STARTING_BRACE:
                return "Missing starting brace for function call.";
            case self::STATE_NO_ENDING_BRACE:
                return "Missing ending brace for function call.";
            case self::STATE_MISSING_COMMA:
                return "A comma is required between parameters, it is missing.";
            case self::STATE_NO_EXPRESSION:
                return "Missing type or expresssion for parameter {$this->parameterCount} of function call {$this->functionCall->name}().";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_STARTING_BRACE:
            case self::STATE_NO_ENDING_BRACE:
            case self::STATE_MISSING_COMMA:
            case self::STATE_NO_EXPRESSION:
                return "Accepted syntax is: functionName( PARAMETER [, PARAMETER ...] )";
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
