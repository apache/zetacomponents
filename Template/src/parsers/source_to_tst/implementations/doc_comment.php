<?php
/**
 * File containing the ezcTemplateDocCommentSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for doc comment blocks.
 *
 * Doc comments start with a curly bracket ({) and an asterix (*) and ends with
 * an asterix (*) and a curly bracket (}).
 * e.g.
 * <code>
 * {* This is a doc comment *}
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateDocCommentSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * No ending for doc comment.
     */
    const STATE_NO_ENDING = 1;

    /**
     * Inline comment found, this is most likely an inline comment and not a doc comment.
     */
    const STATE_FOUND_INLINE_COMMENT = 2;

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the comment by looking for the end marker * + }.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $this->status = self::PARSE_PARTIAL_SUCCESS;
        $this->operationState = self::STATE_NO_ENDING;

        $cursor->advance();
        if ( $cursor->atEnd() )
            return false;

        $checkInlineComment = false;
        // Check for a slash after the asterix, this typically means a typo for an inline comment
        // Better give an error for this to warn the user.
        if ( $cursor->current() == '/' )
        {
            $checkInlineComment = true;
        }

        $endPosition = $cursor->findPosition( '*}' );
        if ( $endPosition === false )
            return false;

        // If we found an end for an inline comment we need to check if there
        // is an end for an inline comment
        if ( $checkInlineComment )
        {
            $commentCursor = $cursor->cursorAt( $cursor->position, $endPosition );
            $commentCursor->advance();
            $inlineCommentPosition = $commentCursor->findPosition( '*/' );
            // We found the end of the inline comment, this is most likely a user error
            if ( $inlineCommentPosition !== false )
            {
                $this->operationState = self::STATE_FOUND_INLINE_COMMENT;
                $cursor->gotoPosition( $inlineCommentPosition );
                return false;
            }
        }

        // reached end of comment
        $cursor->gotoPosition( $endPosition + 2 );
        $commentBlock = $this->parser->createDocComment( clone $this->startCursor, clone $cursor );
        $commentBlock->commentText = substr( $commentBlock->text(), 2, -2 );
        $this->appendElement( $commentBlock );
        return true;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_ENDING:
                return "Missing end of doc comment block, expected *} but none was found in code.";
            case self::STATE_FOUND_INLINE_COMMENT:
                return "Inline comment found in doc comment.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_ENDING:
                return "Accepted syntax is: {*...*}";
            case self::STATE_FOUND_INLINE_COMMENT:
                return "The doc comment contains code which looks like an inline comment, most likely\nan inline comment was meant to be used but the two first characters got swapped\naccidently.\nIf this is meant to be a doc comment make sure there is a space between the\nasterix and the slash.\ni.e.\n{* /";
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
