<?php
/**
 * File containing the ezcTemplateCacheTstNode class
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
 * The cache node contains the possible caching information.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCacheTstNode extends ezcTemplateExpressionTstNode
{
    const TYPE_CACHE_TEMPLATE = 1;
    const TYPE_CACHE_BLOCK = 2;

    public $type = 0; 

    public $templateCache = false;

    public $isClosingBlock = false;

    public $keys = array();

    public $ttl = null;

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
        return array( 'templateCache' => $this->templateCache);
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
        // Must be TYPE_CACHE_TEMPLATE and in the root, not in a template block

        $p = $parentElement;

        if ( $this->type === self::TYPE_CACHE_TEMPLATE && !$p instanceof ezcTemplateProgramTstNode )
        {
            throw new ezcTemplateParserException( $this->source, $this->startCursor, $this->startCursor, 
                "{cache_template} cannot be declared inside a template block." );
        }
    }
}
?>
