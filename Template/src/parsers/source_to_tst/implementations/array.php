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
class ezcTemplateArraySourceToTstParser extends ezcTemplateLiteralSourceToTstParser
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

    const MSG_NON_LOWERCASE_ARRAY = "The array identifier must consist of lowercase characters only.";
    const MSG_ARRAY_START_BRACE_MISSING = "Missing starting brace '('";
    const MSG_ARRAY_END_BRACE_MISSING = "Missing ending brace";
    const MSG_ARRAY_LITERAL_EXPECTED = "A literal type is expected";
 
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
        $name = $cursor->pregMatch( "#^array[^\w]#i", false );
        if ( $name === false )
        {
            return false;
        }

        $this->status = self::PARSE_PARTIAL_SUCCESS;

        $lower = strtolower( $name );
        if ( $name !== $lower )
        {
            $this->findNonLowercase();
            throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_NON_LOWERCASE_ARRAY ); 
        }

        $cursor->advance( 5 );

        // skip whitespace and comments
        $this->findNextElement();

        if ( !$cursor->match('(') )
        {
            throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_ARRAY_START_BRACE_MISSING ); 
        }

        $currentArray = array();
        while ( true )
        {
            // skip whitespace and comments
            if ( !$this->findNextElement() )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_ARRAY_END_BRACE_MISSING ); 
            }

            if ( $cursor->current() == ')' )
            {
                $cursor->advance();
                $array = $this->parser->createLiteral( $this->startCursor, $cursor );
                $array->value = $currentArray;
                $this->value = $array->value;
                $this->element = $array;
                $this->appendElement( $array );
                return true;
            }

            // Check for type
            if ( !$this->parseRequiredType( 'Literal' ) )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_ARRAY_LITERAL_EXPECTED ); 
            }

            $this->findNextElement();

            if ( $cursor->match( '=>' ) )
            {
                // Found the array key. Store it, and continue with the search for the value.
                $arrayKey = $this->lastParser->value;
                $this->findNextElement();

                // We have the key => value syntax so we need to find the value
                if ( !$this->parseRequiredType( 'Literal' ) )
                {
                    throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_ARRAY_LITERAL_EXPECTED ); 
                }

                // Store the value.
                $currentArray[$arrayKey] = $this->lastParser->value;
            }
            else
            {
                // Store the value.
                $currentArray[] = $this->lastParser->value;
            }

            $this->findNextElement();

            // We allow a comma after the key/value even if there are no more
            // entries. This is compatible with PHP syntax.
            if ( $cursor->match(',') )
            {
                $this->findNextElement();
            }
        }
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
