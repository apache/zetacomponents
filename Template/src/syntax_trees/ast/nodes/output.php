<?php
/**
 * File containing the ezcTemplateOutputAstNode class
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
 * Represents a node that should be sent to the output.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateOutputAstNode extends ezcTemplateAstNode
{
    /**
     * The expression that should be output. 
     *
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Whether the output should be sent as raw (no context escaping).
     *
     * @var bool
     */
    public $isRaw;

    /**
     * Constructs a new output node.
     *
     * @param ezcTemplateAstNode $expression
     */
    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }
}
?>
