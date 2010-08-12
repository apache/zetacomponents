<?php
/**
 * File containing the ezcTemplateIfAstNode class
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
 * Represents an if control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateIfAstNode extends ezcTemplateStatementAstNode
{
    /**
     * Array of expressions which represents the conditions for the if, elseif
     * and else entries. The first entry is used for the if, the last for the
     * else and the one in between for elseif.
     * @var array(ezcTemplateConditionBodyAstNode)
     */
    public $conditions;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateConditionBodyAstNode $conditionBody
     */
    public function __construct( ezcTemplateConditionBodyAstNode $conditionBody = null )
    {
        parent::__construct();
        if ( $conditionBody !== null )
        {
            $this->conditions[] = $conditionBody;
        }
    }

    /**
     * Appends the condition object to the current list of conditions.
     *
     * @param ezcTemplateConditionBodyAstNode $condition Append an extra condition block.
     */
    public function appendCondition( ezcTemplateConditionBodyAstNode $condition )
    {
        $this->conditions[] = $condition;
    }

    /**
     * Returns the last condition object from the body.
     * If there are no conditions in the body it returns null.
     *
     * @return ezcTemplateConditionBodyAstNode
     */
    public function getLastCondition()
    {
        $count = count( $this->conditions );
        if ( $count === 0 )
        {
            return null;
        }
        return $this->conditions[$count - 1];
    }
}
?>
