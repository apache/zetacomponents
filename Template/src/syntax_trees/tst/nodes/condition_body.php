<?php
/**
 * File containing the ezcTemplateConditionBodyTstNode class
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
 * The condition body.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateConditionBodyTstNode extends ezcTemplateBlockTstNode
{
    /**
     * The conditions.
     * @var ezcTemplateAstNode
     */
    public $condition;

    /**
     * Constructs a new ezcTemplateConditionBodyTstNode.
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->condition = null;

        $this->isNestingBlock = false;
    }

    /**
     * Returns the tree properties.
     *
     * @return array(string=>mixed)
     */
    public function getTreeProperties()
    {
        return array( 'condition' => $this->condition,
                      'children'  => $this->children );
    }

    /**
     * Checks if the given element can be attached to its parent.
     *
     * @throws ezcTemplateParserException if the element cannot be attached.
     * @return void
     */
    public function canAttachToParent( $parentElement )
    {
        if ( !$parentElement instanceof ezcTemplateIfConditionTstNode )
        {
            if ( $parentElement instanceof ezcTemplateProgramTstNode )
            {
               throw new ezcTemplateParserException( $this->source, $this->startCursor, $this->startCursor, 
                   "{" . $this->name . "} can only be a child of an {if} block." );
            } 

            throw new ezcTemplateParserException( $this->source, $this->startCursor, $this->startCursor, 
               "The block {" . $this->name . "} cannot be a sub-block of {".$parentElement->name."}. {".$this->name."} can only be a child of an {if} block." );
        }
    }


}
?>
