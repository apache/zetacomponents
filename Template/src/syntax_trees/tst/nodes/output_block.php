<?php
/**
 * File containing the ezcTemplateOutputBlockTstNode class
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
 * Block element containing an output expression.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateOutputBlockTstNode extends ezcTemplateBlockTstNode
{
    /** 
     *  Should this node processed raw? 
     *  The ContextAppender will not append a context for this node.
     */
    public $isRaw;

    /**
     * The bracket start character.
     * @var string
     */
    public $startBracket;

    /**
     * The bracket end character.
     * @var string
     */
    public $endBracket;

    /**
     * The node starting the output expression.
     *
     * @var ezcTemplateExpressionTstNode
     */
//    public $element; // removed, not needed

    /**
     * The root of the parsed output expression.
     */
    public $expressionRoot;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
//        $this->element = null; // removed, not needed
        $this->startBracket = '{';
        $this->endBracket = '}';
        $this->expressionRoot = null;

        $this->isNestingBlock = false;
    }

    public function getTreeProperties()
    {
        return array( 'startBracket'   => $this->startBracket,
                      'endBracket'     => $this->endBracket,
                      'expressionRoot' => $this->expressionRoot,
                      'isRaw'          => $this->isRaw );
    }

    /**
     * Returns true since output expression block elements can always be children of blocks.
     *
     * @return true
     */
     /*
    public function canBeChildOf( ezcTemplateBlockTstNode $block )
    {
        // Output expression block elements can always be child of blocks
        return true;
    }
    */

    /**
     * {@inheritdoc}
     * Returns the column of the starting cursor.
     */
    public function minimumWhitespaceColumn()
    {
        return $this->startCursor->column;
    }
}
?>
