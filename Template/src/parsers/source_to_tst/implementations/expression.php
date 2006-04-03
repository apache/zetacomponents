<?php
/**
 * File containing the ezcTemplateExpressionExpressionParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for expressions.
 *
 * Parses as until it reaches the end of the expression. The expression is
 * parsed using type parsers and operator parsers. The end of the expression
 * is determined by calling atEnd() on the parent element parser.
 *
 * @todo The ?: operator does not work the same way as in PHP, must be fixed.
 * @todo The ! operator does not work the same way as in PHP, must be fixed.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateExpressionSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * No operand found when one was expected.
     */
    const STATE_NO_OPERAND = 1;

    /**
     * No operator found when one was expected.
     */
    const STATE_NO_OPERATOR = 2;

    /**
     * An end brace was found without a starting one.
     */
    const STATE_END_BRACE_WITHOUT_START = 3;

    /**
     * The modified operator | is not supported in this engine.
     */
    const STATE_UNSUPPORTED_OPERATOR_MODIFIER = 4;

    /**
     * The modified operator | is not supported in this engine, it also invalid.
     */
    const STATE_UNSUPPORTED_OPERATOR_MODIFIER_INVALID = 5;

    /**
     * The comma operator , was used but it is not allowed.
     */
    const STATE_OPERATOR_COMMA_NOT_ALLOWED = 6;
   
    /**
     * The variable was not declared.
     */

    /**
     * The current operator element if any.
     *
     * If you are interested in the result of the expression see $rootOperator
     * instead.
     *
     * @var ezcTemplateOperatorTstNode
     */
    public $currentOperator;

    /**
     * The root of the operator/operand tree which is the result of the expression parsing.
     * This will only be set after the parsing is succesful.
     *
     * @var ezcTemplateOperatorTstNode
     */
    public $rootOperator;

    /**
     * Controls whether empty expressions are allowed, the default is false.
     * @var bool
     */
    public $allowEmptyExpressions;

    /**
     * Passes control to parent.
     * @param int $minPrecedence The minimum precedence level which is allowed
     *                           for operators.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->currentOperator = null;
        $this->rootOperator = null;
        $this->allowIdentifier = false;
        $this->minPrecedence = false;
        $this->allowEmptyExpressions = false;
    }

    /**
     * Parses the expression by using the various type and operator parsers.
     * The parsers has two states 'operand' and 'operator' which is switched
     * (often alternating) to correctly parse the next element. Each operation
     * also has a call to atEnd() on the parent element parser to figure out
     * if the end has been reached.
     *
     * When an operator is found it will call ezcTemplateParser::handleOperatorPrecedence()
     * to get proper order of operators in the tree.
     *
     * Look ahead: Operand 
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $this->expressionStartCursor = clone $this->currentCursor;

        $this->findNextElement();

        // If it has a preOperator, it must have an operand.
        $match = "";
        if( $this->parsePreModifyingOperator( $cursor, $match ) )
        {
            if( !$this->parseOperand( $cursor, array( "Variable" ), false ) )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $cursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VARIABLE );
            }
            
            return true;
        }
        elseif( $this->parsePreOperator( $cursor, $match ) )
        {
            if( !$this->parseOperand( $cursor, array(), false ) )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $cursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_OPERAND );
            }
        }
        elseif( $type = $this->parseOperand( $cursor ) ) // Only an operand?
        {
            if( $type == "Variable" )
            {
                // The expression stops after a post operator.
                if( $this->parsePostOperator( $cursor ) ) return true;
            }
        }
        else
        {
            // No, then it's not an expression.
            return false;
        }

        while ( true )
        {
            //  Operator check.
            $this->findNextElement();

            if( !$this->parseOperator( $cursor ) )
            {
                return true;
            }

            // An operand is mandantory.
            $failedCursor = clone $cursor;
            $this->findNextElement();

            // Modifying operators are not allowed anymore.

            $this->parsePreOperator( $cursor, $match );

            if( !$this->parseOperand( $cursor, array(), false ) ) 
            {
                throw new ezcTemplateSourceToTstParserException( $this, $cursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_NON_MODIFYING_OPERAND );
            }

/*
            if( $this->parsePreOperator( $cursor, $match ) )
            {
                // Parse operand but disallow: !$a++; ($a++ has no output)
                if( !$this->parseOperand( $cursor, array(), false ) )
                {
                    throw new ezcTemplateSourceToTstParserException( $this, $cursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_OPERAND );
                }
            }
            elseif( !$this->parseOperand( $cursor, array(), false ) ) 
            {
                throw new ezcTemplateSourceToTstParserException( $this, $cursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_OPERAND );
            }
            */
        }
    }

    /**
     * Makes sure the element list contains the root operator/operand from the
     * expression.
     */
    protected function handleSuccessfulResult( ezcTemplateCursor $lastCursor, ezcTemplateCursor $cursor )
    {
        $rootOperator = $this->currentOperator;
        if ( $rootOperator instanceof ezcTemplateOperatorTstNode )
        {
            $rootOperator = $rootOperator->getRoot();
        }
        $this->rootOperator = $rootOperator;

        // Make sure element list contains the root
        $this->elements = array( $this->rootOperator );
    }

    protected function canParseType( $name, $allowedTypes )
    {
        return $this->parseOptionalType( $name ) && ( sizeof( $allowedTypes ) == 0  || in_array( $name, $allowedTypes )  );
    }

    protected function parseOperand( $cursor, $allowedTypes = array(), $allowPostModification = true )
    {
        $parsedType = false;
        if ( $this->canParseType( 'Literal', $allowedTypes ) )
        {
            $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->element );
            $parsedType = "Literal";
        }
        elseif ( $this->canParseType( 'Variable', $allowedTypes ) )
        {
            $type = $this->parser->symbolTable->retrieve( $this->lastParser->element->name );
            if ( $type === false )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $this->startCursor, $this->parser->symbolTable->getErrorMessage() );
            }

            $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->element );

            if( $this->parseArrayFetch( $cursor ) )
            {
                $this->findNextElement();
            }

            $parsedType = "Variable";
        }
        elseif ( $this->canParseType( 'FunctionCall', $allowedTypes ) )
        {
            $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->functionCall );
            if ( $this->parser->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n function call parser yielded:\n";
                echo ezcTemplateTstTreeOutput::output( $this->lastParser->functionCall );
                echo "\n\n\n";
                // *** DEBUG END ***
            }

            $parsedType = "FunctionCall";
        }
        elseif ( $this->allowIdentifier && $this->parseOptionalType( 'Identifier' ) )
        {
            // Try parsing an identifier since it is allowed
            $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->element );

            $parsedType = "Identifier";
        }
        elseif( $cursor->match( '(' ) && sizeof( $allowedTypes ) == 0 )
        {
            $expressionCursor = clone $cursor;
            $expressionParser = new ezcTemplateExpressionBlockSourceToTstParser( $this->parser, $this, null );
            $expressionParser->setAllCursors( $expressionCursor );
            $expressionParser->startCursor = clone $cursor;
            $expressionParser->startBracket = '(';
            $expressionParser->endBracket = ')';

            if ( !$this->parseRequiredType( $expressionParser ) )
            {
                return false;
            }

            if( !$cursor->match( ')' ) )
            {
                exit( "Expected an closing ')' ");
            }

            $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->block );

            $parsedType = "Parenthesis";
        }

        return $parsedType;
    }

        protected function parsePreOperator( $cursor )
        {
                // Check if we have -, ! operators
                $operator = null;
                // This will contain the name of the operator if it is found.
                $operatorName = false;

                $operatorSymbols = array( array( 1,
                                                 array( '-', '!' ) ) );
                foreach ( $operatorSymbols as $symbolEntry )
                {
                    $chars = $cursor->current( $symbolEntry[0] );
                    if ( in_array( $chars, $symbolEntry[1] ) )
                    {
                        $operatorName = $chars;
                        break;
                    }
                }

                if ( $operatorName !== false )
                {
                    $operatorStartCursor = clone $cursor;
                    $cursor->advance( strlen( $operatorName ) );
                    if ( $this->parser->debug )
                    {
                        echo "pre-operator {$operatorName} <", $this->lastCursor->subString( $cursor->position ), ">\n";
                    }
                    $operatorMap = array( '-' => 'NegateOperator',
                                          '!' => 'LogicalNegateOperator');
                    $operatorName = $operatorMap[$operatorName];
                    $operatorClass = 'ezcTemplate' . $operatorName;
                    $function = 'create' . $operatorName;
                    $operator = $this->parser->$function( clone $this->lastCursor, $cursor );

                    // If the min precedence has been reached we immediately stop parsing
                    // and return a successful parse result
                    if ( $this->minPrecedence !== false &&
                         $operator->precedence < $this->minPrecedence )
                    {
                        die ("FOUND MIN PRECEDENCE");
                        $cursor->copy( $operatorStartCursor );
                        return true;
                    }

                    if ( $this->currentOperator === null )
                    {
                        $this->currentOperator = $operator;
                    }
                    else
                    {
                        // All pre operators should not sort precedence at this
                        // moment so just append it to the current operator.
                        $this->currentOperator->appendParameter( $operator );
                        $operator->parentOperator = $this->currentOperator;
                        $this->currentOperator = $operator;
                    }

                    $this->parser->reportElementCursor( $operator->startCursor, $operator->endCursor, $operator );
                    $this->lastCursor->copy( $cursor );
                    $this->status = self::PARSE_PARTIAL_SUCCESS;
                    return true;
                }
                return false;
        }

        protected function parsePostOperator( $cursor )
        {
            if( $cursor->match( '++' ) )
            {
                $operatorStartCursor = clone $cursor;
                $operator = $this->parser->createPostIncrementOperator( clone $this->lastCursor, $cursor );
            }
            elseif(  $cursor->match( '--' ) )
            {
                $operatorStartCursor = clone $cursor;
                $operator = $this->parser->createPostDecrementOperator( clone $this->lastCursor, $cursor );
            }
            else
            {
                return false;
            }

            $this->currentOperator = $this->parser->handleOperatorPrecedence( $this->currentOperator, $operator );

            $this->parser->reportElementCursor( $operator->startCursor, $operator->endCursor, $operator );
            $this->lastCursor->copy( $cursor );


            return true;
        }

        protected function parsePreModifyingOperator( $cursor )
        {
            if( $cursor->match( '++' ) )
            {
                $operatorStartCursor = clone $cursor;
                $operator = $this->parser->createPreIncrementOperator( clone $this->lastCursor, $cursor );
            }
            elseif(  $cursor->match( '--' ) )
            {
                $operatorStartCursor = clone $cursor;
                $operator = $this->parser->createPreDecrementOperator( clone $this->lastCursor, $cursor );
            }
            else
            {
                return false;
            }

            if ( $this->currentOperator === null )
            {
                $this->currentOperator = $operator;
            }
            else
            {
                // All pre operators should not sort precedence at this
                // moment so just append it to the current operator.
                $this->currentOperator->appendParameter( $operator );
                $operator->parentOperator = $this->currentOperator;
                $this->currentOperator = $operator;
            }

            $this->parser->reportElementCursor( $operator->startCursor, $operator->endCursor, $operator );
            $this->lastCursor->copy( $cursor );

            return true;
        }


        protected function parseArrayFetch( $cursor )
        {
            // Try the special array fetch operator
            $operator = null;
            if ( $cursor->current() == '[' )
            {
                $operatorStartCursor = clone $cursor;
                if ( !$this->parseRequiredType( 'ArrayFetch' ) )
                {
                    return false;
                }

                $this->findNextElement();
                if( !$cursor->match("]") )
                {
                    throw new ezcTemplateSourceToTstParserException( $this, $cursor, "Expect closing ']' in expression");
                }
                
                $operator = $this->lastParser->fetch;

                // If the min precedence has been reached we immediately stop parsing
                // and return a successful parse result
                if ( $this->minPrecedence !== false &&
                $operator->precedence < $this->minPrecedence )
                {
                    $cursor->copy( $operatorStartCursor );
                    return true;
                }

                $this->currentOperator = $this->parser->handleOperatorPrecedence( $this->currentOperator, $operator );
                $this->lastCursor = clone $cursor;
                return true;
                //continue;
            }

            return false;
        }


        protected function parseOperator( $cursor )
        {
            // Try som generic operators
            $operator = null;
            // This will contain the name of the operator if it is found.
            $operatorName = false;

            $operatorSymbols = array( array( 10,
            array( 'instanceof' ) ),
            array( 3,
            array( '===', '!==' ) ),
            array( 2,
            array( '->',
            '==', '!=',
            '<=', '>=',
            '&&', '||',
            '+=', '-=', '*=', '/=', '.=', '%=',
            '..') ),
            array( 1,
            array( '+', '-', '.',
            '*', '/', '%',
            '<', '>',
            '=' ) ) );
            foreach ( $operatorSymbols as $symbolEntry )
            {
                $chars = $cursor->current( $symbolEntry[0] );
                if ( in_array( $chars, $symbolEntry[1] ) )
                {
                    $operatorName = $chars;
                    break;
                }
            }

            if ( $operatorName !== false )
            {
                $operatorStartCursor = clone $cursor;
                $cursor->advance( strlen( $operatorName ) );
                if ( $this->parser->debug )
                echo "operator {$operatorName} <", $this->lastCursor->subString( $cursor->position ), ">\n";
                $operatorMap = array( '+' => 'PlusOperator',
                '-' => 'MinusOperator',
                '.' => 'ConcatOperator',

                '*' => 'MultiplicationOperator',
                '/' => 'DivisionOperator',
                '%' => 'ModuloOperator',

                '->' => 'PropertyFetch',

                '==' => 'EqualOperator',
                '!=' => 'NotEqualOperator',

                '===' => 'IdenticalOperator',
                '!==' => 'NotIdenticalOperator',

                '<' => 'LessThanOperator',
                '>' => 'GreaterThanOperator',

                '<=' => 'LessEqualOperator',
                '>=' => 'GreaterEqualOperator',

                '&&' => 'LogicalAndOperator',
                '||' => 'LogicalOrOperator',

                '=' => 'AssignmentOperator',
                '+=' => 'PlusAssignmentOperator',
                '-=' => 'MinusAssignmentOperator',
                '*=' => 'MultiplicationAssignmentOperator',
                '/=' => 'DivisionAssignmentOperator',
                '.=' => 'ConcatAssignmentOperator',
                '%=' => 'ModuloAssignmentOperator',

                '..' => 'ArrayRangeOperator',

        //        '++' => 'PostIncrementOperator',
        //        '--' => 'PostDecrementOperator',
                'instanceof' => 'InstanceOfOperator',);

                $requestedName = $operatorName;
                $operatorName = $operatorMap[$operatorName];
                $operatorClass = 'ezcTemplate' . $operatorName;
                $function = 'create' . $operatorName;
                $operator = $this->parser->$function( clone $this->lastCursor, $cursor );

                // If the min precedence has been reached we immediately stop parsing
                // and return a successful parse result
                if ( $this->minPrecedence !== false &&
                $operator->precedence < $this->minPrecedence )
                {
                    die ("MIN PRECEDENCE !!");
                    $cursor->copy( $operatorStartCursor );
                    return true;
                }

                $this->currentOperator = $this->parser->handleOperatorPrecedence( $this->currentOperator, $operator );

                $this->parser->reportElementCursor( $operator->startCursor, $operator->endCursor, $operator );
                $this->lastCursor->copy( $cursor );

                // instanceof operator can have an identifier as the next operand
                if ( $requestedName == 'instanceof' ||
                $requestedName == '->' )
                {
                    $this->allowIdentifier = true;
                }

                return true;
            }

            return false;
        }



    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_OPERAND:
                return "Invalid expression, no operand is set.";
            case self::STATE_NO_OPERATOR:
                return "Invalid expression, no operator found.";
            case self::STATE_END_BRACE_WITHOUT_START:
                return "End brace found without a starting brace.";
            case self::STATE_UNSUPPORTED_OPERATOR_MODIFIER:
                return "The modifier operator | is not supported in the template engine.";
            case self::STATE_UNSUPPORTED_OPERATOR_MODIFIER_INVALID:
                return "The modifier operator | is not supported in the template engine, the syntax is also invalid.";
            case self::STATE_OPERATOR_COMMA_NOT_ALLOWED:
                return "The comma operator is not allowed at this context.";
            case self::STATE_VARIABLE_NOT_DECLARED:
                return "The variable is not declared";

        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_OPERAND:
                return "Acceptable operands are: types, variables, function calls or the operators ++, --, ! and -.";
            case self::STATE_NO_OPERATOR:
                return;
            case self::STATE_END_BRACE_WITHOUT_START:
                return "This is typically caused by a missing start brace or having misplaced the end brace.";
//                return "Acceptable operators are: ";
            case self::STATE_UNSUPPORTED_OPERATOR_MODIFIER:
            case self::STATE_UNSUPPORTED_OPERATOR_MODIFIER_INVALID:
                // @todo make sure the code example uses the correct functio name on the right
                $text = "The modified syntax is from the template engine in eZ publish 3.x and is no longer supported.\nThe code can be fixed by wrapping the right hand side of the | character around the left hand side.";
                if ( $this->operationState == self::STATE_UNSUPPORTED_OPERATOR_MODIFIER )
                {
                    $text .= "\ne.g.: ";
                    $text .= $this->expressionStartCursor->subString( $this->currentCursor->position ) . ' -> ';
                    $text .= $this->modifierName . '( ';
                    $text .= $this->expressionStartCursor->subString( $this->modifierCursor->position ) . ' )';
                }
                else
                {
                    $text .= "\nNote: The code after the | operator is not valid, it should only contain alphabetical characters.";
                }
                return $text;
//                $string|wash -> wash( $string )";


            case self::STATE_VARIABLE_NOT_DECLARED:
                return "The variable is not declared";

        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
