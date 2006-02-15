<?php
/**
 * File containing the ezcTemplateBlockCommentSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for end-of-line comments.
 *
 * EOL comments start with a double slash (//) and goes on until the end of the
 * line.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateEolCommentSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the comment by looking for the end marker \n.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            $cursor->advance( 2 );

            $matches = $cursor->pregMatch( "#(.+)(\r|\r\n|\n)#" );
            if ( $matches )
            {
                // reached end of comment
                $cursor->advance( $matches[2][1] + strlen( $matches[2][0] ) );
            }
            else
            {
                $cursor->gotoEnd();
            }
            $commentBlock = $this->parser->createEolComment( $this->startCursor, clone $cursor );
            $commentBlock->commentText = substr( $commentBlock->text(), 2, -1 );
            $this->appendElement( $commentBlock );
            return true;
        }
        return false;
    }
}

?>
