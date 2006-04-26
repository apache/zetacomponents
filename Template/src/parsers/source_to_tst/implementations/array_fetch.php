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
 * Parser for array fetch expressions.
 *
 * An array fetch looks like:
 * <code>
 * SQUARE_BRACKET_START <expression> SQUARE_BRACKET_END
 * e.g.
 * [5]
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateArrayFetchSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The array fetch element operator object if the parser was succesful.
     * @var ezcTemplateArrayFetchOperatorTstNode
     */
    public $fetch;

    const MSG_EXPECT_EXPRESSION = "Expression expected";

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

   /**
     * Parses the array fetch expression by using the generic expression parser.
     * The expression will callback the atEnd() function to figure out if the
     * end is reached or not.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        // This parser is created when a square bracket has been found so we
        // mark that we have already parsed something.
        $this->status = self::PARSE_PARTIAL_SUCCESS;

        $failedParser = null;

        /*
        if( !$cursor->match("[") )
        {
            return false;
        }
        */
        
        // $cursor will be update as the parser continues
        $this->fetch = $this->parser->createArrayFetch( clone $this->startCursor, $cursor );

        while ( true )
        {
            $this->findNextElement();

            $expressionParser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
            $expressionParser->allowIdentifier = true;

            if ( !$this->parseRequiredType( $expressionParser ) )
            {
                throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_EXPECT_EXPRESSION );
            }

                $this->fetch->endCursor = clone $this->lastParser->currentOperator->endCursor;
                $this->fetch->appendParameter( $this->lastParser->currentOperator );
                $this->parser->reportElementCursor( $this->fetch->startCursor, $this->fetch->endCursor, $this->fetch );

            return true;
        }
        return false;
    }
}

?>
