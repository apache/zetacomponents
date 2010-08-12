<?php
/**
 * File containing the ezcTreeVisitable interface.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * Interface for visitable tree elements that can be visited
 * by ezcTreeVisitor implementations for processing using the
 * Visitor design pattern.
 *
 * All elements that will be part of the tree must
 * implement this interface.
 *
 * {@link http://en.wikipedia.org/wiki/Visitor_pattern Information on the Visitor pattern.}
 *
 * @package Tree
 * @version //autogentag//
 */
interface ezcTreeVisitable
{
    /**
     * Accepts the visitor.
     *
     * @param ezcTreeVisitor $visitor
     */
    public function accept( ezcTreeVisitor $visitor );
}
?>
