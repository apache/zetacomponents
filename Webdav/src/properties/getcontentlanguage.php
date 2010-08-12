<?php
/**
 * File containing the ezcWebdavGetContentLanguageProperty class.
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
 * An object of this class represents the Webdav property <getcontentlanguage>.
 *
 * @property array(string) $languages
 *           The languages.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavGetContentLanguageProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavGetContentLanguageProperty.
     *
     * The given array must contain strings that represent language shortcuts.
     * 
     * @param array(string) $languages
     * @return void
     */
    public function __construct( array $languages = array() )
    {
        parent::__construct( 'getcontentlanguage' );

        $this->languages = $languages;
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
            case 'languages':
                if ( !is_array( $propertyValue ) )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'string' );
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
        return !count( $this->properties['languages'] );
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

        $this->properties['languages'] = array();
    }
}

?>
