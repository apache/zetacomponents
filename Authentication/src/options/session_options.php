<?php
/**
 * File containing the ezcAuthenticationSessionOptions class.
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
 * Class containing the options for the authentication session.
 *
 * Example of use:
 * <code>
 * // create an options object
 * $options = new ezcAuthenticationSessionOptions();
 * $options->validity = 3600;
 * $options->idleTimeout = 600;
 * $options->idKey = 'xxx';
 * $options->timestampKey = 'yyy';
 * $options->lastActivityTimestampKey = 'zzz';
 *
 * // use the options object when creating a new Session object
 * $filter = new ezcAuthenticationSession( $options );
 *
 * // alternatively, you can set the options to an existing object
 * $filter = new ezcAuthenticationSession();
 * $filter->setOptions( $options );
 * </code>
 *
 * @property int $validity
 *           The maximal amount of seconds the session is valid.
 * @property int $idleTimeout
 *           The amount of seconds the session can be idle.
 * @property string $idKey
 *           The key to use in $_SESSION to hold the user ID of the user who is
 *           logged in.
 * @property string $timestampKey
 *           The key to use in $_SESSION to hold the authentication timestamp.
 * @property string $lastActivityTimestampKey
 *           The key to use in $_SESSION to hold the last activity timestamp.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationSessionOptions extends ezcBaseOptions
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
        $this->validity = 1200; // seconds
        $this->idleTimeout = 600;
        $this->idKey = 'ezcAuth_id';
        $this->timestampKey = 'ezcAuth_timestamp';
        $this->lastActivityTimestampKey = 'ezcAuth_lastActivityTimestamp';

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
            case 'validity':
            case 'idleTimeout':
                if ( !is_numeric( $value ) || ( $value < 1 ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'int >= 1' );
                }
                $this->properties[$name] = $value;
                break;

            case 'idKey':
            case 'timestampKey':
            case 'lastActivityTimestampKey':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
}
?>
