<?php
/**
 * File containing the ezcTemplateConstantAstNode class
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
 * Represents PHP constants.
 *
 * Creating the type is done by simply passing the constant name to the
 * constructor which will take care of storing it and exporting it to PHP
 * code later on.
 *
 * <code>
 * $c = new ezcTemplateConstantAstNode( 'E_NOTICE' );
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateConstantAstNode extends ezcTemplateAstNode
{
    /**
     * The value for the constant.
     */
    public $value;

    /**
     * Constructs a new ezcTemplateConstantAstNode
     *
     * @param mixed $value The value of constant.
     */
    public function __construct( $value )
    {
        parent::__construct();
        $this->value = $value;
    }

}
?>
