<?php
/**
 * File containing the ezcTemplateIfConditionSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for {if} control structure.
 *
 * Parses inside the blocks {...} and looks for an expression by using the
 * ezcTemplateExpressionSourceToTstParser class.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateIfConditionSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The array to iterate through is specified incorrectly.
     */
    const STATE_BAD_ARRAY = 1;

    /**
     * No "=>"
     */
    const STATE_NO_EQUALGT = 2;

    /**
     * No/bad item variable.
     *
     * Item variable is the one following "=>".
     * Example: {foreach $objects as $keyVar => $itemVar}
     */
    const STATE_BAD_ITEMVAR = 3;

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

        if ( $name == 'else' )
            return $this->parseElse( $cursor );

        $this->status = self::PARSE_PARTIAL_SUCCESS;

        // handle closing block
        if ( $this->block->isClosingBlock )
        {
            if ( $this->parser->debug )
                echo "Starting end of \"if\"\n";

            // skip whitespace and comments
            if ( !$this->findNextElement() )
                return false;

            if ( !$this->parentParser->atEnd( $cursor, null, false ) )
                return false;
            $cursor->advance();

            $el = $this->parser->createIfCondition( $this->startCursor, $cursor );
            $el->name = 'if';
            $el->isClosingBlock = true;
            $this->appendElement( $el );
            return true;
        }

        // handle opening block

        if ( $this->parser->debug )
            echo "Starting foreach loop\n";

        // parse the conditional expression

        if ( !$this->parseRequiredType( 'Expression', null, false ) )
        {
            $this->operationState = self::STATE_BAD_ITEMVAR;
            return false;
        }

        $condition = $this->lastParser->rootOperator;

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        if ( !$this->parentParser->atEnd( $cursor, null, false ) )
            return false;

        $cursor->advance();
        $el = $this->parser->createIfCondition( $this->startCursor, $cursor );
        $el->name = 'if';
        $el->condition = $condition;
        $this->appendElement( $el );

        return true;
    }

    /**
     * Parse 'else' block.
     */
    private function parseElse( ezcTemplateCursor $cursor )
    {
        /*
        require_once 'bt.php';
        bt();
        die( 'fuck' );
        */
        $cursor->advance();
        $el = $this->parser->createIfCondition( $this->startCursor, $cursor );
        $el->name = 'else';
        $this->appendElement( $el );
        return true;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_BAD_ARRAY:
                return 'Bad array';

            case self::STATE_NO_EQUALGT:
                return "'=>' expected.";

            case self::STATE_BAD_ITEMVAR:
                return "No/bad item variable";
        }

        // Default error message handler.
        return parent::generateErrorMessage();
    }

}

?>
