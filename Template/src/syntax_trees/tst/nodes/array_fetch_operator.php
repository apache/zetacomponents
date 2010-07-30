<?php
/**
 * File containing the ezcTemplateArrayFetchOperatorTstNode class
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
 * Fetching of array value in an expression.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArrayFetchOperatorTstNode extends ezcTemplateOperatorTstNode
{
    /**
     * The source operand element which the fetch is executed on.
     *
     * @var ezcTemplateTstNode
     */
    public $sourceOperand;

    /**
     * List of array keys to lookup expressed as parser elements.
     *
     * @var array(ezcTemplateTstNode)
     */
    public $arrayKeys;

    /**
     * Constructs a new ezcTemplateArrayFetchOperatorTstNode
     *
     * @param ezcTemplateSourceCode $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end,
                             11, 1, self::RIGHT_ASSOCIATIVE,
                             '[...]' );
        $this->sourceOperand = null;
        $this->arrayKeys = array();
    }

    /**
     * Returns the tree properties.
     *
     * @return array(string=>mixed) 
     */
    public function getTreeProperties()
    {
        return array( 'symbol'         => $this->symbol,
                      'sourceOperand'  => $this->sourceOperand,
                      'arrayKeys'      => $this->arrayKeys );
    }

    /**
     * Appends a parameter to this node.
     *
     * @param ezcTemplateTstNode $element
     * @return void
     */
    public function appendParameter( $element )
    {
        if ( $this->sourceOperand === null )
            $this->sourceOperand = $element;
        else
            $this->arrayKeys[] = $element;
        $this->parameters = array_merge( array( $this->sourceOperand ),
                                         $this->arrayKeys );
    }
}
?>
