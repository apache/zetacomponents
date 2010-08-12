<?php
/**
 * File containing the ezcTemplateForAstNode class
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
 * Represents a for control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateForAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, will return set the initial values
     * for iterator variables.
     * Set this to null to skip initial elements.
     * @var ezcTemplateAstNode
     */
    public $initial;

    /**
     * The expression which has the condition for each iteration.
     * @var ezcTemplateAstNode
     */
    public $condition;

    /**
     * The expression which, when evaluated, will increase the iterator
     * variables.
     * Set this to null to skip iteration.
     * @var ezcTemplateAstNode
     */
    public $iteration;

    /**
     * The body element for the for control structure.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateAstNode $initial
     * @param ezcTemplateAstNode $condition
     * @param ezcTemplateAstNode $iteration
     * @param ezcTemplateBodyAstNode $body
     */
    public function __construct( ezcTemplateAstNode $initial = null, ezcTemplateAstNode $condition = null, ezcTemplateAstNode $iteration = null,
                                 ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->initial = $initial;
        $this->condition = $condition;
        $this->iteration = $iteration;
        $this->body = $body;
    }
}
?>
