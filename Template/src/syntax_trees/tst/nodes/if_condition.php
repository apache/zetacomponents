<?php
/**
 * File containing the ezcTemplateIfConditionTstNode class
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
 * Control structure: if.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateIfConditionTstNode extends ezcTemplateBlockTstNode
{
    public $name;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
    }

    public function getTreeProperties()
    {
        return array( 'name'      => $this->name,
                      'children'  => $this->children );
    }

    public function canHandleElement( ezcTemplateTstNode $element )
    {
        if ( $element instanceof ezcTemplateIfConditionTstNode )
        {
            if ( $element->name == "if" ) 
            {
                return false;
            }

            return true;
        }

        return ( $element instanceof ezcTemplateLoopTstNode );
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        $last = sizeof( $this->children ) - 1;

        if ( !$element instanceof ezcTemplateConditionBodyTstNode )
        {
            $this->children[$last]->children[] = $element;
        }
        else
        {
            $this->children[] = $element;
        }
    }


    public function trimLine( ezcTemplateWhitespaceRemoval $removal )
    {
        if ( count( $this->children ) == 0 )
            return;

        foreach ( $this->children as $child )
        {
            if ( $child instanceof ezcTemplateConditionBodyTstNode )
            {
                if ( count( $child->children ) == 0 )
                {
                    continue;
                }

                // Tell the removal object to trim our first text child
                if ( $child->children[0] instanceof ezcTemplateTextTstNode )
                {
                    $removal->trimBlockLine( $this, $child->children[0] );
                }
                // Tell the removal object to trim text blocks after the current block
                // and after all sub-blocks.
                $removal->trimBlockLines( $this, $child->children );
            }

        }
    }


}
?>
