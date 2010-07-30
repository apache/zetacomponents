<?php
/**
 * File containing the ezcTemplateNoContext class
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
 */

/**
 * The ezcTemplateNoContext class doesn't change the output. This makes
 * testing more easy.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateNoContext implements ezcTemplateOutputContext
{
    /**
     *  Doesn't change the output, and returns exactly the same node.
     *
     *  @param ezcTemplateAstNode $node
     *  @return ezcTemplateAstNode
     */
    public function transformOutput( ezcTemplateAstNode $node )
    {
        return $node;
    }

    /**
     * Returns the unique identifier for the context handler.
     *
     * @return string
     */
    public function identifier()
    {
        return 'no_context';
    }
}

?>
