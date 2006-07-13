<?php
/**
 * File containing the ezcTemplateBlockSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for template blocks.
 *
 * Parses inside the blocks {...} by utilizing other elements parsers such as
 * ezcTemplateBlockCommentSourceToTstParser, ezcTemplateEolCommentSourceToTstParser,
 * ezcTemplateDocCommentSourceToTstParser and ezcTemplateExpressionBlockSourceToTstParser
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateBlockSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The parsed block code is not recognized as a valid block.
     */
    const STATE_UNKNOWN_BLOCK = 1;

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the block by using sub parser, the conditions are:
     * - The block contains {*...*} in which case ezcTemplateDocCommentSourceToTstParser is
     *   used.
     * - The block contains a generic expression in which case
     *   ezcTemplateExpressionBlockSourceToTstParser is used.
     *
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $failedParser = null;

        // Check for doc comments which look like {*...*}
        if ( !$cursor->atEnd() &&
             $cursor->current() == '*' )
        {
            // got a doc comment block
            return $this->parseRequiredType( 'DocComment', $this->startCursor );
        }


        // $cursor object in $block will be updated as the parser continues
        $this->block = $this->parser->createBlock( $this->startCursor, $cursor );
        $this->findNextElement();

        // Test for and ending control structure.
        if ( !$cursor->atEnd() && $cursor->current() == '/' )
        {
            // got a closing block marker
            $this->block->isClosingBlock = true;
            $closingCursor = clone $cursor;
            $cursor->advance( 1 );

            $this->findNextElement();
        }


        // Try to parse a control structure
        $controlStructureParser = new ezcTemplateControlStructureSourceToTstParser( $this->parser, $this, null );
        $controlStructureParser->block = $this->block;
        if ( $this->parseOptionalType( $controlStructureParser, null, false ) )
        {
            if ( $this->lastParser->status == self::PARSE_PARTIAL_SUCCESS )
                return false;
            $this->mergeElements( $this->lastParser );
            return true;
        }

        // Try to parse a literal block
        if ( $this->parseOptionalType( 'LiteralBlock', $this->startCursor ) )
            return $this->lastParser->status == self::PARSE_SUCCESS;

        // Try to parse a declaration block
        if ( $this->parseOptionalType( 'DeclarationBlock', $this->startCursor ) )
        {
            return $this->lastParser->status == self::PARSE_SUCCESS;
        }

        // Try to parse as an expression, if this fails the normal block parser
        // is tried.
        if ( $this->parseOptionalType( 'ExpressionBlock', $this->startCursor ) )
        {
            if ( !$this->currentCursor->match( '}' ) )
            {
                if ( $this->currentCursor->match( '[', false ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_UNEXPECTED_SQUARE_BRACKET_OPEN );
                }

                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE );
            }

            return $this->lastParser->status == self::PARSE_SUCCESS;
        }

        if ( $cursor->match( '}' ) )
        {
            // Empty block found, this is allowed but the returned block
            // will be ignored when compiling
            $this->elements[] = $this->lastParser->block;
            return true;
        }

        // Parse the {ldelim} and {rdelim}
        $ldelim = $this->currentCursor->match( "ldelim") ? true : false;
        $rdelim = $this->currentCursor->match( "rdelim") ? true : false;
        if ( $ldelim || $rdelim )
        {
            $this->findNextElement();
            if ( !$this->currentCursor->match( "}" ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE );
            }

            $text = $this->parser->createText( $this->startCursor, $this->endCursor );
            $text->text = $ldelim ? "{" : "}";
            $this->appendElement( $text );
            return true;
        }

        // Try to parse custom blocks, these are pluggable and follows a generic syntax.
        $customBlockParser = new ezcTemplateCustomBlockSourceToTstParser( $this->parser, $this, null );
        $customBlockParser->block = $this->block;
        if ( $this->parseOptionalType( $customBlockParser, null ) )
        {
            return true;
            /*
            $this->elements[] = $this->lastParser->block;
            return true;
             */
        }

        $matches = $cursor->pregMatchComplete( "#^([a-zA-Z_][a-zA-Z0-9_-]*)(?:[^a-zA-Z])#i" );
        throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, sprintf( ezcTemplateSourceToTstErrorMessages::MSG_UNKNOWN_BLOCK, $matches[1][0] ) );
    }

    protected function generateErrorMessage()
    {
        if ( $this->operationState == self::STATE_UNKNOWN_BLOCK )
            return "The parsed block code is not recognized as a valid block.";
        // Default error message handler.
        return parent::generateErrorMessage();
    }
}

?>
