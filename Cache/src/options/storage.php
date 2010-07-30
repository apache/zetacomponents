<?php
/**
 * File containing the ezcCacheStorageOptions class.
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Option class for the ezcCacheStorage class.
 * Instances of this class store the options of ezcCacheStorage
 * implementations.
 *
 * @property int    $ttl       The time to live of cache entries.
 * @property string $extension The (file) extension to use for the storage items.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageOptions extends ezcBaseOptions
{
    /**
     * Constructs a new options object.
     *
     * It also sets the default values of the format property
     *
     * @param array(string=>mixed) $options The initial options to set.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If trying to assign a property which does not exist
     * @throws ezcBaseValueException
     *         If the value for the property is incorrect
     */
    public function __construct( $options = array() )
    {
        $this->properties['ttl'] = 86400;
        $this->properties['extension'] = '.cache';
        parent::__construct( $options );
    }

    /**
     * Sets an option.
     * This method is called when an option is set.
     * 
     * @param string $key  The option name.
     * @param mixed $value The option value.
     * @ignore
     */
    public function __set( $key, $value )
    {
        switch ( $key )
        {
            case "extension":
                if ( !is_string( $value ) || strlen( $value ) < 1 )
                {
                    throw new ezcBaseValueException( $key, $value, "string, size > 0" );
                }
                break;
            case "ttl":
                if ( !is_int( $value ) && $value !== false )
                {
                    throw new ezcBaseValueException( $key, $value, "int > 0 or false" );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $key );
        }
        $this->properties[$key] = $value;
    }
}


?>
