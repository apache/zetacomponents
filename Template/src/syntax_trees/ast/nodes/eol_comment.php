<?php
/**
 * File containing the ezcTemplateEolCommentAstNode class
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
 * Represents PHP comments (EOL style).
 *
 * Comments consists of the start marker and then the comment text. If the text
 * contains newlines it will be split into multiple comment lines all starting
 * with the same marker.
 * The start marker is either a
 * {@link ezcTemplateEolCommentAstNode::MARKER_DOUBLE_SLASH double slash} or a
 * {@link ezcTemplateEolCommentAstNode::MARKER_HASH hash}.
 *
 * Creating a comment:
 * <code>
 * $var = new ezcTemplateEolCommentAstNode( 'A comment with some text' );
 * </code>
 * The corresponding PHP code will be:
 * <code>
 * // A comment with some text
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateEolCommentAstNode extends ezcTemplateStatementAstNode
{
    /**
     * Comment start marker is a double slash.
     */
    const MARKER_DOUBLE_SLASH = 1;

    /**
     * Comment start marker is a hash.
     */
    const MARKER_HASH         = 2;

    /**
     * The text for the comment.
     *
     * @var string
     */
    public $text;

    /**
     * Controls whether space separators are placed between the marker and the
     * comment text.
     *
     * @var bool
     */
    public $hasSeparator;

    /**
     * Type of EOL comment.
     * The type can be on eof:
     * - {@link self::MARKER_DOUBLE_SLASH} for // 
     * - {@link self::MARKER_HASH} for #
     *
     * @var int
     */
    public $type;

    /**
     * Constructs a new ezcTemplateEolCommentAstNode
     *
     * @param string $text         Text for comment.
     * @param bool   $hasSeparator Use spacing separator or not?
     * @param int    $type         Type of EOL comment, see {@link self::$type}.
     */
    public function __construct( $text, $hasSeparator = true, $type = ezcTemplateEolCommentAstNode::MARKER_DOUBLE_SLASH )
    {
        parent::__construct();
        if ( !is_string( $text ) )
        {
            throw new ezcBaseValueException( "text", $text, 'string' );
        }
        $this->text         = $text;
        $this->type         = $type;
        $this->hasSeparator = $hasSeparator;
    }

    /**
     * Returns the text representation of the marker {@link self::$type type}.
     *
     * @return string
     */
    public function createMarkerText()
    {
        switch ( $this->type )
        {
            case self::MARKER_DOUBLE_SLASH:
                return '//';
            case self::MARKER_HASH:
                return '#';
        }
    }
}
?>
