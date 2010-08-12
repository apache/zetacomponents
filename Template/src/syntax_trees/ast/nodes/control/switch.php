<?php
/**
 * File containing the ezcTemplateSwitchAstNode class
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
 * Represents a switch control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateSwitchAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, will be used for matching
     * against the cases.
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Array of case statements which are placed inside switch body.
     * @var array(ezcTemplateCaseAstNode)
     */
    public $cases;

    /**
     * Is set to true if the case list contains a default entry.
     * @var bool
     */
    public $hasDefaultCase;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateAstNode $expression
     * @param array(ezcTemplateAstNode) $cases  Should be either ezcTemplateCaseAstNode or ezcTemplateDefaultAstNode.
     */
    public function __construct( ezcTemplateAstNode $expression = null, Array $cases = null )
    {
        parent::__construct();
        $this->expression = $expression;
        $this->cases = array();
        $this->hasDefaultCase = false;

        if ( $cases !== null )
        {
            $hasDefault = false;
            foreach ( $cases as $case )
            {
                if ( !$case instanceof ezcTemplateCaseAstNode )
                {
                    throw new ezcTemplateInternalException( "Array in case list \$cases must consist of object which are instances of ezcTemplateCaseAstNode, not <" . get_class( $case ) . ">." );
                }
                if ( $case instanceof ezcTemplateDefaultAstNode )
                {
                    if ( $hasDefault )
                    {
                        throw new ezcTemplateInternalException( "The default case is already present as a case entry." );
                    }
                    $hasDefault = true;
                }
                $this->cases[] = $case;
            }
            $this->hasDefaultCase = $hasDefault;
        }
    }
}
?>
