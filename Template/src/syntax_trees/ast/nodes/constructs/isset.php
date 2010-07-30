<?php
/**
 * File containing the ezcTemplateIssetAstNode class
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
 * Represents an isset construct.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateIssetAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression to evaluate if exists.
     * @var array(ezcTemplateAstNode)
     */
    public $expressions;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param array(ezcTemplateAstNode) $expressions
     */
    public function __construct( Array $expressions = null )
    {
        parent::__construct();
        $this->expressions = array();

        if ( $expressions !== null )
        {
            foreach ( $expressions as $expression )
            {
                if ( !$expression instanceof ezcTemplateAstNode )
                {
                    throw new ezcBaseValueException( "expressions[$id]", $expression, 'ezcTemplateAstNode' );
                }
                $this->expressions[] = $expression;
            }
        }
    }

    /**
     * Appends the expression to be checked for existance.
     *
     * @param ezcTemplateAstNode $expression Expression to check.
     */
    public function appendExpression( ezcTemplateAstNode $expression )
    {
        $this->expressions[] = $expression;
    }

    /**
     * Returns a list of expressions which will be checked for existance.
     * @return array(ezcTemplateAstNode)
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * Validates the expressions against their constraints.
     *
     * @throws ezcTemplateInternalException if the constraints are not met.
     */
    public function validate()
    {
        if ( count( $this->expressions ) == 0 )
        {
            throw new ezcTemplateInternalException( "Too few expressions for class <" . get_class( $this ) . ">, needs at least 1 but got 0." );
        }
    }
}
?>
