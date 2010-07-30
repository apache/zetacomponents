<?php
/**
 * File containing the ezcTemplateDocCommentSourceToTstParser class
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
 * @version //autogen//
 * @access private
 */
class ezcTemplateDocCommentSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * Passes control to parent.
     *
     * @param ezcTemplateParser $parser
     * @param ezcTemplateSourceToTstParser $parentParser
     * @param ezcTemplateCursor $startCursor
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the comment by looking for the end marker * + }.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
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
        {
            return false;
        }
        
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
                $cursor->gotoPosition( $inlineCommentPosition );
                return false;
            }
        }

        // reached end of comment
        $cursor->gotoPosition( $endPosition + 2 );
        $commentBlock = new ezcTemplateDocCommentTstNode( $this->parser->source, clone $this->startCursor, clone $cursor );
        $commentBlock->commentText = substr( $commentBlock->text(), 2, -2 );
        $this->appendElement( $commentBlock );
        return true;
    }
}

?>
