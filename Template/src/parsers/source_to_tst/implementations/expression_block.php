<?php
/**
 * File containing the ezcTemplateExpressionBlockSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for template blocks containing an expression only.
 *
 * Parses inside the blocks {...} and looks for an expression by using the
 * ezcTemplateExpressionSourceToTstParser class.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateExpressionBlockSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The bracket start character.
     * @var string
     */
    public $startBracket;

    /**
     * The bracket end character.
     * @var string
     */
    public $endBracket;

    /**
     * The block element object which is the result of the parse operation.
     * @var ezcTemplateOutputBlockTstNode
     */

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->startBracket = '{';
        $this->endBracket = '}';
        $this->block = null;
    }

    /**
     * Returns true if the current character is a curly bracket (}) which means
     * the end of the block.
     */
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        if ( $cursor->current( strlen( $this->endBracket ) ) == $this->endBracket )
        {
            if ( !$finalize )
                return true;

            // reached end of expression
            $cursor->advance( 1 );
            $this->block->endCursor = clone $this->block->endCursor;
//            $this->block->element = $operator; // removed, not needed
//            $this->appendElement( $this->block );
            return true;
        }
        return false;
    }

    /**
     * Parses the expression by using the ezcTemplateExpressionSourceToTstParser class.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( $this->parser->debug )
            echo "Starting expression using brackets ", $this->startBracket, '...', $this->endBracket, "\n";

        // $cursor will be update as the parser continues
        if ( $this->startBracket == '(' )
        {
            // This is a parenthesis so we use a different node type
            $this->block = $this->parser->createParenthesis( clone $this->startCursor, $cursor );
            $this->block->startBracket = $this->startBracket;
            $this->block->endBracket = $this->endBracket;
        }
        else
        {
            $this->block = $this->parser->createOutputBlock( clone $this->startCursor, $cursor );
            $this->block->startBracket = $this->startBracket;
            $this->block->endBracket = $this->endBracket;
        }

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        $allowIdentifier = false;

        // Check for expression, the parser will call atEnd() of this class to
        // check for end of the expression.
        $expressionParser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
        $expressionParser->setAllCursors( $cursor );
        $expressionParser->startCursor = clone $cursor;
        $expressionParser->allowEmptyExpressions = true;
        if ( !$this->parseRequiredType( $expressionParser /*'Expression'*/, $this->startCursor, false ) )
            return false;

        $this->findNextElement();

        $rootOperator = $this->lastParser->currentOperator;
        if ( $rootOperator instanceof ezcTemplateOperatorTstNode )
        {
            $rootOperator = $rootOperator->getRoot();

            if ( $this->parser->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n expression yielded:\n";
                echo "<", $this->startCursor->subString( $cursor->position ), ">\n";
                echo ezcTemplateTstTreeOutput::output( $rootOperator );
                echo "\n\n\n";
                // *** DEBUG END ***
            }
        }

        // If there is no root operator the block is empty, change the block type.
        if ( $rootOperator === null )
        {
            $this->block = $this->parser->createEmptyBlock( clone $this->startCursor, $cursor );
            $this->appendElement( $this->block );
            return true;
        }

        // Change the block type if the top-most operator is a modifiying operator.
        if ( $rootOperator instanceof ezcTemplateModifyingOperatorTstNode )
        {
            // @todo if the parser block is a parenthesis it is not allowed to have modifying nodes
            $oldBlock = $this->block;
            $this->block = $this->parser->createModifyingBlock( clone $this->startCursor, $cursor );
            $this->block->startBracket = $this->startBracket;
            $this->block->endBracket = $this->endBracket;
            $this->block->elements = $oldBlock->elements;
        }

        $this->block->expressionRoot = $rootOperator;
        $this->block->elements = array( $rootOperator );
        $this->appendElement( $this->block );

        return true;
    }
}

?>
