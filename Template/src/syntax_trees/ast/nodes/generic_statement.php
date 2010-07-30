<?php
/**
 * File containing the ezcTemplateGenericStatementAstNode class
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
 * Represents a function call.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateGenericStatementAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression making up the statement.
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Flag for whether the statement should be terminated with a semicolon or not.
     * This is true by default and can be turned off e.g. when one the expression
     * is contains multiple sub-statements.
     * @var bool
     */
    public $terminateStatement;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateAstNode $expression
     * @param bool $terminateStatement
     */
    public function __construct( ezcTemplateAstNode $expression = null, $terminateStatement = true )
    {
        parent::__construct();

        $this->expression = $expression;
        $this->terminateStatement = $terminateStatement;
    }
}
?>
