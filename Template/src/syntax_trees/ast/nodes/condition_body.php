<?php
/**
 * File containing the ezcTemplateConditionBodyAstNode class
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
 * Represents a condition entry in an if construct.
 * The entry consists of a condition and a body.
 *
 * The condition entry is used to represent an if, else or elseif construct.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateConditionBodyAstNode extends ezcTemplateAstNode
{
    /**
     * The expression holding the condition element.
     * @var ezcTemplateAstNode
     */
    public $condition;

    /**
     * The body element.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with condition and body statement.
     *
     * @param ezcTemplateAstNode $condition
     * @param ezcTemplateBodyAstNode $body
     */
    public function __construct( ezcTemplateAstNode $condition = null, ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->condition = $condition;
        $this->body = $body;
    }
}
?>
