<?php
/**
 * File containing the ezcReflectionPrimitiveType class.
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
 * Representation for all primitive types like string, integer, float
 * and boolean
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionPrimitiveType extends ezcReflectionAbstractType {

    /**
     * @return boolean
     */
    public function isPrimitive()
    {
        return true;
    }

    /**
     * Returns whether this type is one of integer, float, string, or boolean.
     * 
     * Types array, object, resource, NULL, mixed, number, and callback are not
     * scalar.
     * 
     * @return boolean
     */
    function isScalarType()
    {
        if ( in_array(
            $this->getTypeName(),
            array(
                ezcReflectionTypeMapper::CANONICAL_NAME_BOOLEAN,
                ezcReflectionTypeMapper::CANONICAL_NAME_INTEGER,
                ezcReflectionTypeMapper::CANONICAL_NAME_FLOAT,
                ezcReflectionTypeMapper::CANONICAL_NAME_STRING
            )
        ))
        {
            return true;
        }
        return false;
    }

}