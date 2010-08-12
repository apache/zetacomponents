<?php
/**
 * File containing the ezcTemplateModifyingOperatorTstNode class
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
 * Interface for modifying operator elements in parser trees.
 *
 * Modifying operators are those which directly alters their operand.
 * These operators are currently: ++$a, --$a, $a++ and $a--
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
abstract class ezcTemplateModifyingOperatorTstNode extends ezcTemplateOperatorTstNode
{
    /**
     * Initialize element with source and cursor positions.
     *
     * @param ezcTemplateSourceCode $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     * @param int $precedence
     * @param int $order
     * @param int $associativity
     * @param string $symbol
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end,
                                 $precedence, $order, $associativity, $symbol )
    {
        parent::__construct( $source, $start, $end,
                             $precedence, $order, $associativity, $symbol );
    }
}
?>
