<?php
/**
 * File containing the ezcTemplateBoolSourceToTstParser class
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
 * Parser for boolean types.
 *
 * Booleans are defined in the same way as in PHP.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateBoolSourceToTstParser extends ezcTemplateLiteralSourceToTstParser
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
     * Parses the boolean types by looking for either 'true' or 'false'.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            // @todo This should check that there is no alphabetical characters
            //       after the true|false.
            $matches = $cursor->pregMatchComplete( "#^(true|false)(?:\W)#i" );
            if ( $matches === false )
                return false;

            $name = $matches[1][0];

            $lower = strtolower( $name );
            if ( $name !== $lower )
            {
                $this->findNonLowercase();
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_BOOLEAN_NOT_LOWERCASE );
            }

            $cursor->advance( strlen( $name ) );
            $bool = new ezcTemplateLiteralTstNode( $this->parser->source, $this->startCursor, $cursor );
            $bool->value = $name == 'true';
            $this->value = $bool->value;
            $this->element = $bool;
            $this->appendElement( $bool );
            return true;
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
        return "boolean";
    }
}

?>
