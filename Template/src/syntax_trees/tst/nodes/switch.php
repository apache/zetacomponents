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
 * Control structure: switch.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateSwitchTstNode extends ezcTemplateBlockTstNode
{
    public $condition;

    public $defaultCaseFound = false;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->condition = null;
        $this->name = "switch";
    }

    public function getTreeProperties()
    {
        return array( 'name'      => $this->name,
                      'condition' => $this->condition,
                      'children'  => $this->children );
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        if ( $element instanceof ezcTemplateCaseTstNode  )
        {
            if ( $element->conditions === null )
            {
                if ( $this->defaultCaseFound )
                {
                    throw new ezcTemplateParserException( $element->source, $element->startCursor, $element->startCursor, ezcTemplateSourceToTstErrorMessages::MSG_DEFAULT_DUPLICATE );
                }

                $this->defaultCaseFound = true;
            }
            elseif ( $this->defaultCaseFound ) // Found a default case already..
            {
                throw new ezcTemplateParserException( $element->source, $element->startCursor, $element->startCursor, ezcTemplateSourceToTstErrorMessages::MSG_DEFAULT_LAST );
            }

            $this->children[] = $element;
            return true;


            // parent::handleElement( $element );
        }
        elseif ( $element instanceof ezcTemplateDocCommentTstNode )
        {
            parent::handleElement( $element );
        }
        else
        {
            if ( $element instanceof ezcTemplateTextBlockTstNode )
            {
                // Only spaces, newlines and tabs?
                if ( preg_match( "#^\s*$#", $element->text) != 0 )
                {
                    // It's okay, but ignore it.
                    return;
                }
                else
                {
                    $trimmedLength = strlen( ltrim( $element->text ) );
                    $element->startCursor->advance( strlen($element->text) - $trimmedLength );
                }
            }

            throw new ezcTemplateParserException( $element->source, $element->startCursor, $element->startCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CASE_STATEMENT );
        }
    }
}
?>
