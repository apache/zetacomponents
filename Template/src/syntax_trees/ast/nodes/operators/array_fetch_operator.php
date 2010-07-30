<?php
/**
 * File containing the ezcTemplateArrayFetchOperatorAstNode class
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
 * Represents the PHP array access operator [..]
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArrayFetchOperatorAstNode extends ezcTemplateOperatorAstNode
{
    /**
     * Initialize operator code constructor with 2 parameters (binary).
     *
     * @param ezcTemplateAstNode $array
     * @param array(ezcTemplateAstNode) $fetches
     */
    public function __construct( ezcTemplateAstNode $array = null, Array $fetches = null )
    {
        parent::__construct( self::OPERATOR_TYPE_BINARY );
        // This is a special binary operator since it allows more than two parameters.
        // Each extra parameter will be considered an additional array lookup
        $this->maxParameterCount = false;

        if ( $array !== null )
        {
            $this->appendParameter( $array );
            if ( $fetches !== null )
            {
                foreach ( $fetches as $fetch )
                {
                    $this->appendParameter( $fetch );
                }
            }
        }
    }

    /**
     * Returns a text string representing the PHP operator.
     *
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '[..]';
    }

    /**
     * Checks and sets the type hint.
     *
     * @throws ezcTemplateTypeHintException when the type is wrong.
     * @return void
     */
    public function checkAndSetTypeHint()
    {
        if ( $this->parameters[0]->typeHint & self::TYPE_ARRAY && $this->parameters[1]->typeHint & self::TYPE_VALUE )
        {
            $this->typeHint = self::TYPE_VALUE | self::TYPE_ARRAY;
            return;
        }
        else
        {
            if ( $this->parameters[0]->typeHint == null || $this->parameters[1]->typeHint == null  )
            {
                if ( $this->parameters[0]->typeHint == null ) echo "FOUND: ".get_class( $this->parameters[0] );
                if ( $this->parameters[1]->typeHint == null ) echo "FOUND: ". get_class( $this->parameters[1] );

                $this->typeHint = self::TYPE_VALUE | self::TYPE_ARRAY;
                return;
            }
        }

        throw new ezcTemplateTypeHintException();
    }
 

    /**
     * Calls visitArrayFetchOperator() of the ezcTemplateBasicAstNodeVisitor interface.
     *
     * @param ezcTemplateAstNodeVisitor $visitor 
     *        The visitor object which can visit the current code element.
     * @return ezcTemplateAstNode
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitArrayFetchOperatorAstNode( $this );
    }
}
?>
