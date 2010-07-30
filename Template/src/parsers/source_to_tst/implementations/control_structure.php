<?php
/**
 * File containing the ezcTemplateControlStructureSourceToTstParser class
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
 * Parser for template blocks containing an expression only.
 *
 * Parses inside the blocks {...} and looks for an expression by using the
 * ezcTemplateExpressionSourceToTstParser class.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateControlStructureSourceToTstParser extends ezcTemplateSourceToTstParser
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
     * Returns true if the current character is a curly bracket (}) which means
     * the end of the block.
     *
     * @param ezcTemplateCursor $cursor
     * @param ezcTemplateTstNode $operator  
     * @param bool $finalize
     * @return bool
     */
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        if ( $cursor->current() == '}' )
        {
            if ( !$finalize )
                return true;

            // reached end of expression
            $cursor->advance( 1 );
            $this->block->endCursor = clone $this->block->endCursor;
            $this->appendElement( $this->block );
            return true;
        }
        return false;
    }

    /**
     * Parses the statements, foreach, while, if, elseif, etc. 
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        // Check if any control structure names are used.
        // Note: The code inside the (?:) brace ensures that the next character
        // is not an alphabetical character ie. a word boundary
        $matches = $cursor->pregMatchComplete( "#^(tr|tr_context|foreach|while|if|elseif|else|switch|case|default|include|return|break|continue|skip|delimiter|increment|decrement|reset|charset|capture)(?:[^a-zA-Z0-9_])#" );

        if ( $matches === false )
        {
            return false;
        }

        $name = $matches[1][0];
        $cursor->advance( strlen( $matches[1][0] ) );

        // control structure map
        $csMap = array();
        $csMap['foreach'] = 'ForeachLoop';
        $csMap['for'] = 'ForLoop';
        $csMap['while'] = 'WhileLoop';
        $csMap['if'] = 'IfCondition';
        $csMap['elseif'] = 'IfCondition';
        $csMap['else'] = 'IfCondition';
        $csMap['switch'] = 'SwitchCondition';
        $csMap['case'] = 'SwitchCondition';
        $csMap['default'] = 'SwitchCondition';
        $csMap['include'] = 'Include';
        $csMap['return'] = 'Include';
        $csMap['break'] = 'Loop';
        $csMap['continue'] = 'Loop';
        $csMap['skip'] = 'Delimiter';
        $csMap['delimiter'] = 'Delimiter';
        $csMap['increment'] = 'Cycle';
        $csMap['decrement'] = 'Cycle';
        $csMap['reset'] = 'Cycle';
        $csMap['charset'] = 'Charset';
        $csMap['capture'] = 'Capture';
        $csMap['tr'] = 'Translation';
        $csMap['tr_context'] = 'TranslationContext';

        // tmp
        if ( !isset( $csMap[$name] ) )
        {
            return false;
        }

        $parser = 'ezcTemplate' . $csMap[$name] . 'SourceToTstParser';

        // tmp
        if ( !ezcBaseFeatures::classExists( $parser ) )
        {
            return false;
        }

        if ( !ezcBaseFeatures::classExists( $parser ) )
        {
            throw new ezcTemplateInternalException( "Requested parser class <{$parser}> does not exist" );
        }


        $controlStructureParser = new $parser( $this->parser, $this, null );
        $this->block->name = $name;
        $controlStructureParser->block = $this->block;
        if ( !$this->parseRequiredType( $controlStructureParser ) )
        {
            return false;
        }
        return true;
    }
}

?>
