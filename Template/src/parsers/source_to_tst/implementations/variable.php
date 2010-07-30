<?php
/**
 * File containing the ezcTemplateVariableSourceToTstParser class
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
 * Parser for variable definitions.
 *
 * Variables are defined in the same way as in PHP.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateVariableSourceToTstParser extends ezcTemplateSourceToTstParser
{
 
    /**
     * The variable name which was found while parsing or null if no variable
     * has been found yet.
     *
     * @var string
     */
    public $variableName;

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
        $this->variable = null;
        $this->variableName = null;
    }

    /**
     * Parses the variable types by looking for a dollar sign followed by an
     * identifier. The identifier is parsed by using ezcTemplateIdentifierSourceToTstParser.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            if ( $cursor->match( '$' ) )
            {
                if ( $cursor->current() == '#' )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                            ezcTemplateSourceToTstErrorMessages::MSG_INVALID_VARIABLE_NAME, ezcTemplateSourceToTstErrorMessages::LNG_INVALID_NAMESPACE_ROOT_MARKER );
                }

                if ( $cursor->current() == ':' )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                            ezcTemplateSourceToTstErrorMessages::MSG_INVALID_VARIABLE_NAME, ezcTemplateSourceToTstErrorMessages::LNG_INVALID_NAMESPACE_MARKER );
                }

                if ( !$this->parseRequiredType( 'Identifier', null, false ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_VARIABLE_NAME, ezcTemplateSourceToTstErrorMessages::MSG_INVALID_IDENTIFIER );

                    return false;
                }

                $this->variableName = $this->lastParser->identifierName;

                $variable = new ezcTemplateVariableTstNode( $this->parser->source, $this->startCursor, $cursor );
                $variable->name = $this->variableName;
                $this->element = $variable;
                $this->appendElement( $variable );
                return true;
            }
        }
        return false;
    }
}

?>
