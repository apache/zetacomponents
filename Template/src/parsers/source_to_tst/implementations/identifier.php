<?php
/**
 * File containing the ezcTemplateIdentifierSourceToTstParser class
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
 * Parser for identifier types.
 *
 * Identifiers consists of a-z, A-Z, underscore (_) and numbers only.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateIdentifierSourceToTstParser extends ezcTemplateLiteralSourceToTstParser
{
    /**
     * The identifier which was found while parsing or null if no identifier
     * has been found yet.
     *
     * @var string
     */
    public $identifierName;

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
        $this->identifierName = null;
    }

    /**
     * Parses the identifier types by looking for allowed characters.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            $matches = $cursor->pregMatch( "#^[a-zA-Z_][a-zA-Z0-9_]*#" );
            if ( $matches !== false )
            {
                $identifier = new ezcTemplateIdentifierTstNode( $this->parser->source, $this->startCursor, $cursor );
                $identifier->value = (string)$matches;
                $this->identifierName = $identifier->value;
                $this->element = $identifier;
                $this->appendElement( $identifier );
                return true;
            }
        }
        return false;
    }
}

?>
