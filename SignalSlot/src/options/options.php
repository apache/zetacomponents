<?php
/**
 * File containing the ezcConsoleStatusbarOptions class.
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
 * @package SignalSlot
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Struct class to store the options of the ezcConsoleOutput class.
 * This class stores the options for the {@link ezcSignalCollection} class.
 *
 * @property array(string) $signals
 *           The signals that the signal collection can throw. If this option
 *           is set using a non-existent signal is considered an exceptional state.
 *           If this option is not set or is set to null then using a non existent
 *           signal is simply ignored.
 *
 * @package SignalSlot
 * @version //autogen//
 */
class ezcSignalCollectionOptions extends ezcBaseOptions
{
    /**
     * Construct a new options object.
     * Options are constructed from an option array by default. The constructor
     * automatically passes the given options to the __set() method to set them
     * in the class.
     *
     * @param array(string=>mixed) $options The initial options to set.
     * @return void
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    public function __construct( array $options = array() )
    {
        $this->properties['signals'] = null;
        parent::__construct( $options );
    }

    /**
     * Option write access.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a desired property could not be found.
     * @throws ezcBaseSettingValueException
     *         If a desired property value is out of range.
     *
     * @param string $key Name of the property.
     * @param mixed $value  The value for the property.
     * @ignore
     */
    public function __set( $key, $value )
    {
        switch ( $key )
        {
            case "signals":
                if ( $value != null && !is_array( $value ) )
                {
                    throw new ezcBaseSettingValueException( $key, $value, 'null, array(string)' );
                }
                break;
            default:
                throw new ezcBaseSettingNotFoundException( $key );
        }
        $this->properties[$key] = $value;
    }
}

?>
