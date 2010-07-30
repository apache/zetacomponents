<?php
/**
 * File containing the ezcPersistentObjectRelations class.
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcPersistentObjectRelations class.
 * 
 * @access private
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentObjectRelations extends ArrayObject
{
    /**
     * Stores the relation objects. 
     * 
     * @var array(ezcPersistentRelation)
     */
    private $relations;

    /**
     * Create a new instance.
     * Implicitly done in constructor of 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->relations = array();
        parent::__construct( $this->relations );
    }

    /**
     * See SPL interface ArrayAccess.
     * 
     * @param string $offset 
     * @param ezcPersistentRelation $value 
     * @return void
     */
    public function offsetSet( $offset, $value )
    {
        if ( !( $value instanceof ezcPersistentRelation ) && !( $value instanceof ezcPersistentRelationCollection ) )
        {
            throw new ezcBaseValueException( 'value', $value, 'ezcPersistentRelation or ezcPersistentRelationCollection' );
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
     * @param array(ezcPersistentRelation) $array New relations array.
     * @return void
     */
    public function exchangeArray( $array )
    {
        foreach ( $array as $offset => $value )
        {
            if ( !( $value instanceof ezcPersistentRelation ) && !( $value instanceof ezcPersistentRelationCollection ) )
            {
                throw new ezcBaseValueException( 'value', $value, 'ezcPersistentRelation or ezcPersistentRelationCollection' );
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
     * @return ezcPersistentObjectRelations
     */
    public static function __set_state( array $state )
    {
        $relations = new ezcPersistentObjectRelations();
        if ( isset( $state['columns'] ) && count( $state ) === 1 )
        {
            $relations->exchangeArray( $state['columns'] );
        }
        else
        {
            // Old exported objects.
            $relations->exchangeArray( $state );
        }
        return $relations;
    }
}

?>
