<?php
/**
 * File containing the ezcTemplateDynamicBlockAstNode class
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
 * This node represents a dynamic block inside a template.
 * The dynamic blocks are represented like:
 * <code>
 * {dynamic}
 * ...
 * {/dynamic}
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDynamicBlockAstNode extends ezcTemplateStatementAstNode
{
    /**
     * Boolean to keep track whether the single quotes should be escaped.
     *
     * @var bool
     */
    public $escapeSingleQuote = false;

    /**
     * The body node of this dynamic block.
     *
     * @var ezcTemplateBodyAstNode 
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateBodyAstNode $body
     */
    public function __construct( ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();

        $this->body = $body;
    }

}

?>
