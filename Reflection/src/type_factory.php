<?php
/**
 * File containing the ezcReflectionTypeFactoryImpl class.
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
 * Implements type mapping from string to ezcReflectionType
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionTypeFactoryImpl implements ezcReflectionTypeFactory {

    /**
     * @var ezcReflectionTypeMapper
     */
    protected $mapper;

    /**
     * Constructs a type factory implementation
     */
    public function __construct() {
        $this->mapper = ezcReflectionTypeMapper::getInstance();
    }

    /**
     * Creates a type object for given type name
     * @param string|ReflectionClass $typeName
     * @return ezcReflectionType
     * @todo ArrayAccess stuff, how to handle? has to be implemented
     */
    public function getType( $typeName )
    {
        if ( $typeName instanceof ReflectionClass )
        {
            return new ezcReflectionObjectType( $typeName );
        }
        $typeName = trim( $typeName );
        if ( empty( $typeName ) ) {
            return null;
        }
        elseif (
            $this->mapper->isScalarType( $typeName )
            or $this->mapper->isSpecialType( $typeName )
        )
        {
            return new ezcReflectionPrimitiveType( $typeName );
        }
        elseif ( $this->mapper->isArray( $typeName ) )
        {
            return new ezcReflectionArrayType( $typeName );
        }
        elseif ( $this->mapper->isMixed( $typeName ) )
        {
            return new ezcReflectionMixedType( $typeName );
        }
        else {
		    // otherwhise it has to be a class name
		    return new ezcReflectionObjectType( $typeName );
        }
    }
}

?>
