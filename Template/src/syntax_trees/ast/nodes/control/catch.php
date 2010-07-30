<?php
/**
 * File containing the ezcTemplateCatchAstNode class
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
 * Represents a catch control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCatchAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The name of the exception class to catch.
     * @var string
     */
    public $className;

    /**
     * The expression which holds the variable name to use.
     * @var ezcTemplateVariableAstNode
     */
    public $variableExpression;

    /**
     * The body element for the catch statement.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param string $className
     * @param ezcTemplateVariableAstNode $var
     * @param ezcTemplateBodyAstNode $body
     */
    public function __construct( $className, ezcTemplateVariableAstNode $var, ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();

        if ( !is_string( $className ) )
        {
            throw new ezcBaseValueException( "className", $className, 'string' );
        }
        $this->className = $className;
        $this->variableExpression = $var;
        $this->body = $body;
    }
}
?>
