<?php
/**
 * File containing the ezcTemplateBlockCommentSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for block comments.
 *
 * Block comments start with a slash (/) and an asterix (*) and ends with an
 * asterix (*) and a slash (/).
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateBlockCommentSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * No ending for block comment.
     */
    const STATE_NO_ENDING = 1;

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the comment by looking for the end marker * + /.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $this->status = self::PARSE_PARTIAL_SUCCESS;
        $this->operationState = self::STATE_NO_ENDING;
        if ( !$cursor->atEnd() )
        {
            $cursor->advance( 2 );

            $tagPos = $cursor->findPosition( '*/' );
            if ( $tagPos !== false )
            {
                // reached end of comment
                $cursor->gotoPosition( $tagPos + 2 );
                $commentBlock = $this->parser->createBlockComment( $this->startCursor, clone $cursor );
                $commentBlock->commentText = substr( $commentBlock->text(), 2, -2 );
                $this->appendElement( $commentBlock );
                return true;
            }

        }
        return false;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_ENDING:
                return "Missing end of block comment, expected */ but none was found in code.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_ENDING:
                return "Accepted syntax is: /*...*/";
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
