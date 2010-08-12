<?php
/**
 * File containing the ezcWebdavSupportedLockProperty class.
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
 * An object of this class represents the Webdav property <supportedlock>.
 *
 * @property array(ezcWebdavSupportedLockPropertyLockentry) $lockEntry
 *           Lock information according to <lockentry> elements.
 *
 * @version //autogentag//
 * @package Webdav
 *
 * @access private
 */
class ezcWebdavSupportedLockProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavSourceProperty.
     *
     * The $lockEntry parameter must be an array of {@link
     * ezcWebdavSupportedLockPropertyLockentry} instances.
     * 
     * @param ArrayObject(ezcWebdavSupportedLockPropertyLockentry) $lockEntries
     * @return void
     */
    public function __construct( ArrayObject $lockEntries = null )
    {
        parent::__construct( 'supportedlock' );

        $this->lockEntries = ( $lockEntries === null ? new ArrayObject() : $lockEntries );
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
            case 'lockEntries':
                if ( !is_object( $propertyValue ) || !( $propertyValue instanceof ArrayObject ) )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'ArrayObject(ezcWebdavSupportedLockPropertyLockentry)' );
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
        return count( $this->properties['lockEntries'] ) === 0;
    }

    /**
     * Remove all contents from a property.
     *
     * Clear a property, so that it will be recognized as empty later.
     * 
     * @return void
     */
    public function clear()
    {
        $this->properties['lockEntries'] = new ArrayObject();
    }
}

?>
