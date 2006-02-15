<?php
/**
 * File containing the ezcTemplateArraySourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for array types.
 *
 * Arrays are defined in the same way as in PHP.
 * <code>
 * array( [<expression> => ] <expression> [, [<expression> => ] <expression> ] )
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateArraySourceToTstParser extends ezcTemplateTypeSourceToTstParser
{
    /**
     * Array type must use lowercase characters only.
     */
    const STATE_NON_LOWERCASE = 1;

    /**
     * No starting brace for array.
     */
    const STATE_NO_STARTING_BRACE = 2;

    /**
     * No ending brace or missing comma for array.
     */
    const STATE_NO_ENDING_BRACE_OR_COMMA = 3;

    /**
     * No ending brace for array.
     */
    const STATE_NO_ENDING_BRACE = 4;

    /**
     * A comma was specified before the type.
     */
    const STATE_COMMA_BEFORE_TYPE = 5;

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the array types by looking for 'array(...)' and then using the
     * generic expression parser (ezcTemplateExpressionSourceToTstParser) to fetch the
     * keys and values.
     * @todo Keys and values should be allow to be expressions, switch sub-parser
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // @todo Check for non-lowercase array entry, give partial success then.
        $matches = $cursor->pregMatch( "#^array#i" );
        if ( $matches === false )
        {
            return false;
        }

        $this->status = self::PARSE_PARTIAL_SUCCESS;

        $name = $matches[0][0];
        $lower = strtolower( $name );
        if ( $name !== $lower )
        {
            $this->findNonLowercase();
            $this->operationState = self::STATE_NON_LOWERCASE;
            return false;
        }

        $cursor->advance( 5 );

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        if ( $cursor->current() != '(' )
        {
            $this->operationState = self::STATE_NO_STARTING_BRACE;
            return false;
        }

        $cursor->advance();
        $currentArray = array();
        while ( !$cursor->atEnd() )
        {
            $this->operationState = self::STATE_NO_ENDING_BRACE;
            if ( $cursor->current() == ')' )
            {
                $cursor->advance();
                $array = $this->parser->createType( $this->startCursor, $cursor );
                $array->value = $currentArray;
                $this->value = $array->value;
                $this->element = $array;
                $this->appendElement( $array );
                return true;
            }

            // skip whitespace and comments
            if ( !$this->findNextElement() )
            {
                return false;
            }

            // We allow a comma after the key/value even if there are no more
            // entries. This is compatible with PHP syntax.
            if ( $cursor->current() == ',' )
            {
                $this->operationState = self::STATE_COMMA_BEFORE_TYPE;
                return false;
            }

            // Check for type
            if ( !$this->parseRequiredType( 'Type' ) )
            {
//                $this->operationState = self::STATE_INVALID_TYPE;
                return false;
            }

            // skip whitespace and comments
            if ( !$this->findNextElement() )
                return false;

            if ( $cursor->current( 2 ) == '=>' )
            {
                $cursor->advance( 2 );

                // Apparently we have the key only
                $arrayKey = $this->lastParser->value;

                // skip whitespace and comments
                if ( !$this->findNextElement() )
                    return false;

                // We have the key => value syntax so we need to find the value
                if ( !$this->parseRequiredType( 'Type' ) )
                {
                    return false;
                }

                $currentArray[$arrayKey] = $this->lastParser->value;
            }
            else
            {
                $currentArray[] = $this->lastParser->value;
            }

            // skip whitespace and comments
            if ( !$this->findNextElement() )
                return false;

            // We allow a comma after the key/value even if there are no more
            // entries. This is compatible with PHP syntax.
            if ( $cursor->current() == ',' )
            {
                $cursor->advance();
                // skip whitespace and comments
                if ( !$this->findNextElement() )
                    return false;

                // Start iteration again
                continue;
            }

            // We did not find a comma so we expect the end of the array
            $this->operationState = self::STATE_NO_ENDING_BRACE_OR_COMMA;
            if ( $cursor->current() == ')' )
            {
                $cursor->advance();
                $array = $this->parser->createType( $this->startCursor, $cursor );
                $array->value = $currentArray;
                $this->value = $array->value;
                $this->element = $array;
                $this->appendElement( $array );
                return true;
            }
            return false;
        }

        $this->operationState = self::STATE_NO_ENDING_BRACE_OR_COMMA;
        return false;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NON_LOWERCASE:
                return "Array type must use lowercase characters only.";
            case self::STATE_NO_STARTING_BRACE:
                return "Missing starting brace for array.";
            case self::STATE_NO_ENDING_BRACE_OR_COMMA:
                return "Missing ending brace or comma for array.";
            case self::STATE_NO_ENDING_BRACE:
                return "Missing ending brace for array.";
            case self::STATE_COMMA_BEFORE_TYPE:
                return "A comma was found but no type has yet been specified.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        $text = '';
        switch ( $this->operationState )
        {
            case self::STATE_NON_LOWERCASE:
            case self::STATE_NO_STARTING_BRACE:
            case self::STATE_NO_ENDING_BRACE:
            case self::STATE_COMMA_BEFORE_TYPE:
                break;
            case self::STATE_NO_ENDING_BRACE_OR_COMMA:
                $text = "This typically happens if there is a comma missing between values or the ending brace was forgotten.\n";
                break;
            default:
                // Default error details handler.
                return parent::generateErrorDetails();
        }
        $text .= "Acceptable syntax is: array(), array( VALUE [, VALUE ...] ) or array( KEY => VALUE [, KEY => VALUE ...] )";
        return $text;
    }

    public function getTypeName()
    {
        return "array";
    }
}

?>
