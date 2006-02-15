<?php
/**
 * File containing the ezcTemplateWhileLoopSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for while / do..while loops.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateWhileLoopSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * Bad/missing condition.
     */
    const STATE_BAD_CONDITION = 1;

    /**
     * "while" keyword in missing in {/do}.
     */
    const STATE_NO_WHILE_KEYWORD = 2;

    /**
     * {do} element not found while parsing {/do}.
     */
    const STATE_BAD_DO_HEADER = 3;

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
        $name = $this->block->name;
        $this->status = self::PARSE_PARTIAL_SUCCESS;
        $isDo = ( $name == 'do' );

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        // If it's {while} or {/do} then parse the condition
        if ( $isDo == $this->block->isClosingBlock )
        {
            if ( $isDo )
            {
                // skip "while" keyword
                if ( $cursor->current( 5 ) != 'while' )
                {
                    $this->operationState = self::STATE_NO_WHILE_KEYWORD;
                    return false;
                }

                $cursor->advance( 5 );

                // skip whitespace and comments
                if ( !$this->findNextElement() )
                    return false;
            }

            if ( !$this->parseRequiredType( 'Expression', null, false ) )
            {
                $this->operationState = self::STATE_BAD_CONDITION;
                return false;
            }

            $condition = $this->lastParser->rootOperator;
        }

        if ( !$this->parentParser->atEnd( $cursor, null, false ) )
            return false;

        // Everything went well. Let's create the element.
        $cursor->advance();
        $el = $this->parser->createWhileLoop( $this->startCursor, $cursor );
        $el->name = $name;
        if ( isset( $condition ) )
            $el->condition = $condition;
        $el->isClosingBlock = $this->block->isClosingBlock;
        $this->appendElement( $el );

        return true;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_BAD_CONDITION:
                return 'Bad/missing condition.';

            case self::STATE_NO_WHILE_KEYWORD:
                return "'while' keyword expected.";

            case self::STATE_BAD_DO_HEADER:
                return "No corresponding {do} open tag.";
        }

        // Default error message handler.
        return parent::generateErrorMessage();
    }
}

?>
