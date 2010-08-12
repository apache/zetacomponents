<?php
/**
 * File containing the ezcTemplateFunctionCallTstNode class
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
 * Represents a function call.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateFunctionCallTstNode extends ezcTemplateExpressionTstNode
{
    /**
     * Evaluation is handled by processing each parameter and then calling
     * the function with the resulting parameter values.
     */
    const EVAL_PREPROCESS = 1;

    /**
     * Evaluation is handled dynamically, this allows the function call to
     * to only evaluate selected parameters.
     */
    const EVAL_DYNAMIC = 2;

    /**
     * The name of the function which is going to be called.
     * @var string
     */
    public $name;

    /**
     * Controls how parameters are evaluated when calling the function, can be
     * one of:
     * - EVAL_PREPROCESS
     * - EVAL_DYNAMIC
     *
     * The default value is EVAL_DYNAMIC.
     * @var int
     */
    public $parameterEvaluation;

    /**
     * List of parameters for the current function call, each entry is either a
     * operator, type, variable lookup or other parser element.
     *
     * @var array(ezcTemplateTstNode)
     * @see prependParameter(), appendParameter(), getLastParameter(), setLastParameter(), mergeParameters()
     */
    public $parameters;

    /**
     * Initialize element with source and cursor positions.
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->name = false;
        $this->parameterEvaluation = self::EVAL_PREPROCESS;
        $this->parameters = array();
    }

    public function getTreeProperties()
    {
        return array( 'name' => $this->name,
                      'evaluation' => $this->parameterEvaluation,
                      'parameters' => $this->parameters );
    }

    /**
     * Prepends the element $element as a parameter to the current operator.
     * @param ezcTemplateTstNode
     */
    public function prependParameter( $element )
    {
        $this->parameters = array_merge( array( $element ),
                                         $this->parameters );
    }

    /**
     * Appends the element $element as a parameter to the current operator.
     * @param ezcTemplateTstNode
     */
    public function appendParameter( $element )
    {
        $this->parameters[] = $element;
    }

    /**
     * Returns the last parameter (if set) object of the current operator.
     * @return ezcTemplateTstNode
     */
    public function getLastParameter()
    {
        if ( count( $this->parameters ) > 0 )
            return $this->parameters[count( $this->parameters ) - 1];
        return null;
    }

    /**
     * Returns the number of parameters the operator has.
     * @return int
     */
    public function getParameterCount()
    {
        return count( $this->parameters );
    }

    /**
     * Overwrites the last parameter for the current operator to point to $element.
     * If there are no parameters it is simply appended to the list.
     */
    public function setLastParameter( ezcTemplateTstNode $parameter )
    {
        if ( count( $this->parameters ) > 0 )
            $this->parameters[count( $this->parameters ) - 1] = $parameter;
        else
            $this->parameters[] = $parameter;
    }

    /**
     * Removes the last parameter from the parameter list.
     */
    public function removeLastParameter()
    {
        if ( count( $this->parameters ) > 0 )
            unset( $this->parameters[count( $this->parameters ) - 1] );
    }

}
?>
