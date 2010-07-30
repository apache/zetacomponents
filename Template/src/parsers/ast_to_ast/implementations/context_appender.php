<?php
/**
 * File containing the ezcTemplateAstToAstContextAppender
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
 * This class adds 'context' information to the AST tree. 
 * For example, the output nodes are escaped.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateAstToAstContextAppender extends ezcTemplateAstWalker
{
    /**
     * The context specified in the ezcTemplateConfiguration.
     *
     * @var ezcTemplateOutputContext
     */
    private $context;

    /**
     * Constructs a new  ezcTemplateAstToAstContextAppender
     *
     * @param ezcTemplateOutputContext $context
     */ 
    public function __construct( ezcTemplateOutputContext $context )
    {
        $this->context = $context;
    }

    /**
     * Empty destructor
     */
    public function __destruct()
    {
    }

    /**
     * Returns a contextized, usually escaped, output node.
     *
     * @param ezcTemplateOutputAstNode $type
     * @return ezcTemplateOutputAstNode
     */
    public function visitOutputAstNode( ezcTemplateOutputAstNode $type )
    {
        parent::visitOutputAstNode( $type );

        if ( $type->isRaw )
        {
            return $type;
        }
        return $this->context->transformOutput( $type->expression );
    }
}
?>
