<?php
/**
 * File containing the ezcPersistentObject interface
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcPersistentObject is an (optional) interface for classes that provide persistent objects.
 *
 * The PersistentObject component does not require a class to inherit from a
 * certain base class or implement a certain interface to be used with the
 * component. However, this interface can (optionally) be implemented by your
 * persistent classes, to ensure they provide all necessary methods.
 *
 * @package PersistentObject
 * @version //autogen//
 */
interface ezcPersistentObject
{
    /**
     * Returns the current state of an object.
     *
     * This method returns an array representing the current state of the
     * object. The array must contain a key for every attribute of the
     * object, assigned to the value of the attribute. The key must be the name
     * of the object property, not the database column name.
     * 
     * @return array(string=>mixed) The state of the object.
     */
    public function getState();

    /**
     * Sets the state of the object.
     *
     * This method sets the state of the object accoring to a given array,
     * which must conform to the standards defined at {@link getState()}. The
     * $state array is indexed by object property names (not database column
     * names) which have the desired property value assigned.
     * 
     * @param array $state The new state for the object.
     * @return void
     */
    public function setState( array $state );
}

?>
