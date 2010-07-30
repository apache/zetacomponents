<?php
/**
 * File containing the ezcTemplateBlockCommentAstNode class
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
 * Represents PHP comments (Block style).
 *
 * Comments consists of the start marker, the comment text and the end marker.
 * If the text contains newlines each line will be indentended according to
 * indentation level.
 *
 * Creating a comment:
 * <code>
 * $var = new ezcTemplateBlockCommentAstNode( 'A comment with some text' );
 * </code>
 * The corresponding PHP code will be:
 * <code>
 * /* A comment with some text *\/
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateBlockCommentAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The text for the comment.
     *
     * @var string
     */
    public $text;

    /**
     * Controls whether space separators are placed between the start/end marker
     * and the comment text.
     *
     * @var bool
     */
    public $hasSeparator;

    /**
     * Constructs a new ezcTemplateBlockCommentAstNode
     *
     * @param string $text         Text for comment.
     * @param bool   $hasSeparator Use spacing separator or not?
     */
    public function __construct( $text, $hasSeparator = true )
    {
        parent::__construct();
        if ( !is_string( $text ) )
        {
            throw new ezcBaseValueException( "text", $text, 'string' );
        }
        $this->text         = $text;
        $this->hasSeparator = $hasSeparator;
    }
}
?>
