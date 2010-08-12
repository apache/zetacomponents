<?php
/**
 * File containing the abstract ezcWebdavLockIfHeaderListItem class.
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
 * @package Webdav
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 *
 * @access private
 */
/**
 * Item that occured in the If header of the request.
 *
 * The If header (described in RFC 2518) may consist of a list of items, which
 * contain ETags, lock tokens and may be negated. Each item is either assigned
 * to a certain resource or must be globally applied to all resources affected
 * by a request. In the first case, instances of this class occur in a {@link
 * ezcWebdavLockIfHeaderTaggedList}, in the latter case, a single instance
 * occurs in a {@link ezcWebdavLockIfHeaderNoTagList}
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockIfHeaderListItem
{
    /**
     * Array of lock tokens. 
     * 
     * @var array(string)
     */
    protected $lockTokens;

    /**
     * Array of ETags. 
     * 
     * @var array(string)
     */
    protected $eTags;

    /**
     * Creates a new list item that occurs in an If header list.
     *
     * An item may consist of an arbitrary number of $lockTokens and $eTags and
     * might be indicated to be $negated. If the item is $negated, no resource
     * affected by the current request may fit into the conditions defined by
     * $lockTokens and $eTags.
     * 
     * @param array(ezcWebdavIfHeaderCondition) $lockTokens 
     * @param array(ezcWebdavIfHeaderCondition) $eTags 
     */
    public function __construct( array $lockTokens = array(), array $eTags = array() )
    {
        $this->lockTokens = $lockTokens;
        $this->eTags      = $eTags;
    }
    
    /**
     * Property get access.
     *
     * Simply returns a given property.
     * 
     * @param string $propertyName The name of the property to get.
     * @return mixed The property value.
     *
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a write-only property.
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) )
        {
            return $this->$propertyName;
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Sets a property.
     *
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
     * @return void
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBaseValueException
     *         if the value to be assigned to a property is invalid.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a read-only property.
     */
    public function __set( $propertyName, $propertyValue )
    {
        if ( $this->__isset( $propertyName ) )
        {
            throw new ezcBasePropertyPermissionException(
                $propertyName,
                ezcBasePropertyPermissionException::READ
            );
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Returns if a property exists.
     *
     * Returns true if the property exists in the {@link $properties} array
     * (even if it is null) and false otherwise. 
     *
     * @param string $propertyName Option name to check for.
     * @return void
     * @ignore
     */
    public function __isset( $propertyName )
    {
        switch ( $propertyName )
        {
            case 'lockTokens':
            case 'eTags':
                return true;
        }
        return false;
    }
}

?>
