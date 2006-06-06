<?php
/**
 * File containing the ezcTemplateSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Super class for all element parsers.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
abstract class ezcTemplateSourceToTstParser
{
    /**
     * Status for the parser which means the parser has not been started.
     * This is the initial status of all parser objects.
     */
    const PARSE_NOT_STARTED = 1;

    /**
     * Status for the parser which means the parser was able to find some
     * elements it recognized but in the end it failed.
     */
    const PARSE_PARTIAL_SUCCESS = 2;

    /**
     * Status for the parser which means the parser was able to parser all
     * known elements.
     */
    const PARSE_SUCCESS = 3;

    /**
     * Status for the parser which means the parser was not able to find some
     * anything it recognized.
     *
     * This usually means the parser cannot handle the current location and
     * another parser type should be tried.
     */
    const PARSE_FAILURE = 4;

    /**
     * The main parser object which instigated the total parser operation.
     * This is used to create the various parser elements and to handle
     * operor precedence.
     *
     * @var ezcTemplateParser
     */
    public $parser;

    /**
     * The parent parser for this parser.
     * If this is non-null it means another parser started the current one.
     * The parent can be used to call atEnd() to figure out if the end has been
     * reached, allowing the current parser to only concentrate on its own parser
     * elements.
     *
     * @var ezcTemplateSourceToTstParser
     */
    public $parentParser;

    public $programParser;

    /**
     * An array of elements which have been created by the parsers.
     * @var array(ezcTemplateTstNode)
     */
    public $elements;

    /**
     * The status of the parsing operation, can be one of:
     * - PARSE_NOT_STARTED - The parser has not yet been started.
     * - PARSE_PARTIAL_SUCCESS - The parser found something it work on but still failed.
     * - PARSE_SUCCESS - The parser was able to parse the entire entity.
     * - PARSE_FAILURE - The parser failed parsing the entity.
     * @var int
     */
    public $status;

    /**
     * The starting point for the parse operation. This must never be modified.
     * @var ezcTemplateParserCursor
     */
    public $startCursor;

    /**
     * The last point where the parser tried to parse a special entity. This can
     * be used to determine a more exact location of where the entity is found.
     * @note This is initially set to same cursor location as $startCursor.
     * @var ezcTemplateParserCursor
     */
    public $lastCursor;

    /**
     * The current position in the parsing, this is used by the parser to keep track
     * of where it is.
     * @note This is initially set to same cursor location as $startCursor.
     * @var ezcTemplateParserCursor
     */
    public $currentCursor;

    /**
     * The position where the parsing ended.
     * @note This is initially set to same cursor location as $startCursor.
     * @var ezcTemplateParserCursor
     */
    public $endCursor;

    /**
     * Contains the sub-parser object used by parseOptionalType() or parseRequiredType().
     *
     * @note Do not use this after a call to the above methods, instead use
     *       $lastParser.
     * @var ezcTemplateSourceToTstParser
     * @see $lastParser
     */
    public $subParser;

    /**
     * Contains the last used sub-parser object which is created when
     * parseOptionalType() or parseRequiredType() is called.
     *
     * @var ezcTemplateSourceToTstParser
     * @see $subParser
     */
    public $lastParser;

    /**
     * The state of the last parser operation, determines how far the parser got.
     * This value is used to generate a meaningful error message when the parser
     * fails.
     *
     * @note The value of the state is not generic and is only known to the
     *       specific parser.
     * @var int
     */
    protected $operationState;

    /**
     * Initialise the parser with the main parser object and the parent parser
     * (if any).
     *
     * @note If both $parentParser and $startCursor is null then all cursor
     *       objects will be null. A call to setAllCursors() is required before
     *       the parser is started.
     *
     * @param ezcTemplateParser $parser The parser manager which instigated the
     *                                  current total parser operation.
     * @param ezcTemplateSourceToTstParser $parentParser The element parser which
     *                                               directly instantiated this parser.
     * @param ezcTemplateCursor $startCursor Defines the start of the parse
     *                                            operation, can be ommitted in
     *                                            which case the current cursor
     *                                            if the parent is used.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser,
                          /*ezcTemplateCursor*/ $startCursor )
    {
        $this->parser = $parser;
        $this->parentParser = $parentParser;
        // Make sure program parser is set correctly
        if ( $parentParser !== null )
            $this->programParser = $parentParser->programParser;
        else
            $this->programParser = $this;
        $this->elements = array();
        $this->subParser = null;
        $this->lastParser = null;
        $this->status = self::PARSE_NOT_STARTED;

        if ( $this->parentParser !== null )
        {
            // Copy current cursor from parent to all cursors.
            if ( $startCursor !== null )
            {
                $this->startCursor = clone $startCursor;
                $this->lastCursor = clone $this->parentParser->lastCursor;
                if ( $this->startCursor->position > $this->lastCursor->position )
                    $this->lastCursor->copy( $this->startCursor );
            }
            else
            {
                $this->startCursor = clone $this->parentParser->currentCursor;
                $this->lastCursor = clone $this->startCursor;
            }
            $this->currentCursor = clone $this->lastCursor;
            $this->endCursor = clone $this->currentCursor;
            if ( $parser->debug )
            {
                echo "starting ", get_class( $this ), " at ";
                echo $this->startCursor->position, ",";
                echo $this->lastCursor->position, ",";
                echo $this->currentCursor->position, ",";
                echo $this->endCursor->position, "\n";
            }
        }
        else
        {
            // Set cursors to null, they must now be initialized with setAllCursors().
            if ( $parser->debug )
                echo "starting ", get_class( $this ), " at nowhere\n";
            $this->startCursor = null;
            $this->lastCursor = null;
            $this->currentCursor = null;
            $this->endCursor = null;
        }

        $this->operationState = false;
    }

    /**
     * Set all cursors to the position of $cursor. This means all parsing starts
     * from this position.
     * @param ezcTemplateParser $cursor The cursor position to use.
     */
    public function setAllCursors( ezcTemplateCursor $cursor )
    {
        $this->startCursor = clone $cursor;
        $this->lastCursor = clone $cursor;
        $this->currentCursor = clone $cursor;
        $this->endCursor = clone $cursor;
    }

    /**
     * Figures out if the end as been reached and returns true if it has.
     * This must be re-implemented by block parser which will utilize a
     * sub-parser which does a callback to this method.
     *
     * The default throws an exception.
     */
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        if ( $this->parentParser !== null )
            // The $finalize flag is not automatically sent to parent
            return $this->parentParser->atEnd( $cursor, $operator, false );
        // @todo Use specific exception
        throw new Exception( "atEnd() called on parser <" . get_class( $this ) . "> which has not implemented it properly." );
    }

    /*!
     * Skips whitespace which is present at the current cursor position until
     * it reaches a non-whitespace character.
     *
     * The following charaters are considered whitespace:
     * - newlines (\r \r\n and \n)
     * - space
     * - tab (\t)
     * @param ezcTemplateCursor $cursor The cursor object to process.
     * @note The passed object will be modified.
     * @return false if the end of the buffer is reached while processing, true otherwise.
     */
    public function skipWhitespace()
    {
        if ( $this->currentCursor->atEnd() )
            return false;

        if ( $this->currentCursor->pregMatch( "#^(\r\n|[\r\n\t ])+#") === false )
            return true;

        return !$this->currentCursor->atEnd();
    }

    /**
     * Merges the elements from the parser object $parser with the current elements
     * by appending them to the end of the list.
     *
     * @param ezcTemplateSourceToTstParser $parser The parser object which contains parsed elements.
     */
    public function mergeElements( $parser )
    {
        $this->elements = array_merge( $this->elements, $parser->elements );
    }

    /**
     * Appends the template element to the end of the current list.
     *
     * @param ezcTemplateTstNode $element The element object to add to list.
     */
    public function appendElement( $element, $report = true )
    {
        $this->elements[] = $element;
        if ( $report )
            $this->parser->reportElementCursor( $element->startCursor, $element->endCursor, $element );
    }

    /**
     * @todo Use specific exception class.
     */
    protected function parseOptionalType( $type, ezcTemplateCursor $startCursor = null, $mergeElements = true )
    {
        if ( is_string( $type ) )
        {
            $className = 'ezcTemplate' . $type . 'SourceToTstParser';
            if ( !class_exists( $className ) )
                throw new Exception( "Could instantiate sub-parser for type <$type>, the class <$className> does not exist" );

            $this->subParser = new $className( $this->parser, $this, $startCursor );
        }
        else if ( is_object( $type ) &&
                  $type instanceof ezcTemplateSourceToTstParser )
        {
            $this->subParser = $type;
        }
        else
        {
            throw new Exception( "Cannot use <" . gettype( $type ) . "> as parser in ezcTemplateSourceToTstParser::parseOptionalType()" );
        }
        $this->lastParser = $this->subParser;
        $this->subParser->parse();
        if ( $this->subParser->status == self::PARSE_SUCCESS )
        {
            if ( $this->parser->debug )
                echo "sub-parser ", get_class( $this->subParser ), " was successful from ",
                    $this->subParser->startCursor->position, " to ",
                    $this->subParser->endCursor->position, ", returning true\n";
            $this->currentCursor->copy( $this->subParser->endCursor );
            $this->lastCursor->copy( $this->currentCursor );
            if ( $mergeElements )
                $this->mergeElements( $this->subParser );
            $this->subParser = null;
            return true;
        }
        elseif ( $this->subParser->status === self::PARSE_PARTIAL_SUCCESS )
        {
            $this->status = $this->subParser->status;
            if ( $this->parser->debug )
            {
                echo "sub-parser ", get_class( $this->subParser ), " failed partially from ",
                    $this->subParser->startCursor->position, " to ",
                    $this->subParser->endCursor->position;
                echo ", returning true\n";
            }
            return true;
        }

        if ( $this->parser->debug )
            echo "sub-parser ", get_class( $this->subParser ), " failed from ",
                $this->subParser->startCursor->position, " to ",
                $this->subParser->endCursor->position, ", returning false\n";
        $this->subParser = null;
        return false;
    }

    /**
     * @todo Use specific exception class.
     */
    protected function parseRequiredType( $type, ezcTemplateCursor $startCursor = null, $mergeElements = true )
    {
        if ( is_string( $type ) )
        {
            $className = 'ezcTemplate' . $type . 'SourceToTstParser';
            if ( !class_exists( $className ) )
                throw new Exception( "Could instantiate sub-parser for type <$type>, the class <$className> does not exist" );

            $this->subParser = new $className( $this->parser, $this, $startCursor );
        }
        else if ( is_object( $type ) &&
                  $type instanceof ezcTemplateSourceToTstParser )
        {
            $this->subParser = $type;
        }
        else
        {
            throw new Exception( "Cannot use <" . gettype( $type ) . "> as parser in ezcTemplateSourceToTstParser::parseRequiredType()" );
        }
        $this->lastParser = $this->subParser;
        $this->subParser->parse();
        if ( $this->subParser->status == self::PARSE_SUCCESS )
        {
            if ( $this->parser->debug )
                echo "sub-parser ", get_class( $this->subParser ), " was successful from ",
                    $this->subParser->startCursor->position, " to ",
                    $this->subParser->endCursor->position, ", returning true\n";
            $this->currentCursor->copy( $this->subParser->endCursor );
            $this->lastCursor->copy( $this->currentCursor );
            if ( $mergeElements )
                $this->mergeElements( $this->subParser );
            $this->subParser = null;
            return true;
        }
        elseif ( $this->subParser->status === self::PARSE_PARTIAL_SUCCESS )
        {
            $this->status = $this->subParser->status;
            if ( $this->parser->debug )
            {
                echo "sub-parser ", get_class( $this->subParser ), " failed partially from ",
                    $this->subParser->startCursor->position, " to ",
                    $this->subParser->endCursor->position;
                echo ", returning true\n";
            }
            return false;
        }

        if ( $this->parser->debug )
            echo "sub-parser ", get_class( $this->subParser ), " failed from ",
                $this->subParser->startCursor->position, " to ",
                $this->subParser->endCursor->position, ", returning false\n";
        return false;
    }

    /**
     * Parses the source code starting from {@link $currentCursor current cursor}.
     * The actual parsing is done by the abstract method parseCurrent() which must be
     * implemented in sub-classes.
     *
     * If the parse operation was a success it returns true and $currentCursor
     * and $endCursor will contain the position where the parser stopped. Also
     * $status will be set accordingly.
     *
     * @note If the parsing was successful it will call handleSuccessfulResult()
     *       which can be-reimplemented to perform cleanups or other tasks before
     *       the control passed to the caller.
     * @return bool
     */
    public function parse()
    {
        // The status is failed until at least something recognizable is parsed
        $this->status = self::PARSE_FAILURE;

        if ( $this->parseCurrent( $this->currentCursor ) )
        {
            if ( $this->parser->debug )
            {
                echo "parser ", get_class( $this ), " was successful at ", $this->startCursor->position, "->", $this->currentCursor->position, "\n";
                echo "<", $this->startCursor->subString( $this->currentCursor->position ), ">\n";
            }
            $this->status = self::PARSE_SUCCESS;
        }

        // Update end cursor if we have some sort of success.
        if ( $this->status == self::PARSE_SUCCESS )
        {
            $this->handleSuccessfulResult( $this->lastCursor, $this->currentCursor );

            $this->endCursor->copy( $this->currentCursor );
            return true;
        }
        elseif ( $this->status == self::PARSE_PARTIAL_SUCCESS )
        {
            if ( $this->parser->debug )
                echo "parser ", get_class( $this ), " was partially successful at ", $this->currentCursor->position, "\n";
            // Set end position to the current position.
            $this->endCursor->copy( $this->currentCursor );
        }
        else
        {
            if ( $this->parser->debug )
                echo "parser ", get_class( $this ), " failed at ", $this->currentCursor->position, "\n";
        }
        return false;
    }

    /**
     * Method which is called after a successful parse result in parse().
     *
     * @note The default code does nothing.
     *
     * @param ezcTemplateCursor $lastCursor The last cursor position, copy of $this->lastCursor.
     * @param ezcTemplateCursor $cursor The current cursor position, copy of $this->currentCursor.
     */
    protected function handleSuccessfulResult( ezcTemplateCursor $lastCursor, ezcTemplateCursor $cursor )
    {
        // The default does nothing
    }

    /**
     * Parses the source code starting from position $cursor.
     *
     * If the parse operation was a success it returns true and $cursor will
     * contain the position where the parser stopped.
     *
     * @param ezcTemplateCursor $cursor Same object as $this->currentCursor,
     *                                       provided for convenience.
     * @return bool
     */
    abstract protected function parseCurrent( ezcTemplateCursor $cursor );

    /**
     * Parses the source code starting from position $cursor. The starting point
     * is passed in $startCursor and can be different from $cursor if some code
     * has already been parsed.
     *
     * If the parse operation was a success it returns true and $cursor will
     * contain the position where the parser stopped.
     *
     * @note The $startCursor parameter will never be modified so there is no
     *       need to clone the passing object, while for $cursor it should be
     *       cloned since it will be modified.
     *
     * @param ezcTemplateCursor $startCursor The position of the code which
     *                                            caused this parser to be activated.
     * @param ezcTemplateCursor $cursor The position to continue the parsing,
     *                                       this is usually at least one character
     *                                       after $startCursor.
     * @param bool $allowFailure Controls how failure are handled, if this is true
     *                           then the function will return false on failure,
     *                           if not it will throw an exception on failure.
     * @return bool
     *
     */
//    abstract protected function parseCurrent( ezcTemplateCursor $startCursor, ezcTemplateCursor $cursor, $allowFailure = false );


    /**
     * Returns the parser object which failed.
     *
     * Scans trough all sub-parser until the last one is found and returned.
     *
     * @return ezcTemplateSourceToTstParser
     */
    public function getFailingParser()
    {
        $parser = $this;
        while ( $parser->subParser !== null )
        {
            $parser = $parser->subParser;
        }
        return $parser;
    }

    /**
     * Returns the error message for the last failed parse operation.
     *
     * @return string
     * @throws Exception when no error message has been implemented in the parser.
     */
    public function getErrorMessage()
    {
        if ( $this->operationState === false )
        {
            // The generic error message
            // sub-class must re-implement this method to give meaningful information.
            return "Parser error.";
        }
        $error = $this->generateErrorMessage();

        if ( !is_string( $error ) )
            throw new Exception( "No error message was returned from " . get_class( $this ) . "::generateErrorMessage" );
        return $error;
    }

    /**
     * Returns the error details for the last failed parse operation
     *
     * @note The details may be empty.
     * @return string
     */
    public function getErrorDetails()
    {
        if ( $this->operationState === false )
        {
            // No more details
            return false;
        }
        return $this->generateErrorDetails();
    }

    /**
     * Generates the error message based on the state information in the parser
     * when the parsing failed.
     *
     * This must be re-implemented by sub-parsers to give meaniningful information.
     * The parser can use the $operationState variable to keep track of what went
     * wrong.
     *
     * @note The default implementation returns false.
     *
     * @return string
     */
    protected function generateErrorMessage()
    {
        // No message generated which will cause an exception
        // This is only called if the sub-class forgot to re-implement this method.
        return false;
    }

    /**
     * Generates the error details based on the state information in the parser
     * when the parsing failed.
     *
     * This can be re-implemented by sub-parsers to give extra information.
     * The parser can use the $operationState variable to keep track of what went
     * wrong.
     *
     * @note The default implementation returns false.
     *
     * @return string
     */
    protected function generateErrorDetails()
    {
        // No more details
        return false;
    }

    /**
     * Parses for known inline comments by using ezcTemplateBlockCommentSourceToTstParser
     * and ezcTemplateEolCommentSourceToTstParser.
     *
     * Depending of what the cursor points the function will do one of:
     * - A comment was found and parsed, it returns true and $startCursor is
     *   adjusted to after comment.
     * - A comment was found and parsing failed, it returns false.
     * - No comment was found, it returns null.
     *
     * @note This function can be used block parser which supports inline comments.
     * @return bool/null
     */
    protected function skipComment()
    {
        if ( $this->currentCursor->current( 2 ) == '/*' )
        {
            // reached block comment
            $commentCursor = clone $this->currentCursor;
            $commentCursor->advance( 2 );

            $subParser = new ezcTemplateBlockCommentSourceToTstParser( $this->parser, $this, $this->currentCursor );
            if ( !$subParser->parse() )
            {
                $this->subParser = $subParser;
                return false;
            }

            $this->currentCursor->copy( $subParser->currentCursor );
            $this->lastCursor->copy( $this->currentCursor );

            return true;
        }

        if ( $this->currentCursor->current( 2 ) == '//' )
        {
            // reached eol comment
            $commentCursor = clone $this->currentCursor;
            $commentCursor->advance( 2 );

            $subParser = new ezcTemplateEolCommentSourceToTstParser( $this->parser, $this, $this->currentCursor );
            if ( !$subParser->parse() )
            {
                $this->subParser = $subParser;
                return false;
            }

            $this->currentCursor->copy( $subParser->currentCursor );
            $this->lastCursor->copy( $this->currentCursor );

            return true;
        }

        // null means to continue current iteration
        return null;
    }

    /**
     * Skips all non-important elements until it reaches the end or a notable
     * element, non-important elements are:
     * - whitespace - performed with skipWhitespace()
     * - comments - performed with skipComment()
     *
     * Returns true if the parsing was successful or false if the end is
     * reached or something went wrong.
     *
     * @return bool
     */
    protected function findNextElement()
    {
        while ( !$this->currentCursor->atEnd() )
        {
            if ( !$this->skipWhitespace() )
                return false;

            // Parse comments if any
            $comment = $this->skipComment();
            if ( $comment === true )
                // We found a comment so we need to try again for new whitespace or comment
                continue;
            elseif ( $comment === false )
                // Comment found but failed parsing
                return false;

            // all whitespace and comments are skipped
            return true;
        }
        return false;
    }

    /**
     * Finds the first character which is not-lowercase.
     * This means it is either uppercase or not alphabetical.
     */
    protected function findNonLowercase()
    {
        if ( $this->currentCursor->atEnd() )
        {
            return false;
        }
        
        if ( $this->currentCursor->pregMatch( "#^[a-z]+#" ) === false )
        {
            return false;
        }
    }

    /**
     * Executes a series of element parsers which is expected to be located
     * in a direct sequence.
     *
     * If all parses are successful it returns the merged element list of all
     * of them, if something fails it returns false.
     *
     * The $sequence parameter is an array of element parser to try, each entry
     * is another array containing:
     * - type - The base name of the element parser, e.g. 'Expresssion' becomes
     *          'ezcTemplateExpressionSourceToTstParser'.
     *
     * @note The element parser is invoked by using parseRequiredType().
     *
     * @param array(array) $sequence The expected sequence to be found.
     * @return array(ezcTemplateTstNode)
     */
    protected function parseSequence( $sequence )
    {
        $cursor = $this->currentCursor;
        $elements = array();

        foreach ( $sequence as $item )
        {
            // skip whitespace and comments
            if ( !$this->findNextElement() )
                return false;

            if ( isset( $item['compound'] ) )
            {
                if ( $item['compound'] == 'or' )
                {
                    $hasMatch = false;
                    foreach ( $item['compounds'] as $compound )
                    {
                        $compoundElements = $this->parseSequence( array( $compound ) );
                        if ( $compoundElements !== false )
                        {
                            $elements += $compoundElements;
                            $hasMatch = true;
                            break;
                        }
                    }
                    if ( !$hasMatch )
                        return false;
                    continue;
                }
                elseif ( $item['compound'] == 'and' )
                {
                    $hasMatch = false;
                    $compoundElements = $this->parseSequence( $item['compounds'] );
                    if ( $compoundElements === false )
                        return false;
                    continue;
                }
                else
                {
                    throw new Exception( "Invalid compound type <" . $item['compound'] . ">" );
                }
            }

            $parserClass = 'ezcTemplate' . $item['type'] . 'SourceToTstParser';
            $comment = false;
            if ( isset( $item['comment'] ) )
                $comment = $item['comment'];

            $parser = new $parserClass( $this->parser, $this, null );
            if ( !$this->parseRequiredType( $parser, null, false ) )
                return false;
            if ( $parser instanceof ezcTemplateExpressionSourceToTstParser )
            {
                $rootOperator = $parser->currentOperator;
                if ( $rootOperator instanceof ezcTemplateOperatorTstNode )
                {
                    $rootOperator = $rootOperator->getRoot();
                }
                $elements[] = $rootOperator;
            }
            else
            {
                $elements = array_merge( $elements, $parser->elements );
            }
        }
        return $elements;
    }
}
?>
