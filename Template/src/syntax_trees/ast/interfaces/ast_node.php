<?php
/**
 * File containing the ezcTemplateAstNode abstract class
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
 * Abstract class for representing PHP code elements as objects.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
abstract class ezcTemplateAstNode
{
    const TYPE_ARRAY = 1;
    const TYPE_VALUE = 2;

    /**
     * Keep track if the statement returns an Array, a value, or both. 
     * Both is returned when it's not certain what the statement will return.
     *
     * The typeHint information is used to do extra compile time checking.
     * For example, the following template should give a compile time exception:
     * <code>
     * {$a = 2}
     * {foreach $a => $b}
     * {$b}
     * {/foreach}
     * </code>
     *
     * @var int
     */
    public $typeHint = null;

    /**
     * Constructs a new AstNode.
     */
    public function __construct()
    {
    }

    /**
     * Checks if the visitor object is accepted and if so calls the appropriate
     * visitor method in it.
     *
     * The sub classes don't need to implement the usual accept() method.
     *
     * If the current object is: ezcTemplateVariableAstNode then
     * the method: $visitor->visitVariableTstNode( $this ) will be called.
     *
     * @param ezcTemplateAstNodeVisitor $visitor
     *        The visitor object which can visit the current code element.
     * @return ezcTemplateAstNode
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $class = get_class( $this );
        $visit = "visit" . substr( $class, 11 );

        return $visitor->$visit( $this );
    }
}
?>
