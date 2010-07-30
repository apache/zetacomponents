<?php
/**
 * File containing the ezcTemplateBlockSourceToTstParser class
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
 * Parser for array fetch expressions.
 *
 * An array fetch looks like:
 * <code>
 * SQUARE_BRACKET_START <expression> SQUARE_BRACKET_END
 * e.g.
 * [5]
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArrayFetchSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The array fetch element operator object if the parser was succesful.
     * @var ezcTemplateArrayFetchOperatorTstNode
     */
    public $fetch;

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
     * Parses the array fetch expression by using the generic expression parser.
     * The expression will callback the atEnd() function to figure out if the
     * end is reached or not.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        // This parser is created when a square bracket has been found.

        // $cursor will be update as the parser continues
        $this->fetch = new ezcTemplateArrayFetchOperatorTstNode( $this->parser->source, clone $this->startCursor, $cursor );
        $this->findNextElement();

        $expressionParser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
        $expressionParser->allowIdentifier = true;

        if ( !$this->parseRequiredType( $expressionParser ) )
        {
            throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION );
        }

        if ( $this->lastParser->rootOperator instanceof ezcTemplateModifyingOperatorTstNode )
        {
            throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_MODIFYING_EXPRESSION_NOT_ALLOWED );
        }

        $this->fetch->endCursor = clone $this->lastParser->currentOperator->endCursor;
        $this->fetch->appendParameter( $this->lastParser->currentOperator );

        return true;
    }
}

?>
