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
 * Parser for while loops.
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

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        if ( !$this->block->isClosingBlock )
        {
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
        }

        // Default error message handler.
        return parent::generateErrorMessage();
    }
}

?>
