<?php
/**
 * File containing the ezcReflectionType interface.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Interface for type objects representing a type/class
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
interface ezcReflectionType {

    /**
     * @return boolean
     */
    public function isArray();

    /**
     * @return boolean
     */
    public function isObject();

    /**
     * @return boolean
     */
    public function isPrimitive();

    /**
     * @return boolean
     */
    public function isMap();

    /**
     * Return the name of this type as string
     *
     * @return string
     */
    public function getTypeName();

    /**
     * Returns whether this type is one of integer, float, string, or boolean.
     * 
     * Types array, object, resource, NULL, mixed, number, and callback are not
     * scalar.
     * 
     * @return boolean
     */
    public function isScalarType();

    /**
     * Returns the name to be used in a xml schema for this type.
     *
     * @return string
     */
    public function getXmlName();

    /**
     * @param  DOMDocument $dom
     * @return DOMElement
     */
    public function getXmlSchema(DOMDocument $dom);

        /**
     * Returns a string representation.
     *
     * @return String Type name
     */
    public function __toString();

}
?>
