<?php
/**
 * File containing the ezcPersistentPropertyConverter class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package PersistentObject
 */

/**
 * Interface that must be implemented by property converter classes.
 *
 * This is the base interface that needs to be implemented by property
 * converter classes. A property converter object can be assigned to a {@link
 * ezcPersistentObjectProperty} instance, to enable automatic manipulation of
 * database values.
 *
 * After a value has been loaded from the database, the {@link fromDatabase()}
 * method will be called, receiving this value, and it's return value will be
 * used in the persistent objects property instead of the raw database value.
 * Right before storing a persistent object back to the database, the {@link
 * toDatabase()} method will be called, receiving the current property value,
 * and the return value of this method will be stored into the database.
 *
 * The same property converter object might be assigend to several {@link
 * ezcPersistentObjectProperty} instances to reduce the number of needed
 * objects.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
interface ezcPersistentPropertyConverter
{
    /**
     * Converts the database value given to the property value.
     *
     * This method is called right after a column value has been read from the
     * database, given the $databaseValue. The value returned by this method is
     * then assigned to the persistent objects property.
     *
     * For all implementations it should be made sure, that null is accepted
     * and handled correctly here, to indicate that the database field
     * contained a null value.
     * 
     * @param mixed $databaseValue Column value.
     * @return mixed Property value.
     */
    public function fromDatabase( $databaseValue );

    /**
     * Converts the object value given back to the database value.
     *
     * This method is called right before a property value is written to the
     * database, given the $propertyValue. The value returned by this method is
     * then written back to the database.
     *
     * Cases where fields may be left empty (null) should always be considered
     * in this method, The default way to handle a null value should be to
     * return null again, except if excplicitly desired differently.
     * 
     * @param mixed $propertyValue Property value.
     * @return mixed Column value.
     */
    public function toDatabase( $propertyValue );

    /**
     * Method for de-serialization after var_export().
     *
     * This methid must be implemented to allow proper de-serialization of
     * converter objects, when they are exported using {@link var_export()}.
     * 
     * @param array $state 
     * @return ezcPersistentPropertyConverter
     */
    public static function __set_state( array $state );

}

?>
