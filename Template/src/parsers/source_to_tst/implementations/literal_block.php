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
 * @version //autogen//
 * @access private
 */
class ezcTemplateLiteralBlockSourceToTstParser extends ezcTemplateSourceToTstParser
{
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
        // $cursor will be update as the parser continues
        $this->block = new ezcTemplateLiteralBlockTstNode( $this->parser->source, clone $this->startCursor, $cursor );

        // skip whitespace and comments
        if ( !$this->findNextElement() )
        {
            return false;
        }

        if( !$cursor->match( "literal" ) )
        {
            return false;
        }

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // Assume end of first {literal} block
        if ( !$cursor->match("}") )
        {
            return false;
        }

        $literalTextCursor = clone $cursor;

        // Start searching for ending literal block.
        while ( !$cursor->atEnd() )
        {
            // Find the next block
            $tagPos = $cursor->findPosition( "{" );
            if ( $tagPos === false )
            {
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
                if ( !$cursor->match( '/literal' ))
                {
                    $continue = true;
                    break;
                }

                // skip whitespace and comments
                if ( !$this->findNextElement() )
                {
                    return false;
                }

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
            }

            if ( $continue )
            {
                continue;
            }
        }

        return false;
    }
}

?>
