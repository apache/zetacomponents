<?php
/**
 * File containing the ezcTemplateCustomBlockTstNode class
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
 * Custom block elements in parser trees.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCustomBlockTstNode extends ezcTemplateBlockTstNode
{
    /**
     * All parameters of the custom block as an associative array.
     * The key is the parameter name and the value is another element object.
     *
     * @var array
     */
    public $customParameters;

    /**
     * The definition block.
     * 
     * @var ezcTemplateCustomBlockDefinition
     */
    public $definition;

    /**
     * The named parameters.
     *
     * @var array
     */
    public $namedParameters = array();

    /**
     * Constructs a new custom block
     *
     * @param ezcTemplateSourceCode $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->customParameters = array();
    }
    
    /**
     * Returns the tree properties.
     *
     * @return array(string=>mixed)
     */
    public function getTreeProperties()
    {
        return array( 'name'             => $this->name,
                      'isClosingBlock'   => $this->isClosingBlock,
                      'isNestingBlock'   => $this->isNestingBlock,
                      'customParameters' => $this->customParameters,
                      'children'         => $this->children );
    }

    /**
     * Adds the element $parameter as a parameter of this custom block element.
     *
     * @param string $parameterName The name of the parameter.
     * @param ezcTemplateTstNode $parameter The element object to use as parameter
     */
    public function appendParameter( $parameterName, ezcTemplateTstNode $nameElement, ezcTemplateTstNode $parameter )
    {
        $this->customParameters[$parameterName] = array( $nameElement,
                                                         $parameter );
    }

    /**
     * Checks if the parameter named $parameterName is set in the block and the result.
     *
     * @param string $parameterName The name of the parameter.
     * @return bool
     */
    public function hasParameter( $parameterName )
    {
        return isset( $this->customParameters[$parameterName] );
    }
}
?>
