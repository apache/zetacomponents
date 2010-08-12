<?php
/**
 * File containing the ezcTemplateRootAstNode class
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
 * Represents the root node of the AST tree. This node may contain settings of the template.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateRootAstNode extends ezcTemplateBodyAstNode
{
    /**
     * Whether or not the template uses the cache.
     * 
     * @var bool
     */
    public $cacheTemplate = false;

    /**
     * The cache keys in this template
     *
     * @var array(ezcTemplateAstNode)
     */
    public $cacheKeys = array();

    /**
     * The time to live of the cache.
     * 
     * @var ezcTemplateAstNode
     */
    public $ttl = null;

    /**
     * Is this template the start of the program.
     * 
     * @var bool
     */
    public $startProgram = true;

    /**
     * The character set that the template uses.
     *
     * @var string
     */
    public $charset = false;

    /**
     * The current translation context in effect.
     *
     * @var string
     */
    public $translationContext = null;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param array(ezcTemplateAstNode) $statements
     * @param bool $startProgram
     */
    public function __construct( Array $statements = null, $startProgram = true )
    {
        parent::__construct();
        $this->startProgram = $startProgram;
    }
}
?>
