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
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $this->expressionStartCursor = clone $this->currentCursor;

        // skip whitespace and comments
        if ( !$this->findNextElement() )
        {
            return false;
        }

        $this->state = 'operand';

        $allowIdentifier = $this->allowIdentifier;
        while ( !$cursor->atEnd() )
        {
            if ( $this->parser->debug )
                echo "state is <", $this->state, ">\n";
            if ( $this->state == 'operand' )
            {
                // skip whitespace and comments
                if ( !$this->findNextElement() )
                {
                    return false;
                }

                // Stop if we are at end of expression
                if ( $this->parentParser->atEnd( $cursor, $this->currentOperator ) )
                {
                    if ( count( $this->elements ) === 0 )
                    {
                        $this->operationState = self::STATE_NO_OPERAND;
                        return false;
                    }
                    return true;
                }

                // Check if we have a subexpression
                if ( $cursor->current() == '(' )
                {
                    $expressionCursor = clone $cursor;
                    $expressionCursor->advance();
                    $expressionParser = new ezcTemplateExpressionBlockSourceToTstParser( $this->parser, $this, null );
                    $expressionParser->setAllCursors( $expressionCursor );
                    $expressionParser->startCursor = clone $cursor;
                    $expressionParser->startBracket = '(';
                    $expressionParser->endBracket = ')';
                    if ( !$this->parseRequiredType( $expressionParser ) )
                    {
                        return false;
                    }
                    $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->block );
                    $this->state = 'operator';
                    continue;
                }

                $failedCursor = clone $cursor;

                // Try parsing a type
                if ( $this->parseOptionalType( 'Type' ) )
                {
                    if ( $this->lastParser->status == self::PARSE_PARTIAL_SUCCESS )
                    {
                        return false;
                    }
                    $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->element );
                    $this->state = 'operator';
                    continue;
                }

                // Try parsing a variable
                if ( $this->parseOptionalType( 'Variable' ) )
                {
                    if ( $this->lastParser->status == self::PARSE_PARTIAL_SUCCESS )
                    {
                        return false;
                    }
                    $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->element );
                    $this->state = 'operator';
                    continue;
                }

                // Try parsing a function call
                if ( $this->parseOptionalType( 'FunctionCall' ) )
                {
                    if ( $this->lastParser->status == self::PARSE_PARTIAL_SUCCESS )
                    {
                        return false;
                    }
                    $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->functionCall );
                    if ( $this->parser->debug )
                    {
                        // *** DEBUG START ***
                        echo "\n\n\n function call parser yielded:\n";
                        echo $this->lastParser->functionCall->outputTree(), "\n";
                        echo "\n\n\n";
                        // *** DEBUG END ***
                    }
                    $this->state = 'operator';
                    continue;
                }

                if ( $allowIdentifier )
                {
                    // Try parsing an identifier since it is allowed
                    if ( $this->parseOptionalType( 'Identifier' ) )
                    {
                        if ( $this->lastParser->status == self::PARSE_PARTIAL_SUCCESS )
                        {
                            return false;
                        }
                        $this->currentOperator = $this->parser->handleOperand( $this->currentOperator, $this->lastParser->element );
                        $this->state = 'operator';
                        continue;
                    }
                }

                // Check if we have ++, --, -, ! operators
                $operator = null;
                // This will contain the name of the operator if it is found.
                $operatorName = false;

                $operatorSymbols = array( array( 2,
                                                 array( '++', '--' ) ),
                                          array( 1,
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
                    $operatorMap = array( '++' => 'PreIncrementOperator',
                                          '--' => 'PreDecrementOperator',
                                          '-' => 'NegateOperator',
                                          '!' => 'LogicalNegateOperator',

                                          );
                    $operatorName = $operatorMap[$operatorName];
                    $operatorClass = 'ezcTemplate' . $operatorName;
                    $function = 'create' . $operatorName;
                    $operator = $this->parser->$function( clone $this->lastCursor, $cursor );

                    // If the min precedence has been reached we immediately stop parsing
                    // and return a successful parse result
                    if ( $this->minPrecedence !== false &&
                         $operator->precedence < $this->minPrecedence )
                    {
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
                    $this->state = 'operand';
                    $this->status = self::PARSE_PARTIAL_SUCCESS;
                    continue;
                }

                // No operand found so we perform a failure at the end of the function
                $this->operationState = self::STATE_NO_OPERAND;
                return false;
            }
            elseif ( $this->state == 'operator' )
            {
                // Since at least one operand has been read we mark this parser
                // as having parsed something.
                $this->status = self::PARSE_PARTIAL_SUCCESS;

                // Restore identifier allowance from value in object.
                $allowIdentifier = $this->allowIdentifier;

                // First check if the property fetch operator is found. This
                // needs to be placed righter after the operand to distuingish
                // it from concatenation operator.
                if ( $cursor->current() == '.' &&
                     $cursor->current( 2 ) != '.=' ) // Check for .= operator
                {
                    $operatorStartCursor = clone $cursor;
                    $cursor->advance();
                    $operator = $this->parser->createPropertyFetch( clone $this->lastCursor, $cursor );

                    // If the min precedence has been reached we immediately stop parsing
                    // and return a successful parse result
                    if ( $this->minPrecedence !== false &&
                         $operator->precedence < $this->minPrecedence )
                    {
                        $cursor->copy( $operatorStartCursor );
                        return true;
                    }

                    $this->currentOperator = $this->parser->handleOperatorPrecedence( $this->currentOperator, $operator );

                    $this->parser->reportElementCursor( $operator->startCursor, $operator->endCursor, $operator );
                    $this->lastCursor->copy( $cursor );
                    $allowIdentifier = true;
                    $this->state = 'operand';
                    continue;
                }

                // skip whitespace and comments
                if ( !$this->findNextElement() )
                {
                    return false;
                }

                // Stop if we are at end of expression
                if ( $this->parentParser->atEnd( $cursor, $this->currentOperator ) )
                {
                    if ( count( $this->elements ) === 0 )
                    {
                        $this->operationState = self::STATE_NO_OPERAND;
                        return false;
                    }
                    return true;
                }

                if ( $cursor->current() == ')' )
                {
                    $this->operationState = self::STATE_END_BRACE_WITHOUT_START;
                    return false;
                }

                // Try som generic operators
                $operator = null;
                // This will contain the name of the operator if it is found.
                $operatorName = false;

                $operatorSymbols = array( array( 10,
                                                 array( 'instanceof' ) ),
                                          array( 3,
                                                 array( '===', '!==' ) ),
                                          array( 2,
                                                 array( '==', '!=',
                                                        '<=', '>=',
                                                        '&&', '||',
                                                        '+=', '-=', '*=', '/=', '.=', '%=',
                                                        '++', '--' ) ),
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

                                          '++' => 'PostIncrementOperator',
                                          '--' => 'PostDecrementOperator',
                                          'instanceof' => 'InstanceOfOperator',

                                          );
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
                        $cursor->copy( $operatorStartCursor );
                        return true;
                    }

                    $this->currentOperator = $this->parser->handleOperatorPrecedence( $this->currentOperator, $operator );

                    $this->parser->reportElementCursor( $operator->startCursor, $operator->endCursor, $operator );
                    $this->lastCursor->copy( $cursor );

                    // instanceof operator can have an identifier as the next operand
                    if ( $requestedName == 'instanceof' )
                    {
                        $allowIdentifier = true;
                    }

                    $this->state = 'operand';
                    if ( $operator->maxParameterCount !== false &&
                         $operator->getParameterCount() >= $operator->maxParameterCount )
                    {
                        $this->state = 'operator';
                    }
                    continue;
                }

                // Try the special array fetch operator
                $operator = null;
                if ( $cursor->current() == '[' )
                {
                    $operatorStartCursor = clone $cursor;
                    if ( !$this->parseRequiredType( 'ArrayFetch' ) )
                    {
                        return false;
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
                    continue;
                }

                // Try the conditional ternary operator
                $operator = null;
                if ( $cursor->current() == '?' )
                {
                    $operatorStartCursor = clone $cursor;
                    if ( !$this->parseRequiredType( 'ConditionalOperator' ) )
                    {
                        return false;
                    }

                    $operator = $this->lastParser->operator;

                    if ( $this->parser->debug )
                    {
                        // *** DEBUG START ***
                        echo "\n\n\n conditional parser yielded:\n";
                        echo "<", $operator->outputTree(), ">\n";
                        echo "\n\n\n";
                        // *** DEBUG END ***
                    }

                    // If the min precedence has been reached we immediately stop parsing
                    // and return a successful parse result
                    if ( $this->minPrecedence !== false &&
                         $operator->precedence < $this->minPrecedence )
                    {
                        if ( $this->parser->debug )
                            echo "less precedence, returning\n";
                        $this->currentOperator = $this->parser->handleOperatorPrecedence( $this->currentOperator, $operator );

                        // Copy back cursor before parsing?
                        $cursor->copy( $operatorStartCursor );
                        $this->lastCursor->copy( $operatorStartCursor );
                        return true;
                    }

                    if ( $this->parser->debug )
                        echo "handling operator precedence for current=<", get_class( $this->currentOperator ), "> and new=<", get_class( $operator ), ">\n";
                    $this->currentOperator = $this->parser->handleOperatorPrecedence( $this->currentOperator, $operator );
                    if ( $this->parser->debug )
                    {
                        // *** DEBUG START ***
                        echo "\n\n\n conditional operator after precedence handling:\n";
                        echo "<", $operator->outputTree(), ">\n";
                        echo "\n\n\n";
                        // *** DEBUG END ***
                    }
                    $this->lastCursor->copy( $cursor );
                    continue;
                }
                // Try the ':' part of the conditional ternary operator
                // This is only tried to check the $this->minPrecedence variable.
                if ( $cursor->current() == ':' )
                {
                    $operator = $this->parser->createConditionalOperator( clone $this->lastCursor, clone $cursor );
                    // If the min precedence has been reached we immediately stop parsing
                    // and return a successful parse result
                    if ( $this->minPrecedence !== false &&
                         $operator->precedence <= $this->minPrecedence )
                    {
                        return true;
                    }
                }

                // Try the '|' operator, this is part of eZ publish 3.x but not
                // supported in the this template engine.
                if ( $cursor->current() == '|' )
                {
                    $this->modifierCursor = clone $cursor;
                    $cursor->advance();
                    $this->findNextElement();
                    $this->modifierStartCursor = clone $cursor;
                    if ( $this->parseOptionalType( 'Identifier' ) )
                    {
                        if ( $this->lastParser->status == self::PARSE_PARTIAL_SUCCESS )
                        {
                            $this->modifierName = false;
                            $this->operationState = self::STATE_UNSUPPORTED_OPERATOR_MODIFIER_INVALID;
                        }
                        else
                        {
                            $this->modifierName = $this->lastParser->identifierName;
                            $this->operationState = self::STATE_UNSUPPORTED_OPERATOR_MODIFIER;
                        }
                    }
                    else
                    {
                        $this->operationState = self::STATE_UNSUPPORTED_OPERATOR_MODIFIER_INVALID;
                    }
                    return false;
                }

                // Check for the ',' operator, this should not be handled by the expression parser
                // but rather by the parent parser which have more knowledge of its usage
                if ( $cursor->current() == ',' )
                {
                    // @todo Figure out why startCursor needs to be copied to get correct position
                    //       this should not be required
                    $this->startCursor->copy( $cursor );
                    $this->operationState = self::STATE_OPERATOR_COMMA_NOT_ALLOWED;
                    return false;
                }

                $cursor->copy( $this->lastCursor );
                $this->operationState = self::STATE_NO_OPERATOR;
                return false;
            }

            // State is not known, internal error.
            throw new Exception( "Invalid state <" . $this->state . ">" );
        }
        $this->operationState = self::STATE_NO_OPERAND;
        return false;
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
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
