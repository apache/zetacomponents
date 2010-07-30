<?php
/**
 * File containing the ezcTemplateArraySourceToTstParser class
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
 * Parser for array types.
 *
 * Arrays are defined in the same way as in PHP.
 * <code>
 * array( [<expression> => ] <expression> [, [<expression> => ] <expression> ] )
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArraySourceToTstParser extends ezcTemplateLiteralSourceToTstParser
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
     * Parses the array types by looking for 'array(...)' and then using the
     * generic expression parser (ezcTemplateExpressionSourceToTstParser) to fetch the
     * keys and values.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        // skip whitespace and comments
        if ( !$this->findNextElement() )
            return false;

        $name = $cursor->pregMatch( "#^array[^\w]#i", false );
        if ( $name === false )
        {
            return false;
        }

        $lower = strtolower( $name );
        if ( $name !== $lower )
        {
            $this->findNonLowercase();
            throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_ARRAY_NOT_LOWERCASE );
        }

        $cursor->advance( 5 );

        // skip whitespace and comments
        $this->findNextElement();

        if ( !$cursor->match( '(' ) )
        {
            throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ROUND_BRACKET_OPEN );
        }

        $currentArray = array();
        $currentKeys  = array();
        $expectItem = true;

        $elementNumber = 0;
        while ( true )
        {
            // skip whitespace and comments
            if ( !$this->findNextElement() )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ROUND_BRACKET_CLOSE );
            }

            if ( $cursor->current() == ')' )
            {
                $cursor->advance();
                $array = new ezcTemplateLiteralArrayTstNode( $this->parser->source, $this->startCursor, $cursor );
                $array->keys = $currentKeys;
                $array->value = $currentArray;

                $this->element = $array;

                $this->appendElement( $array );
                return true;
            }

            if ( !$expectItem )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_ROUND_BRACKET_CLOSE_OR_COMMA );
            }

            // Check for type
            if ( !$expectItem || !$this->parseRequiredType( 'Expression' ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_LITERAL );
            }

            $this->findNextElement();

            if ( $cursor->match( '=>' ) )
            {
                // Found the array key. Store it, and continue with the search for the value.
                $currentKeys[  $elementNumber ] =  $this->lastParser->rootOperator;
                $this->findNextElement();

                // We have the key => value syntax so we need to find the value
                if ( !$this->parseRequiredType( 'Expression' ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_LITERAL );
                }

                // Store the value.
                $currentArray[ $elementNumber ] = $this->lastParser->rootOperator;
                $elementNumber++;
            }
            else
            {
                // Store the value.
                $currentArray[ $elementNumber ] = $this->lastParser->rootOperator;
                $elementNumber++;
            }

            if ( $this->lastParser->rootOperator instanceof ezcTemplateModifyingOperatorTstNode )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_MODIFYING_EXPRESSION_NOT_ALLOWED );
            }


            $this->findNextElement();

            // We allow a comma after the key/value even if there are no more
            // entries. This is compatible with PHP syntax.
            if ( $cursor->match( ',' ) )
            {
                $this->findNextElement();
                $expectItem = true;
            }
            else
            {
                $expectItem = false;
            }
        }
    }

    /**
     * Returns a string representing the current type.
     *
     * @return string
     */
    public function getTypeName()
    {
        return "array";
    }
}

?>
