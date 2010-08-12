<?php
/**
 * File containing the ezcTemplateLiteralTstNode class
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
 * Builtin literal type value in an expression.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateLiteralTstNode extends ezcTemplateExpressionTstNode
{

    /**
     * The value of the literal type.
     *
     * Note: This value contains null if it is not set yet, this means null is
     *       considered a literal type.
     * @var mixed
     */
    public $value;

    const SINGLE_QUOTE = 1;
    const DOUBLE_QUOTE = 2;

    public $quoteType;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->value = null;
        $this->quoteType = null;
    }

    public function getTreeProperties()
    {
        return array( 'value' => $this->value, 'quoteType' => $this->quoteType );
    }
}
?>
