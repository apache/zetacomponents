<?php
/**
 * File containing the ezcTemplateAssignmentOptimizer
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
 * This class does some very basic assignment optimizations. 
 *
 * <code>
 * $myVar .=  "hello";
 * $myVar .=  " world";
 * </code>
 *
 * Becomes:
 * <code>
 * $myVar .=  "hello world";
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateAstToAstAssignmentOptimizer extends ezcTemplateAstWalker
{
    /**
     * Returns true if the given element consists of &lt;var> = &lt;static value>, otherwise false.
     *
     * @param ezcTemplateAstNode $element
     * @return bool
     */
    protected function isOptimizableConcat( $element )
    {
        if ( $element instanceof ezcTemplateGenericStatementAstNode )
        {
            if ( $element->expression instanceof ezcTemplateConcatAssignmentOperatorAstNode )
            {
                if ( $element->expression->parameters[0] instanceof ezcTemplateVariableAstNode ) 
                {
                    if ( $element->expression->parameters[1] instanceof ezcTemplateLiteralAstNode )
                    {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Returns an optimized AST body from the original AST body $body. 
     *
     * @param ezcTemplateBodyAstNode $body
     * @return bool
     */
    public function visitBodyAstNode( ezcTemplateBodyAstNode $body )
    {
        array_unshift( $this->nodePath, $body );

        $statements = sizeof( $body->statements );
       
        $k = 0;
        $i = 0;
        $j = 1;
        while ( $i < $statements )
        {
            if ( $this->isOptimizableConcat( $body->statements[$i] ) ) 
            {
                while ( $i + $j < $statements && $this->isOptimizableConcat( $body->statements[$i + $j] ) && 
                    ( $body->statements[$i]->expression->parameters[0]->name === $body->statements[$i + $j]->expression->parameters[0]->name ) )
                {
                    $body->statements[$i]->expression->parameters[1]->value .= $body->statements[$i + $j]->expression->parameters[1]->value;
                    $j++;
                }
            }
 
            if ( $k != $i )
            {
                $body->statements[$k] = $body->statements[$i];
            }

            $i += $j;
            $j = 1;
            $k++;
        }

        for( $i = $k; $i < $statements; $i++ )
        {
            unset( $body->statements[$i] );
        }
        
        array_shift( $this->nodePath );

        return $body;
    }
}
?>
