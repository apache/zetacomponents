<?php
/**
 * File containing the ezcPersistentRelationFindQuery class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Find query object to be used with ezcPersistentSessionIdentityDecorator.
 *
 * This special find query is returned by {@link
 * ezcPersistentSessionIdentityDecorator::createRelationFindQuery()}. It fulfills the
 * same purpose as its parent class, but can store the $relationSource object
 * and a $relationSetName in addition.
 *
 * An instance of this object can simply be used like an {@link
 * ezcPersistentFindQuery}.
 *
 * @property-read string $relationSetName
 *                Name of the named related object set to be stored in the
 *                identity map.
 * @property-read object $relationSource
 *                Source objects to which related objects should be found.
 *
 * @see ezcPersistentFindWithRelationsQuery
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentRelationFindQuery extends ezcPersistentFindQuery
{
    /**
     * Creates a new relation find query.
     *
     * Creates a new relation find query from the query object $q and the
     * given $className. Optionally, a $relationSetName and the $relationSource
     * object can be given. Providing these results in the creation of a named
     * related object set when objects are found using {@link
     * ezcPersistentSessionIdentityDecorator::find()}.
     * 
     * @param ezcQuerySelect $query
     * @param string $className
     * @param string $relationSetName
     * @param ezcPersistentObject $relationSource
     */
    public function __construct( ezcQuerySelect $query, $className, $relationSetName = null, $relationSource = null )
    {
        parent::__construct( $query, $className );
        $this->__set( 'relationSetName', $relationSetName );
        $this->__set( 'relationSource', $relationSource );
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
            case 'relationSource':
                if ( !is_object( $properyValue ) && $properyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $properyValue, 'Object or null' );
                }
                $this->properties[$propertyName] = $properyValue;
                return;
            case 'relationSetName':
                if ( !is_string( $properyValue ) && $properyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $properyValue, 'string or null' );
                }
                $this->properties[$propertyName] = $properyValue;
                return;
        }

        parent::__set( $propertyName, $properyValue );
    }
}

?>
