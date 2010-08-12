<?php
/**
 * File containing the ezcWebdavSupportedLockPropertyLockentry class.
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
 * Objects of this class are used in the ezcWebdavSupportedLockProperty class.
 *
 * @property int $lockType
 *           Constant indicating read or write lock.
 * @property int $lockScope
 *           Constant indicating exclusive or shared lock.
 *
 * @version //autogentag//
 * @package Webdav
 *
 * @access private
 */
class ezcWebdavSupportedLockPropertyLockentry extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavSupportedLockPropertyLockentry.
     *
     * The given $lockScope and $lockType indicate a combination of lock
     * supported by the server.
     * 
     * @param int $lockType  Lock type (constant TYPE_*).
     * @param int $lockScope Lock scope (constant SCOPE_*).
     * @return void
     */
    public function __construct( $lockType = ezcWebdavLockRequest::TYPE_READ, $lockScope = ezcWebdavLockRequest::SCOPE_SHARED )
    {
        parent::__construct( 'lockentry' );

        $this->lockType  = $lockType;
        $this->lockScope = $lockScope;
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
        switch ( $propertyName )
        {
            case 'lockType':
                if ( $propertyValue !== ezcWebdavLockRequest::TYPE_READ && $propertyValue !== ezcWebdavLockRequest::TYPE_WRITE )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'ezcWebdavLockRequest::TYPE_*' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            case 'lockScope':
                if ( $propertyValue !== ezcWebdavLockRequest::SCOPE_SHARED && $propertyValue !== ezcWebdavLockRequest::SCOPE_EXCLUSIVE )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'ezcWebdavLockRequest::SCOPE_*' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Returns if property has no content.
     *
     * Returns true, if the property has no content stored.
     * 
     * @return bool
     */
    public function hasNoContent()
    {
        return false;
    }

    /**
     * Removes all contents from a property.
     *
     * Clears the property, so that it will be recognized as empty later.
     * 
     * @return void
     */
    public function clear()
    {
        parent::clear();

        $this->properties['lockType']  = ezcWebdavLockRequest::TYPE_READ;
        $this->properties['lockScope'] = ezcWebdavLockRequest::SCOPE_SHARED;
    }
}

?>
