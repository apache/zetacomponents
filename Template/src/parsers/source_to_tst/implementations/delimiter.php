<?php
/**
 * File containing the ezcTemplateDelimiterSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for {delimiter}.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDelimiterSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->block = null;
    }

    /**
     * Parses the expression by using the ezcTemplateExpressionSourceToTstParser class.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        // handle closing block
        if ( $this->block->isClosingBlock )
        {
            if ( $this->parser->debug )
                echo "Starting end of foreach loop\n";

            $this->findNextElement();
            if ( !$this->parentParser->atEnd( $cursor, null, false ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor,  ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE );
            }

            $cursor->advance();

            $el = $this->parser->createDelimiter( $this->startCursor, $cursor );
            $el->isClosingBlock = true;
            $this->appendElement( $el );
            return true;
        }

        // handle opening block
        if ( $this->block->name == "delimiter" )
        {
            $delimiter = $this->parser->createDelimiter( $this->startCursor, $cursor );
            $this->findNextElement();
            if ( $this->currentCursor->match("modulo") )
            {
                $this->findNextElement();

                if ( !$this->parseOptionalType( 'Expression', null, false ) )
                {
                    throw new ezcTemplateSourceToTstParserException( $this, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION );
                }

                $delimiter->modulo = $this->lastParser->rootOperator;

                if ( $this->currentCursor->match("is") )
                {
                    $this->findNextElement();
                    if ( !$this->parseOptionalType( 'Expression', null, false ) )
                    {
                        throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION );
                    }
                        
                    $delimiter->rest = $this->lastParser->rootOperator;
                    $this->findNextElement();
                }
                else
                {
                    $delimiter->rest = new ezcTemplateLiteralTstNode( $this->parser->source, $this->startCursor, $this->endCursor);
                    $delimiter->rest->value = 0;
                }
            }


            $this->appendElement( $delimiter );


            if ( !$this->parentParser->atEnd( $cursor, null, false ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                    $canBeArrow ?  ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ARROW_OR_CLOSE_CURLY_BRACKET :
                                   ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE  );
            }

            $cursor->advance();
            return true;
        }
        elseif( $this->block->name == "skip" )
        {
            $skip = $this->parser->createLoop( $this->startCursor, $cursor, "skip" );

            $this->findNextElement();

            if ( !$this->parentParser->atEnd( $cursor, null, false ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE );
            }

            $cursor->advance();
            $this->appendElement( $skip );
            return true;
        }

        return false;
    }
}

?>
