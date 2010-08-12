<?php
/**
 * File containing the ezcWebdavLockPluginOptions class.
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
 * Option class for the Webdav lock plugin.
 *
 * You can use an object of this class, to set options for the lock plugin in
 * {@link ezcWebdavLockPluginConfiguration}.
 *
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavLockPluginOptions extends ezcBaseOptions
{
    /**
     * Construct a new options object.
     * Options are constructed from an option array by default. The constructor
     * automatically passes the given options to the __set() method to set them 
     * in the class.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If trying to access a non existent property.
     * @throws ezcBaseValueException
     *         If the value for a property is out of range.
     * @param array(string=>mixed) $options The initial options to set.
     */
    public function __construct( array $options = array() )
    {
        $this->properties['lockTimeout']         = 900;
        $this->properties['backendLockTimeout']  = 10000000;
        $this->properties['backendLockWaitTime'] = 10000;
        parent::__construct( $options );
    }

    /**
     * Sets an option.
     * This method is called when an option is set.
     * 
     * @param string $propertyName  The name of the option to set.
     * @param mixed $propertyValue The option value.
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
            case 'lockTimeout':
                if ( !is_int( $propertyValue ) || $propertyValue < 1 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int > 0' );
                }
                break;
            case 'backendLockTimeout':
                if ( !is_int( $propertyValue ) || $propertyValue < 1 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int > 0' );
                }
                break;
            case 'backendLockWaitTime':
                if ( !is_int( $propertyValue ) || $propertyValue < 1 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'int > 0' );
                }
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }

        $this->properties[$propertyName] = $propertyValue;
    }
}

?>
