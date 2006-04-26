<?php
/**
 * File containing the ezcTemplateLiteralBlockSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for template blocks containing an literal only.
 *
 * Parses inside the blocks {...} and looks for an literal by using the
 * ezcTemplateLiteralParser class.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateLiteralBlockSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * No ending brace for literal block.
     */
    const STATE_NO_ENDING_BRACE = 1;

    /**
     * The starting brace for the end literal block was not found.
     */
    const STATE_NO_END_BLOCK_STARTING_BRACE = 2;

    /**
     * The ending brace for the end literal block was not found.
     */
    const STATE_NO_END_BLOCK_ENDING_BRACE = 2;

    /**
     * The block element object which is the result of the parse operation.
     * @var ezcTemplateLiteralBlockTstNode
     */
    public $block;

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->block = null;
    }

    /**
     * Parses the literal by using the ezcTemplateLiteralParser class.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( $this->parser->debug )
            echo "Starting literal\n";
        // $cursor will be update as the parser continues
        $this->block = $this->parser->createLiteralBlock( clone $this->startCursor, $cursor );

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // Check if the block contains 'literal'
        if ( $cursor->current( 7 ) != 'literal' )
            return false;

        // Skip 'literal' text.
        $cursor->advance( 7 );

        $this->status = self::PARSE_PARTIAL_SUCCESS;

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // Assume end of first {literal} block
        if ( $cursor->current() != '}' )
        {
            $this->operationState = self::STATE_NO_ENDING_BRACE;
            return false;
        }

        $cursor->advance();

        $literalTextCursor = clone $cursor;

        $this->operationState = self::STATE_NO_END_BLOCK_STARTING_BRACE;
        // Start searching for ending literal block.
        while ( !$cursor->atEnd() )
        {
            // Find the next block
            $tagPos = $cursor->findPosition( "{" );
            if ( $tagPos === false )
            {
                $this->operationState = self::STATE_NO_END_BLOCK_STARTING_BRACE;
                return false;
            }

            $tagCursor = clone $cursor;
            $tagCursor->gotoPosition( $tagPos - 1 );
            if ( $tagCursor->current() == "\\" )
            {
                // This means the tag is escaped and should be treated as text.
                $cursor->copy( $tagCursor );
                $cursor->advance( 2 );
                unset( $tagCursor );
                continue;
            }

            // Reached a block {...}
            $cursor->gotoPosition( $tagPos );
            $literalTextEndCursor = clone $cursor;
            $cursor->advance();

            $continue = false;
            while ( !$cursor->atEnd() )
            {
                // skip whitespace and comments
                if ( !$this->findNextElement() )
                    return false;

                // Check for end, if not continue search
                if ( $cursor->current( 8 ) != '/literal' )
                {
                    $continue = true;
                    break;
                }

                $cursor->advance( 8 );

                // skip whitespace and comments
                if ( !$this->findNextElement() )
                    return false;

                if ( $cursor->current() == '}' )
                {
                    $this->block->textStartCursor = $literalTextCursor;
                    $this->block->textEndCursor = $literalTextEndCursor;
                    $cursor->advance();
                    $this->block->endCursor = clone $cursor;

                    // Make sure the text is extracted now that the cursor are correct
                    $this->block->storeText();
                    $this->appendElement( $this->block );
                    return true;
                }
                $this->operationState = self::STATE_NO_END_BLOCK_ENDING_BRACE;
            }
            if ( $continue )
                continue;
        }

        return false;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_ENDING_BRACE:
                return "Missing ending brace for literal block.";
            case self::STATE_NO_END_BLOCK_ENDING_BRACE:
                return "Missing ending brace for closing literal block.";
            case self::STATE_NO_END_BLOCK_STARTING_BRACE:
                return "Missing starting brace for closing literal block.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_ENDING_BRACE:
            case self::STATE_NO_END_BLOCK_ENDING_BRACE:
            case self::STATE_NO_END_BLOCK_STARTING_BRACE:
                return "Accepted syntax is: {literal}...{/literal}";
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
