<?php
/**
 * File containing the ezcReflectionDocCommentParser interface.
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
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Defines an interface for documentation parsers.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
interface ezcReflectionDocCommentParser {

    /**
     * Initialize parsing of the given documentation fragment.
     * Results can be retrieved after completion by the getters provided.
     *
     * @param string $docComment
     * @return void
     */
    public function parse($docComment);

    /**
     * Return all found annotations with the given name.
     *
     * @param string $name
     * @return ezcReflectionAnnotation[]
     */
    public function getAnnotationsByName($name);

    /**
     * Retrieve all found annotations
     *
     * @return ezcReflectionAnnotation[]
     */
    public function getAnnotations();

    /**
     * Retrieve all param annotations
     *
     * @return ezcReflectionAnnotationParam[]
     */
    public function getParamAnnotations();

    /**
     * Retrieve all var annotations
     *
     * @return ezcReflectionAnnotationVar[]
     */
    public function getVarAnnotations();

    /**
     * Retrieve all return annotations
     *
     * @return ezcReflectionAnnotationReturn[]
     */
    public function getReturnAnnotations();

    /**
    * Checks whether an annotation was used in the parsed documentation fragment
    *
    * @param string $with name of used annotation
    * @return boolean
    */
    public function hasAnnotation($with);

    /**
     * Returns short description
     * @return string
     */
    public function getShortDescription();

    /**
     * Returns long description
     * @return string
     */
    public function getLongDescription();
}
?>