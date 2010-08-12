<?php
/**
 * File containing the ezcWebdavSourceProperty class.
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
 */
/**
 * An object of this class represents the Webdav property <source>.
 *
 * @property array(ezcWebdavSourcePropertyLink) $links
 *           Lock information according to <link> elements.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavSourceProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavSourceProperty.
     *
     * The given array must contain instances of {@link
     * ezcWebdavSourcePropertyLink}.
     * 
     * @param array(ezcWebdavSourcePropertyLink) $links
     * @return void
     */
    public function __construct( array $links = array() )
    {
        parent::__construct( 'source' );

        $this->links = $links;
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
            case 'links':
                if ( !is_array( $propertyValue ) )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'array(ezcWebdavSourcePropertyLink)' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Remove all contents from a property.
     *
     * Clear the property, so that it will be recognized as empty later.
     * 
     * @return void
     */
    public function hasNoContent()
    {
        return !count( $this->properties['links'] );
    }

    /**
     * Removes all contents from a property.
     *
     * Clear the property, so that it will be recognized as empty later.
     * 
     * @return void
     */
    public function clear()
    {
        parent::clear();

        $this->properties['links'] = array();
    }
}

?>
