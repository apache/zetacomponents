<?php
/**
 * File containing the ezcTemplateIncludeSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateIncludeSourceToTstParser extends ezcTemplateSourceToTstParser
{
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

    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( $this->block->name == "include" )
        {
            return $this->parseInclude( $cursor );
        }
        elseif( $this->block->name == "return" )
        {
            return $this->parseReturn( $cursor );
        }

        return false;
    }

    protected function parseInclude( ezcTemplateCursor $cursor )
    {
        $this->findNextElement();

        if ( !$this->parseOptionalType( "Expression", null, false ) )
        {
           throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION );
        }
 
        $include = new ezcTemplateIncludeTstNode( $this->parser->source, $this->startCursor, $this->currentCursor );
        $include->file = $this->lastParser->rootOperator;

        $this->findNextElement();

        if ( $this->currentCursor->match( 'send' ) )
        {
            $include->send = $this->parseExprAsVarArray( true );
        }

        if ( $this->currentCursor->match( 'receive' ) )
        {
            $include->receive = $this->parseVarAsVarArray( false );
        }


        if ( !$this->currentCursor->match( '}' ) )
        {
           throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE );
        }

        $this->appendElement( $include );
        return true;
    }

    protected function parseReturn( ezcTemplateCursor $cursor )
    {
        $return = new ezcTemplateReturnTstNode( $this->parser->source, $this->startCursor, $this->currentCursor );

        $return->variables = $this->parseExprAsVarArray( true );

        if ( !$this->currentCursor->match( '}' ) )
        {
           throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE );
        }

        $this->appendElement( $return );
        return true;
    }

    protected function parseExprAsVarArray( $symbolCheck )
    {
        $variables = array();

        do
        {
            $this->findNextElement();

            if ( $this->parseOptionalType( "Expression", null, false ) )
            {
                if ( $this->lastParser->rootOperator instanceof ezcTemplateVariableTstNode )
                {
                    $asOptional = true;
                } 
                else
                {
                    $asOptional = false;
                }

                // $asOptional = false;
                $lastVal = $this->lastParser->rootOperator;
                $this->findNextElement();
            } 
            else
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VARIABLE );
            }

            if ( $this->currentCursor->match( 'as' ) )
            {
                $expr = $lastVal;  
                $this->findNextElement();

                if ( !$this->parseOptionalType( "Variable", null, false ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VARIABLE );
                }
 
                $variables[ $this->lastParser->element->name ] = $expr ;
            }
            else
            {
                if ( !$asOptional )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_AS );
                }

                $variables[ $lastVal->name ] = null;
            }



            $this->findNextElement();
        }
        while ( $this->currentCursor->match( ',' ) );


        return $variables;
    }

    protected function parseVarAsVarArray( $symbolCheck )
    {
        $variables = array();

        do
        {
            $this->findNextElement();

            if ( !$this->parseOptionalType( "Variable", null, false ) )
            {
               throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VARIABLE );
            }

            if ( $symbolCheck )
            {
                if ( !$this->parser->symbolTable->retrieve( $this->lastParser->element->name ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, $this->parser->symbolTable->getErrormessage() );
                }
            }
            else
            {
                if ( !$this->parser->symbolTable->enter( $this->lastParser->element->name, ezcTemplateSymbolTable::VARIABLE ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, $this->parser->symbolTable->getErrormessage() );
                }
            }

            $this->findNextElement();

            if ( $this->currentCursor->match( 'as' ) )
            {
                $oldName = $this->lastParser->element->name;
                $this->findNextElement();

                if ( !$this->parseOptionalType( "Variable", null, false ) )
                {
                   throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VARIABLE );
                }

                if ( !$this->parser->symbolTable->enter( $this->lastParser->element->name, ezcTemplateSymbolTable::VARIABLE ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor,  $this->parser->symbolTable->getErrormessage() );
                }
  
                $variables[ $oldName ] = $this->lastParser->element->name;
            }
            else
            {
                $variables[] = $this->lastParser->element->name;
            }

        }
        while ( $this->currentCursor->match( ',' ) );

        return $variables;
   }


    // TODO, remove atEnd, nodes can determine their own 'end'.
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        return ( $cursor->current( 1 ) == "}"  || $cursor->current( 1 ) == "," );
    }

    protected function parseSubDefineBlock( $symbolType )
    {
        $isFirst = true; // First Variable parse, may be invalid. Return false in that case. 

        do
        {
            $this->findNextElement();

            $declaration = new ezcTemplateDeclarationTstNode( $this->parser->source, $this->startCursor, $this->currentCursor );
            $declaration->isClosingBlock = false;
            $declaration->isNestingBlock = false;

            if ( ! $this->parseOptionalType( "Variable", $this->currentCursor, false ) )
            {
                if ( $isFirst ) return false;

                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VARIABLE );
            }

            $isFirst = false;
            $declaration->variable = $this->lastParser->elements[0];

            // Variable name.
            if ( !$this->parser->symbolTable->enter( $declaration->variable->name, $symbolType ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor,  $this->parser->symbolTable->getErrorMessage() );
            }

            $this->findNextElement();

            if ( $this->currentCursor->match( "=" ) )
            {
                $this->findNextElement();

                if ( !$this->parseOptionalType( "Expression", null, false ) )
                {
                    if ( $this->parseOptionalType( "Identifier", null, false ) )
                    {
                        throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION_NOT_IDENTIFIER );
                    }
                    else
                    {
                        throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION );
                    }
                }

                $declaration->expression = $this->lastParser->rootOperator;
            }

            $this->appendElement( $declaration );
            $this->findNextElement();

        } while ( $this->currentCursor->match( "," ) );

        return true;
   }

}

?>
