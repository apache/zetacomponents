<?php
/**
 * File containing the ezcTemplateForeachLoopSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for {foreach} loop.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateForeachLoopSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The array to iterate through is specified incorrectly.
     */
    const STATE_BAD_ARRAY = 1;

    /**
     * Missing "as" keyword.
     */
    const STATE_NO_AS = 2;

    /**
     * No "=>"
     */
    const STATE_NO_EQUALGT = 3;

    /**
     * No/bad item variable.
     *
     * Item variable is the one following "=>".
     * Example: {foreach $objects as $keyVar => $itemVar}
     */
    const STATE_BAD_ITEMVAR = 4;

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->block = null;
    }

    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        if ( $cursor->current() == '}' )
        {
            return true;
        }

//        if ( $cursor->current( 2 ) == 'as' )
        $matches = $cursor->pregMatch( "#^[a-zA-Z]+#", false );
        if ( $matches !== false )
        {
            if ( $matches == 'as' )
                return true;
        }
        return false;
    }

    /**
     * Parses the expression by using the ezcTemplateExpressionSourceToTstParser class.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $this->status = self::PARSE_PARTIAL_SUCCESS;

        // handle closing block
        if ( $this->block->isClosingBlock )
        {
            if ( $this->parser->debug )
                echo "Starting end of foreach loop\n";

            // skip whitespace and comments
            if ( !$this->findNextElement() )
                return false;

            if ( !$this->parentParser->atEnd( $cursor, null, false ) )
                return false;
            $cursor->advance();

            $el = $this->parser->createForeachLoop( $this->startCursor, $cursor );
            $el->isClosingBlock = true;
            $this->appendElement( $el );
            return true;
        }

        // handle opening block

        if ( $this->parser->debug )
            echo "Starting foreach loop\n";

        // parse required part: "<array> as <varName>"

        $el = $this->parser->createForeachLoop( $this->startCursor, $cursor );

        $sequence = array( array( 'type' => 'Expression',
                                  'comment' => "Invalid expression for {foreach} loop item." ),
                           array( 'type' => 'Identifier',
                                  'comment' => "Missing 'as' keyword." ),
                           array( 'type' => 'Variable',
                                  'comment' => "Invalid variable definition for {foreach} iteration item." ) );

        $elements = $this->parseSequence( $sequence );

        if ( $elements === false )
            return false;

        $arrayElement = $elements[0];
        if ( get_class( $arrayElement ) == 'ezcTemplateLiteralTstNode' && !is_array( $arrayElement->value ) )
        {
            $this->operationState = self::STATE_BAD_ARRAY;
            return false;
        }

        if ( $elements[1]->value != 'as' )
        {
            $this->operationState = self::STATE_NO_AS;
            return false;
        }

        $el->array = $arrayElement;
        $el->itemVariableName = $elements[2]->name;

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // parse "=> $itemVar" clause if we're not at the end yet
        if ( !$this->parentParser->atEnd( $cursor, null, false ) )
        {
            if ( $cursor->current( 2 ) != '=>' )
            {
                $this->operationState = self::STATE_NO_EQUALGT;
                return false;
            }

            $cursor->advance( 2 );

            // skip whitespace and comments before the item variable
            if ( !$this->findNextElement() )
            {
                $this->operationState = self::STATE_BAD_ITEMVAR;
                return false;
            }

            // parse item variable
            if ( !$this->parseRequiredType( 'Variable', null, false ) )
            {
                $this->operationState = self::STATE_BAD_ITEMVAR;
                return false;
            }

            // skip whitespace and comments before the closing brace
            if ( !$this->findNextElement() )
                return false;

            if ( !$this->parentParser->atEnd( $cursor, null, false ) )
                return false;

            $el->keyVariableName  = $el->itemVariableName;

            if( !$this->parser->symbolTable->enter( $el->keyVariableName, ezcTemplateSymbolTable::VARIABLE, true ) )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $this->currentCursor, $this->parser->symbolTable->getErrorMessage() );
            }

            $el->itemVariableName = $this->lastParser->variableName;
        }
        
        if( !$this->parser->symbolTable->enter( $el->itemVariableName, ezcTemplateSymbolTable::VARIABLE, true ) )
        {
            throw new ezcTemplateSourceToTstParserException( $this, $this->currentCursor, $this->parser->symbolTable->getErrorMessage() );
        }

        $cursor->advance();
        $this->appendElement( $el );

        if ( $this->parser->debug )
        {
            echo "parsed foreach header:\n";
            var_dump( array(  'array' => $el->array, 'kv' => $el->keyVariableName, 'iv' => $el->itemVariableName  ) );
        }

        return true;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_BAD_ARRAY:
                return 'Bad array.';

            case self::STATE_NO_AS:
                return '\'as\' keyword expected.';

            case self::STATE_NO_EQUALGT:
                return "'=>' expected.";

            case self::STATE_BAD_ITEMVAR:
                return "No/bad item variable.";
        }

        // Default error message handler.
        return parent::generateErrorMessage();
    }

}

?>
