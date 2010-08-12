<?php
/**
 * File containing the ezcTemplateLiteralSourceToTstParser class
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
 * Parser for all builtin types.
 *
 * Literal types are parsed by utilizing the various sub-parser for known
 * types.
 *
 * Once the type has been parsed it can be fetched by using the
 * property $value for the value and $element for the element object.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateLiteralSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * The value of the parsed type or null if nothing was parsed.
     * @var mixed
     */
    public $value;

    /**
     * The parsed element object which defines the type or null if nothing
     * was parsed.
     *
     * @var ezcTemplateTstNode
     */
    public $element;

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
        $this->value = null;
        $this->element = null;
    }

    /**
     * Parses the types by utilizing:
     * - ezcTemplateFloatSourceToTstParser for float types.
     * - ezcTemplateIntegerSourceToTstParser for integer types.
     * - ezcTemplateStringSourceToTstParser for string types.
     * - ezcTemplateBoolSourceToTstParser for boolean types.
     * - ezcTemplateArraySourceToTstParser for array types.
     *
     * @param ezcTemplateCursor $cursor
     * @return bool
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $failedParser = null;
        if ( !$cursor->atEnd() )
        {
            // Try parsing the various type types until one is found
            $failedCursor = clone $cursor;

            $types = array( 'Float', 'Integer', 'String', 'Bool', 'Array', 'Null' );
            foreach ( $types as $type )
            {
                if ( $this->parseOptionalType( $type ) )
                {
                    $this->lastCursor->copy( $this->startCursor );
                    $this->value = $this->lastParser->value;
                    $this->element = $this->lastParser->element;
                    return true;
                }
            }
        }
        return false;
    }
}

?>
