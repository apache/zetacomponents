<?php
/**
 * File containing the ezcWebdavServerOptions class.
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Options class for ezcWebdavServer.
 *
 * These options are used in the {@link ezcWebdavServer} instance.
 *
 * @property string $realm
 *           The realm that is used in WWW-Authorization headers. The default
 *           is "eZ Components WebDAV".
 *
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavServerOptions extends ezcBaseOptions
{
    /**
     * Constructs a new options objet with the given $options;
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['realm'] = 'eZ Components WebDAV';

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @return void
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'realm':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
        $this->properties[$name] = $value;
    }
}

?>
