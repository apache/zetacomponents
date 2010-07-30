<?php
/**
 * File containing the ezcPersistentFindQuery class.
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
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Find query object to be used with ezcPersistentSession.
 *
 * An instance of this class is returned by {@link
 * ezcPersistentSession->createFindQuery()} since PersistentObject 1.6, instead
 * of a pure {@link ezcQuerySelect} object. This class deals as a decorator for
 * {@link ezcQuerySelect} and offers the very same API. In addition, it allows
 * PersistentObject to store and determine the class for objects to fetch from
 * the query object. This deprecates the second parameter to {@link
 * ezcPersistentSession->find()}.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentFindQuery
{
    /**
     * Properties. 
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Creates a new persistent find query.
     *
     * Creates a new persistent find query from the query object $q and the
     * given $className.
     * 
     * @param ezcQuerySelect $query
     * @param string $className
     */
    public function __construct( ezcQuerySelect $query, $className )
    {
        if ( !is_string( $className ) || $className === '' )
        {
            throw new ezcBaseValueException( 'className', $className, 'string, length > 0' );
        }

        $this->properties = array(
            'className' => $className,
            'query'     => $query,
        );
    }

    /**
     * Delegate to inner $query object.
     *
     * Delegates calls to unknown methods to $query property.
     * 
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     */
    public function __call( $methodName, $arguments )
    {
        $res = call_user_func_array(
            array(
                $this->properties['query'],
                $methodName
            ),
            $arguments
        );

        if ( $res === $this->properties['query'] )
        {
            // Fluent interface
            return $this;
        }
        return $res;
    }

    /**
     * Property get access.
     * 
     * @param string $propertyName 
     * @return mixed
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the desired property could not be found.
     */
    public function __get( $propertyName )
    {
        if ( array_key_exists( $propertyName, $this->properties ) )
        {
            return $this->properties[$propertyName];
        }

        if ( !property_exists( $this->properties['query'], $propertyName ) )
        {
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        return $this->properties['query']->$propertyName;
    }

    /**
     * Property set access.
     * 
     * @param string $propertyName 
     * @param mixed $properyValue
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the desired property could not be found.
     * @throws ezcBaseValueException
     *         if $properyValue is not valid for $propertyName.
     */
    public function __set( $propertyName, $properyValue )
    {
        switch ( $propertyName )
        {
            case 'className':
            case 'query':
                throw new ezcBasePropertyPermissionException(
                    $propertyName,
                    ezcBasePropertyPermissionException::READ
                );
        }

        if ( !property_exists( $this->properties['query'], $propertyName ) )
        {
            throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties['query']->$propertyName = $properyValue;
    }

    /**
     * Property isset access.
     * 
     * @param string $propertyName 
     * @return bool
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return (
            array_key_exists( $propertyName, $this->properties )
            || property_exists( $this->properties['query'], $propertyName )
        );
    }
}

?>
