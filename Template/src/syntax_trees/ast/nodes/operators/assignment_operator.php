<?php
/**
 * File containing the ezcTemplateAssignmentOperatorAstNode class
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
 * Represents the PHP assignment operator =
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateAssignmentOperatorAstNode extends ezcTemplateBinaryOperatorAstNode
{
    /**
     * Initialize operator code constructor with 2 parameters (binary).
     */
    /*public function __construct()
    {
        parent::__construct( self::OPERATOR_TYPE_BINARY );
    }
    */

    public function checkAndSetTypeHint()
    {
        $symbolTable = ezcTemplateSymbolTable::getInstance();

        $this->typeHint = $this->parameters[1]->typeHint;

        if ( $this->parameters[0] instanceof ezcTemplateVariableAstNode )
        {
             if ( $symbolTable->retrieve( $this->parameters[0]->name ) == ezcTemplateSymbolTable::IMPORT )
             {
                 // It can be anything.
                 $symbolTable->setTypeHint( $this->parameters[0]->name, self::TYPE_ARRAY | self::TYPE_VALUE );
             }
             else
             {
                $symbolTable->setTypeHint( $this->parameters[0]->name, $this->typeHint );
             }
        }
    }


    
    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '=';
    }
}
?>
