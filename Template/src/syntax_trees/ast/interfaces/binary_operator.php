<?php
/**
 * File containing the ezcTemplateBinaryOperatorAstNode class
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
 * This node represents a binary operator.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
abstract class ezcTemplateBinaryOperatorAstNode extends ezcTemplateOperatorAstNode
{
    /**
     * Constructs a new ezcTemplateBinaryOperatorAstNode
     *
     * @param ezcTemplateAstNode $parameter1
     * @param ezcTemplateAstNode $parameter2
     */
    public function __construct( $parameter1 = null, $parameter2 = null )
    {
        parent::__construct( self::OPERATOR_TYPE_BINARY );

        if ( $parameter1 !== null && $parameter2 !== null )
        {
            $this->appendParameter( $parameter1 );
            $this->appendParameter( $parameter2 );
        }
        elseif ( $parameter1 != null )
        {
            throw new ezcTemplateInternalException( "The binary operator expects zero or two parameters." );
        }
    }
}
?>
