<?php
/**
 * File containing the ezcPersistentObjectProperties class.
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
 * @package PersistentObject
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcPersistentObjectProperties class.
 * 
 * @access private
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentObjectProperties extends ArrayObject
{
    /**
     * Stores the relation objects. 
     * 
     * @var array(ezcPersistentObjectProperty)
     */
    protected $properties;

    /**
     * Create a new instance.
     * Implicitly done in constructor of 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->properties = array();
        parent::__construct( $this->properties );
    }

    /**
     * See SPL interface ArrayAccess.
     * 
     * @param string $offset 
     * @param ezcPersistentObjectProperty $value 
     * @return void
     */
    public function offsetSet( $offset, $value )
    {
        if ( ( $value instanceof ezcPersistentObjectProperty ) === false )
        {
            throw new ezcBaseValueException( 'value', $value, 'ezcPersistentObjectProperty' );
        }
        if ( !is_string( $offset ) || strlen( $offset ) < 1 )
        {
            throw new ezcBaseValueException( 'offset', $offset, 'string, length > 0' );
        }
        parent::offsetSet( $offset, $value );
    }

    /**
     * See SPL class ArrayObject.
     * Performs additional value checks on the array.
     * 
     * @param array(ezcPersistentObjectProperty) $array New properties array.
     * @return void
     */
    public function exchangeArray( $array )
    {
        foreach ( $array as $offset => $value )
        {
            if ( ( $value instanceof ezcPersistentObjectProperty ) === false )
            {
                throw new ezcBaseValueException( 'value', $value, 'ezcPersistentObjectProperty' );
            }
            if ( !is_string( $offset ) || strlen( $offset ) < 1 )
            {
                throw new ezcBaseValueException( 'offset', $offset, 'string, length > 0' );
            }
        }
        parent::exchangeArray( $array );
    }

    /**
     * See SPL class ArrayObject.
     * Performs check if only 0 is used as a flag.
     * 
     * @param int $flags Must be 0.
     * @return void
     */
    public function setFlags( $flags )
    {
        if ( $flags !== 0 )
        {
            throw new ezcBaseValueException( 'flags', $flags, '0' );
        }
    }

    /**
     * Appending is not supported. 
     * 
     * @param mixed $value 
     * @return void
     */
    public function append( $value )
    {
        throw new Exception( 'Operation append is not supported by this object.' );
    }
    
    /**
     * Sets the state on deserialization.
     * 
     * @param array $state
     * @return ezcPersistentObjectProperties
     */
    public static function __set_state( array $state )
    {
        $properties = new ezcPersistentObjectProperties();
        if ( isset( $state['properties'] ) && count( $state ) === 1 )
        {
            $properties->exchangeArray( $state['properties'] );
        }
        else
        {
            // Old style exports
            $properties->exchangeArray( $state );
        }
        return $properties;
    }
}

?>
