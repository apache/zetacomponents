<?php
/**
 * File containing the ezcReflectionMixedType class.
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
 * Representation for the mixed type
 *
 * @package Reflection
 * @version //autogen//
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionMixedType extends ezcReflectionAbstractType {

    /**
     * @var ezcReflectionType[]
     */
    protected $types;
    
    /**
     * Returns a list of types
     * 
     * @return ezcReflectionType[]
     */
    public function getTypes()
    {
        if ( is_null( $this->types ) )
        {
            $typeName = parent::getTypeName();
            if ( $typeName == ezcReflectionTypeMapper::CANONICAL_NAME_NUMBER )
            {
                $this->types = array(
                    ezcReflection::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_INTEGER ),
                    ezcReflection::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_FLOAT ),
                );
            }
            elseif ( $typeName == ezcReflectionTypeMapper::CANONICAL_NAME_CALLBACK )
            {
                $this->types = array(
                    ezcReflection::getTypeByName( ezcReflectionTypeMapper::CANONICAL_NAME_STRING ),
                    ezcReflection::getTypeByName( 'mixed[]' ), // TODO Change this to 'array(integer=>object|string)'
                    ezcReflection::getTypeByName( 'Closure' ),
                );
            }
            else
            {
                $this->types = array();
            }
        }
        return $this->types;
    }
    
    /**
     * Return the name of this type as string
     *
     * @return string
     */
    public function getTypeName()
    {
        $typeName = parent::getTypeName();
        if (
            $typeName != ezcReflectionTypeMapper::CANONICAL_NAME_NUMBER
            and $typeName != ezcReflectionTypeMapper::CANONICAL_NAME_CALLBACK
        )
        {
            $types = $this->getTypes();
            if ( !empty( $types ) )
            {
                $typeName = '';
                foreach ( $types as $type )
                {
                    $typeName .= $type->getTypeName() . '|';
                }
                $typeName = substr( $typeName, 0, -1 ); // remove last '|'
            }
        }
        return $typeName;
    }

}
?>
