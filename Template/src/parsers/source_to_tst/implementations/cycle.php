<?php
/**
 * File containing the ezcTemplateCycleSourceToTstParser class
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
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCycleSourceToTstParser extends ezcTemplateSourceToTstParser
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
        $this->block = null;
    }

    /**
     * Parses the expression by using the ezcTemplateExpressionSourceToTstParser class.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( $this->block->name == "increment" || $this->block->name == "decrement" || $this->block->name == "reset" )
        {
            $cycle = new ezcTemplateCycleControlTstNode( $this->parser->source, $this->startCursor, $cursor, $this->block->name );

            do
            {
                $this->findNextElement();
                
                if ( !$this->parseOptionalType( "Variable", null, false) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_VARIABLE );
                }

                $cycle->variables[] = $this->lastParser->elements[0];

                $this->findNextElement();

            }
            while ( $this->currentCursor->match( "," ) );

            $this->appendElement( $cycle );
            // $this->elements[0] = $cycle; // Replace the variable, with the cycle.


            if ( !$this->parentParser->atEnd( $cursor, null, false ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACKET_CLOSE );
            }
            $cursor->advance();

            return true;
        }



        return false;
    }
}

?>
