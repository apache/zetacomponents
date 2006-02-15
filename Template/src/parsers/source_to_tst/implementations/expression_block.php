<?php
/**
 * File containing the ezcTemplateExpressionBlockSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
     * @var ezcTemplateExpressionBlockTstNode
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
            $this->block->element = $operator;
            $this->appendElement( $this->block );
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
        $this->block = $this->parser->createExpressionBlock( clone $this->startCursor, $cursor );
        $this->block->startBracket = $this->startBracket;
        $this->block->endBracket = $this->endBracket;

        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        $allowIdentifier = false;

        // Check for expression, the parser will call atEnd() of this class to
        // check for end of the expression.
        if ( !$this->parseRequiredType( 'Expression', $this->startCursor, false ) )
            return false;

        $rootOperator = $this->lastParser->currentOperator;
        if ( $rootOperator instanceof ezcTemplateOperatorTstNode )
        {
            $rootOperator = $rootOperator->getRoot();

            if ( $this->parser->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n expression yielded:\n";
                echo "<", $this->startCursor->subString( $cursor->position ), ">\n";
                echo $rootOperator->outputTree();
                echo "\n\n\n";
                // *** DEBUG END ***
            }
        }
        $this->block->expressionRoot = $rootOperator;
        $this->block->elements = array( $rootOperator );

        return true;
    }
}

?>
