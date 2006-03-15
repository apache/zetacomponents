<?php
/**
 * File containing the ezcTemplateProgramSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Element parser for the program part of the template code.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateProgramSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The program element of the parse operation if the parsing was successful.
     * @var ezcTemplateProgramTstNode
     */
    public $program;

    /**
     * The last block which was processed by the parser. This is used to
     * figure out the correct nesting of block elements.
     */
    private $lastBlock;

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->program = null;
        $this->lastBlock = null;
    }

    /**
     * Parses the code by looking for start of expression blocks and then
     * passing control to the block parser (ezcTemplateBlockSourceToTstParser). The
     * text which is not covered by the block parser will be added as
     * text elements.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $this->program = $this->parser->createProgram( $this->startCursor, $cursor );
        $this->lastBlock = $this->program;

        while ( !$cursor->atEnd() )
        {
            // Find the first block
            $bracePosition = $cursor->findPosition( "{" );
            if ( $bracePosition === false )
            {
                $cursor->gotoEnd();
                // This will cause handleSuccessfulResult() to be called
                return true;
            }

            $tagCursor = clone $cursor;
            $tagCursor->gotoPosition( $bracePosition - 1 );
            if ( $tagCursor->current() == "\\" )
            {
                // This means the tag is escaped and should be treated as text.
                $cursor->copy( $tagCursor );
                $cursor->advance( 2 );
                unset( $tagCursor );
                continue;
            }

            // Reached a block {...}
            $cursor->gotoPosition( $bracePosition );
            $blockCursor = clone $cursor;
            $cursor->advance( 1 );
            if ( $this->lastCursor->length( $blockCursor ) > 0 )
            {
                $textElement = $this->parser->createText( clone $this->lastCursor, clone $blockCursor );
                $this->parser->reportElementCursor( $textElement->startCursor, $textElement->endCursor, $textElement );
                $this->handleElements( array( $textElement ) );
                unset( $textElement );
            }

            $this->startCursor->copy( $blockCursor );
            $this->lastCursor->copy( $cursor );
            if ( !$this->parseRequiredType( 'Block', $this->startCursor, false ) )
            {
                // This will cause handleSuccessfulResult() to be called
                return false;
            }
            $this->startCursor->copy( $cursor );

            $elements = $this->lastParser->elements;
            // Sanity checking to make sure element list does not contain duplicates,
            // this avoids having infinite recursions
            $count = count( $elements );
            if ( $count > 0 )
            {
                $offset = 0;
                while ( $offset < $count )
                {
                    $element = $elements[$offset];
                    for ( $i = $offset + 1; $i < $count; ++$i )
                    {
                        if ( $element === $elements[$i] )
                            throw new Exception( "Received element list with duplicate objects from parser " . get_class( $this->lastParser ) );
                    }
                    ++$offset;
                }
            }
            $this->handleElements( $elements );
        }

        // This will cause handleSuccessfulResult() to be called
        return true;
    }

    /**
     * Performs checking on the parse result.
     *
     * The method will check if there are more text after the current cursor
     * location and if so appends a new ezcTextElement object containing the
     * text.
     *
     * It also checks if the $lastBlock contains the current program parser, if it
     * does not it means the nesting in the current source code is incorrect.
     */
    protected function handleSuccessfulResult( ezcTemplateCursor $lastCursor, ezcTemplateCursor $cursor )
    {
        if ( $lastCursor->length( $cursor ) > 0 )
        {
            $textElement = $this->parser->createText( clone $lastCursor, clone $cursor );
            $this->parser->reportElementCursor( $textElement->startCursor, $textElement->endCursor, $textElement );
            $this->handleElements( array( $textElement ) );
        }

        if ( $this->lastBlock === null )
        {
            throw new Exception( "lastBlock is null, should have been a parser element object." );
        }

        if ( !$this->lastBlock instanceof ezcTemplateProgramTstNode )
        {
            $parents = array();

            // Calculate level of the last block, this used to indent the last block
            $level = 0;
            $block = $this->lastBlock;
            while ( $block->parentBlock !== null &&
                    !( $block->parentBlock instanceof ezcTemplateProgramTstNode ) )
            {
                if ( $block === $block->parentBlock )
                {
                    throw new Exception( "Infinite recursion found in parser element " . get_class( $block ) );
                }

                ++$level;
                $block = $block->parentBlock;
            }

            $block = $this->lastBlock;
//            $parents[] = str_repeat( "  ", $level ) . "{" . $this->lastBlock->name . "} @ {$this->lastBlock->startCursor->line}:{$this->lastBlock->startCursor->column}:";

            // Go trough all parents until the root is reached
            while ( $block->parentBlock !== null &&
                    !( $block->parentBlock instanceof ezcTemplateProgramTstNode ) )
            {
                if ( $block === $block->parentBlock )
                {
                    throw new Exception( "Infinite recursion found in parser element " . get_class( $block ) );
                }

                $block = $block->parentBlock;
                --$level;
                $parents[] = str_repeat( "  ", $level ) . "{" . $block->name . "} @ {$block->startCursor->line}:{$block->startCursor->column}:";
            }

            $parents = array_reverse( $parents );
            $treeText = "The current nesting structure:\n" . join( "\n", $parents );
            $error = new ezcTemplateParserError( array( $this->lastBlock ),
                                                 $this,
                                                 $this->parser->source,
                                                 "Incorrect nesting in code, the block {" . $this->lastBlock->name . "} was not correctly terminated.",
                                                 $treeText );
            throw new ezcTemplateSourceToTstParserException( $error );
        }

        // Get rid of whitespace for the block line of the program element
        $this->parser->trimBlockLine( $this->program );
    }

    public function handleElements( $elements )
    {
        foreach ( $elements as $element )
        {
            // Check if we should place it as a child, this is usually
            // text elements and non-nesting blocks.
            if ( $element->canBeChildOf( $this->lastBlock ) )
            {
                $this->lastBlock->children[] = $element;
                // temporary compatability
                $this->lastBlock->elements = $this->lastBlock->children;
                continue;
            }

            // Check for closure of current block
            if ( $element->isClosingBlock )
            {
                $this->closeOpenBlock( $element );
                continue;
            }

            // The element is handled by the standard routines so we need
            // check if the current block can do something with it
            if ( $this->lastBlock->canHandleElement( $element ) )
            {
                $this->lastBlock->handleElement( $element );
                continue;
            }

            // No special handling required so we check if the element
            // is a nesting block and should start a new nesting level
            if ( $element instanceof ezcTemplateBlockTstNode &&
                 $element->isNestingBlock )
            {
                // Check if the current object is the same as the one being
                // checked as child. If they are the same it means one of
                // parsers has duplicated the element.
                if ( $this->lastBlock === $element )
                {
                    throw new Exception( "Detected infinite recursion creation in parser element " . get_class( $this->lastBlock ) );
                }
                $this->lastBlock->children[] = $element;
                // temporary compatability
                $this->lastBlock->elements = $this->lastBlock->children;

                $element->parentBlock = $this->lastBlock;
                $this->lastBlock = $element;
                continue;
            }

            $error = new ezcTemplateParserError( array( $this->lastBlock, $element ),
                                                 $this,
                                                 $this->parser->source,
                                                 "The element <" . get_class( $element ) . "> could not be handled by current block <" . get_class( $this->lastBlock ) . ">:{$this->lastBlock->name}" );
            throw new ezcTemplateSourceToTstParserException( $error );

            // Element cannot be handled so throw an exception
            throw new ezcTemplateParseException( ezcTemplateParseException::INVALID_PROGRAM_ELEMENT,
                                                 get_class( $element ) );
        }
    }

    protected function closeOpenBlock( $element )
    {
        // The previous element must be a block element,
        // if not throw an exception
        if ( !$this->lastBlock instanceof ezcTemplateBlockTstNode )
        {
            $error = new ezcTemplateParserError( array( $this->lastBlock, $element ),
                                                 $this,
                                                 $this->parser->source,
                                                 "Found closing block {" . $element->name . "} without a previous block element <" . get_class( $this->lastBlock ) . ">" );
            throw new ezcTemplateSourceToTstParserException( $error );
        }

        // The name of the previous element must match the closing block,
        // if not throw an exception
        if ( $this->lastBlock->name != $element->name )
        {
            $error = new ezcTemplateParserError( array( $this->lastBlock, $element ),
                                                 $this,
                                                 $this->parser->source,
                                                 "Found closing block {/" . $element->name . "} which does not match previous block {" . $this->lastBlock->name . "}");
            throw new ezcTemplateSourceToTstParserException( $error );
        }

        // Sanity check
        if ( $this->lastBlock->parentBlock === null )
            throw new Exception( "Parent block of last block <" . get_class( $this->lastBlock ) . "> is null, should not happen." );

        // Call the closing element with the block element it closes,
        // this allows it to update the open block if required.
        $element->closeOpenBlock( $this->lastBlock );

        // Tell the main parser to trim indentation for the block,
        // the whitespace trimming rules are defined within the main parser.
        $this->parser->trimBlockLevelIndentation( $this->lastBlock );

        // Get rid of whitespace for the block line
        $this->parser->trimBlockLine( $this->lastBlock );

        // Go up (closer to program) one level in the nested tree structure
        $this->lastBlock = $this->lastBlock->parentBlock;
    }
}

?>
