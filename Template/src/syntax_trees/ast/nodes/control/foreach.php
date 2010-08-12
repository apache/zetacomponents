<?php
/**
 * File containing the ezcTemplateForeachAstNode class
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
 * Represents a foreach control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateForeachAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, will return the array to iterate over.
     * @var ezcTemplateAstNode
     */
    public $arrayExpression;

    /**
     * The variable element which holds the name for the key variable to create.
     * This can be set to null to disable the creation of the key variable.
     * @var ezcTemplateVariableAstNode
     */
    public $keyVariable;

    /**
     * The variable element which holds the name of the value variable to create.
     * @var ezcTemplateVariableAstNode
     */
    public $valueVariable;

    /**
     * The body element for the foreach control structure.
     * @var ezcTemplateBodyAstNode
     */

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateAstNode $array
     * @param ezcTemplateVariableAstNode $key
     * @param ezcTemplateVariableAstNode $value
     * @param ezcTemplateBodyAstNode $body
     */
    public function __construct( ezcTemplateAstNode $array = null,
                                 ezcTemplateVariableAstNode $key = null, ezcTemplateVariableAstNode $value = null,
                                 ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->arrayExpression = $array;
        $this->keyVariable = $key;
        $this->valueVariable = $value;
        $this->body = $body;
    }
}
?>
