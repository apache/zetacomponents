<?php
/**
 * File containing the ezcCacheStorageFileApcArrayOptions class.
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
 * @package Cache
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Option class for APC array storage.
 *
 * @property int $permissions
 *               File access permissions specified as an octal integer, default 0644.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageFileApcArrayOptions extends ezcCacheStorageApcOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If $options contains a property not defined.
     * @throws ezcBaseValueException
     *         If $options contains a property with a value not allowed.
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['permissions'] = 0644;

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the property $name is not defined.
     * @throws ezcBaseValueException
     *         If $value is not correct for the property $name.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case "permissions":
                if ( !is_int( $value ) || $value < 0 || $value > 0777 )
                {
                    throw new ezcBaseValueException( $name, $value, "int > 0 and <= 0777" );
                }
                break;
            default:
                parent::__set( $name, $value );
                return;
        }
        $this->properties[$name] = $value;
    }
}
?>
