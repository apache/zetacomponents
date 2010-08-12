<?php
/**
 * File containing the ezcDebugStructure class.
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
 * @package Debug
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * The ezcDebugStructure is used internally by the debug system to store
 * debug messages.
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugStructure
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Holds the sub-elements of this structure.
     *
     * These elements cannot be a part of the property system because it is an
     * array.
     */
    public $elements = array();

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        $this->properties[$name] = $value;
    }

   /**
     * Returns the property $name.
     *
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        $value = $this->properties[$name];
        if ( is_array( $value ) )
        {
            return (array) $this->properties[$name];
        }
        return $this->properties[$name];
    }

    /**
     * Returns if the given property isset.
     * 
     * @param string $name 
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        return array_key_exists( $name, $this->properties );
    }

    /**
     * Generates string output of the debug messages.
     *
     * The output generated is each value listed in the form "'key' => 'value'".
     *
     * @return string
     */
    public function toString()
    {
        $str = "";
        foreach ( $this->properties as $key => $value )
        {
            $str .= "$key => $value\n";
        }

        return $str;
    }
}
?>
