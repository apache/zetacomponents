<?php
/**
 * File containing the ezcTemplateDynamicBlockTstNode  class
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */
/**
 * The dynamic block node contains the possible the dynamic block.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDynamicBlockTstNode extends ezcTemplateBlockTstNode
{
    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->name = 'dynamic';
    }

    public function getTreeProperties()
    {
        return array( 'children' => $this->children );
    }

    /**
     * Checks if the given node can be attached to its parent.
     *
     * @throws ezcTemplateParserException if the node cannot be attached.
     * @param ezcTemplateTstNode $parentElement
     * @return void
     */
    public function canAttachToParent( $parentElement )
    {
        // Must at least have one parent with cache_block, or be after cache_template

        $p = $parentElement;

        while ( !$p instanceof ezcTemplateProgramTstNode )
        {
            if ( $p instanceof ezcTemplateCacheBlockTstNode )
            {
                return; // Perfect, we are inside a cache_block
            }

            $p = $p->parentBlock;
        }

        if ( $p instanceof ezcTemplateProgramTstNode )
        {
            foreach ( $p->children as $node )
            {
                if ( $node instanceof ezcTemplateCacheTstNode )
                {
                    return; // Perfect, we are after cache_template
                }
            }
        }

        throw new ezcTemplateParserException( $this->source, $this->startCursor, $this->startCursor, 
            "{" . $this->name . "} can only be a child of {cache_template} or a {cache_block} block." );
    }
}
?>
