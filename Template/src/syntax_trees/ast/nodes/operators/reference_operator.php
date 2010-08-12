<?php
/**
 * File containing the ezcTemplateReferenceOperatorAstNode class
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
 * Represents the PHP reference operator '->'
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateReferenceOperatorAstNode extends ezcTemplateBinaryOperatorAstNode
{
    /**
     * Constructs a new reference operator.
     *
     * @param ezcTemplateAstNode $parameter1
     * @param ezcTemplateAstNode $parameter2
     */
    public function __construct( $parameter1 = null, $parameter2 = null)
    {
        parent::__construct( $parameter1, $parameter2 );

        // Everything is possible. Member variables can be a property (changing the type).
        // Functions can return anything.
        $this->typeHint = self::TYPE_ARRAY | self::TYPE_VALUE;
    }
    

    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '->';
    }
}
?>
