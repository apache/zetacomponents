<?php
/**
 * File containing the ezcTemplateBlockSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Figures out if the end as been reached and returns true if it has.
     *
     * The end is reached when it finds the character ].
     */
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        if ( $cursor->current() == ']' )
        {
            if ( !$finalize )
                return true;

            $endCursor = clone $cursor;
            $cursor->advance( 1 );
            if ( $operator !== null )
            {
                $this->fetch->endCursor = clone $operator->endCursor;
                $this->fetch->appendParameter( $operator );
                $this->parser->reportElementCursor( $this->fetch->startCursor, $this->fetch->endCursor, $this->fetch );
            }
            else
            {
                $this->fetch->endCursor = $endCursor;
            }
            return true;
        }
        return false;
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

        // $cursor will be update as the parser continues
        $this->fetch = $this->parser->createArrayFetch( clone $this->startCursor, $cursor );

        // skip the [ character
        $cursor->advance();

        while ( !$cursor->atEnd() )
        {
            // skip whitespace and comments
            if ( !$this->findNextElement() )
                return false;

            if ( $this->atEnd( $cursor, null ) )
                // We allow for no expression, ie. a [] call.
                return true;

            // Check for expression, the parser will call self::atEnd() to check for end of expression.
            $expressionParser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
            $expressionParser->allowIdentifier = true;
            if ( !$this->parseRequiredType( $expressionParser ) )
                return false;

            return true;
        }
        return false;
    }
}

?>
