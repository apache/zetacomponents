<?php
/**
 * File containing the ezcTemplateDeclarationSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateDeclarationBlockSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * No known type found.
     */
    const VARIABLE_EXPECTED    = "A variable is expected";
    const INVALID_EXPRESSION   = "The expression is not valid";

    /**
     * The value of the parsed type or null if nothing was parsed.
     * @var mixed
     */
    public $value;

    /**
     * The parsed element object which defines the type or null if nothing
     * was parsed.
     */
    public $element;

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->value = null;
        $this->element = null;
    }

    /**
     * Parses the types by utilizing:
     * - ezcTemplateFloatSourceToTstParser for float types.
     * - ezcTemplateIntegerSourceToTstParser for integer types.
     * - ezcTemplateStringSourceToTstParser for string types.
     * - ezcTemplateBoolSourceToTstParser for boolean types.
     * - ezcTemplateArraySourceToTstParser for array types.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if( $this->currentCursor->current(3) == "var" )
        {
            $symbolType = ezcTemplateSymbolTable::VARIABLE; 

            $this->status = self::PARSE_PARTIAL_SUCCESS;
            $this->currentCursor->advance(3);
            $this->findNextElement();

            // $var
            if( $this->parseSubDefineBlock( $symbolType ) && $this->status == self::PARSE_SUCCESS )
            {
                $this->status = self::PARSE_SUCCESS;
                return true;
            }
        }

        return false;
    }

    // TODO, remove atEnd, nodes can determine their own 'end'.
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        return ( $cursor->current(1) == "}"  || $cursor->current(1) == ",");
    }

    protected function parseSubDefineBlock( $symbolType )
    {
        do
        {
            $this->findNextElement();

            $declaration = $this->parser->createDeclaration( $this->startCursor, $this->currentCursor );
            $declaration->isClosingBlock = false;
            $declaration->isNestingBlock = false;

            if( ! ($this->parseOptionalType( "Variable", $this->currentCursor, false ) && $this->lastParser->status === self::PARSE_SUCCESS ) )
            {
                $this->startCursor = $this->currentCursor;
                $this->operationState = self::VARIABLE_EXPECTED;
                return false;
            }

            $declaration->variable = $this->lastParser->elements[0];

            // Variable name.
            if ( !$this->parser->symbolTable->enter( $declaration->variable->name, $symbolType ) )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $this->parser->symbolTable->getErrorMessage() );
            }

            $this->findNextElement();

            if( $this->currentCursor->current( 1 ) == "=" )
            {
                $this->currentCursor->advance();

                if( !$this->parseOptionalType( "Expression", null, false ) )
                {

                    $this->operationState = sprintf( self::INVALID_EXPRESSION );
                    $this->startCursor = $this->currentCursor;
                    return false;
                }

                $declaration->expression = $this->lastParser->rootOperator;
            }

            $this->appendElement( $declaration );
            $this->findNextElement();

        } 
        while ( $this->currentCursor->match(",") );

        $this->currentCursor->advance();
        //var_dump ( $this->currentCursor->current(5) );

        $this->status = self::PARSE_SUCCESS;
        return true;

    }

    protected function generateErrorMessage()
    {
        return is_string( $this->operationState ) ? $this->operationState : parent::generateErrorMesssage();
    }

    protected function generateErrorDetails()
    {
        return is_string( $this->operationState ) ? $this->operationState : parent::generateErrorDetails();
    }
}

?>
