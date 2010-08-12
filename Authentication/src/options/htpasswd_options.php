<?php
/**
 * File containing the ezcAuthenticationHtpasswdOptions class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Class containing the options for the htpasswd authentication filter.
 *
 * Example of use:
 * <code>
 * // create an options object
 * $options = new ezcAuthenticationHtpasswdOptions();
 * $options->plain = true;
 *
 * // use the options object when creating a new htpasswd filter
 * $filter = new ezcAuthenticationHtpasswdFilter( '/etc/htpasswd', $options );
 *
 * // alternatively, you can set the options to an existing filter
 * $filter = new ezcAuthenticationHtpasswdFilter( '/etc/htpasswd' );
 * $filter->setOptions( $options );
 * </code>
 *
 * @property bool $plain
 *           Specifies if the password is passed to the filter in plain
 *           text or encrypted. The encryption will be autodetected by the
 *           filter from the password stored in the htpasswd file.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationHtpasswdOptions extends ezcAuthenticationFilterOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options Options for this class
     */
    public function __construct( array $options = array() )
    {
        $this->plain = false;

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name The name of the property to set
     * @param mixed $value The new value of the property
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'plain':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}
?>
