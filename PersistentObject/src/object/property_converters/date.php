<?php
/**
 * File containing the ezcPersistentPropertyDateTimeConverter class.
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
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package PersistentObject
 */

/**
 * Property converter class for date/time values.
 *
 * An instance of this class can be used with {@link
 * ezcPersistentObjectProperty} in a {@link ezcPersistentObjectDefinition} to
 * indicate, that a database date/time value (represented by a unix timestamp
 * integer value) should be converted to a PHP DateTime object.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentPropertyDateTimeConverter implements ezcPersistentPropertyConverter
{
    /**
     * Converts unix timestamp to DateTime instance.
     *
     * This method is called right after a column value has been read from the
     * database, given the $databaseValue. The value returned by this method is
     * then assigned to the persistent objects property.
     *
     * The given integer value $databaseValue is handled as a date/time value
     * in unix timestamp representation. A corresponding DateTime object is
     * returned, representing the same date/time value.
     * 
     * @param int|null $databaseValue 
     * @return DateTime|null
     *
     * @throws ezcBaseValueException
     *         if the given $databaseValue is not an integer.
     */
    public function fromDatabase( $databaseValue )
    {
        if ( $databaseValue === null )
        {
            return null;
        }
        if ( !is_int( $databaseValue ) && !is_numeric( $databaseValue ) )
        {
            throw new ezcBaseValueException( 'databaseValue', $databaseValue, 'int' );
        }
        return new DateTime( '@' . (int) $databaseValue );
    }

    /**
     * Converts a DateTime object into a unix timestamp.
     *
     * This method is called right before a property value is written to the
     * database, given the $propertyValue. The value returned by this method is
     * then written back to the database.
     *
     * The method expects a DateTime object in $propertyValue and returns the
     * date/time value represented by it as an integer value in unix timestamp
     * format.
     * 
     * @param DateTime|null $propertyValue 
     * @return int|null
     *
     * @throws ezcBaseValueException
     *         if the given $propertyValue is not an instance of DateTime.
     */
    public function toDatabase( $propertyValue )
    {
        if ( $propertyValue === null )
        {
            return null;
        }
        if ( !( $propertyValue instanceof DateTime ) )
        {
            throw new ezcBaseValueException( 'propertyValue', $propertyValue, 'DateTime' );
        }
        return $propertyValue->format( 'U' );
    }

    /**
     * Method for de-serialization after var_export().
     *
     * This methid must be implemented to allow proper de-serialization of
     * converter objects, when they are exported using {@link var_export()}.
     * 
     * @param array $state 
     * @return ezcPersistentPropertyConverter
     */
    public static function __set_state( array $state )
    {
        return new ezcPersistentPropertyDateTimeConverter();
    }
}

?>
