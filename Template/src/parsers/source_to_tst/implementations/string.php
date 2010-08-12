<?php
/**
 * File containing the ezcTemplateStringSourceToTstParser class
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */
/**
 * Parser for string types.
 *
 * Strings are defined in the same way as in PHP, however the double quoted
 * strings cannot have references to PHP variables inside them.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateStringSourceToTstParser extends ezcTemplateLiteralSourceToTstParser
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
     * Parses the string types by looking for single or double quotes to start
     * the string.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            $char = $cursor->current();
            if ( $char == '"' ||
                 $char == "'" )
            {
                $string = new ezcTemplateLiteralTstNode( $this->parser->source, $this->startCursor, $cursor );
                $string->quoteType = ( $char == "'" ? ezcTemplateLiteralTstNode::SINGLE_QUOTE : ezcTemplateLiteralTstNode::DOUBLE_QUOTE );

                $cursor->advance();

                $nextChar = $cursor->current();
                if ( $nextChar === $char )
                {
                    // We know it is an empty string, no need to extract
                    $str = "";
                    $string->value = $str;
                    $this->value = $string->value;
                    $this->element = $string;
                    $this->appendElement( $string );
                    $cursor->advance();
                    return true;
                }
                else
                {
                    // Match: 
                    // ([^{$char}\\\\]|\A)   : Matches non quote ('"', "'"), non backslash (\), or does match the begin of the statement. 
                    // (\\\\(\\\\|{$char}))* : Eat double slashes \\ and slash quotes: \' or \". 

                    $matches = $cursor->pregMatchComplete( "#(?:([^{$char}\\\\]|\A)(\\\\(\\\\|{$char}))*){$char}#" );

                    if ( $matches === false )
                        return false;

                    $cursor->advance( $matches[0][1] + strlen( $matches[0][0] ) );
                    $str = (string)$this->startCursor->subString( $cursor->position );
                    $str = substr( $str, 1, -1 );

                    $string->value = $str;
                    $this->value = $string->value;
                    $this->element = $string;
                    $this->appendElement( $string );
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns a string representing the current type.
     *
     * @return string
     */
    public function getTypeName()
    {
        return "string";
    }
}

?>
