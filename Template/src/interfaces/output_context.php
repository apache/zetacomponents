<?php
/**
 * File containing the ezcTemplateOutputContext class
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
 * Controls output handling in the template engine.
 *
 * The template engine will use the various methods in an output context object
 * to control how the end result is.
 *
 * The compiler will use the transformOutput() method when generating PHP
 * structures for output.
 *
 * @package Template
 * @version //autogen//
 */

interface ezcTemplateOutputContext
{
    /**
     * Transforms an expressions so it can be displayed in the current output context
     * correctly.
     *
     * @param ezcTemplateAstNode $node
     * @return ezcTemplateAstNode The new AST node which should replace $node.
     */
    public function transformOutput( ezcTemplateAstNode $node );

    /**
     * Returns the unique identifier for the context handler. This is used to
     * uniquely identify the handler, e.g. it is included in the path of
     * compiled files.
     *
     * @return string
     */
    public function identifier();

}
?>
