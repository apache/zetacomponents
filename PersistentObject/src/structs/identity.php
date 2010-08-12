<?php
/**
 * File containing the ezcPersistentIdentity struct.
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
 * Struct representing an object identity in ezcPersistentIdentityMap.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentity extends ezcBaseStruct
{
    /**
     * The object.
     * 
     * @var object
     */
    public $object;

    /**
     * Related objects of $object. 
     *
     * Structure:
     *
     * <code>
     * <?php
     * array(
     *     '<relatedClassName>' => ArrayObject(
     *         '<id1>' => ezcPersistentObject,
     *         '<id2>' => ezcPersistentObject,
     *         // ...
     *     ),
     *     '<anotherRelatedClassName>' => ArrayObject(
     *         '<idA>' => ezcPersistentObject,
     *         '<idB>' => ezcPersistentObject,
     *         // ...
     *     ),
     *     // ...
     * );
     * ?>
     * </code>
     * 
     * @var array(string=>ArrayObject(mixed=>ezcPersistentObject))
     */
    public $relatedObjects;

    /**
     * Named sets of related objects. 
     *
     * Structure:
     *
     * <code>
     * <?php
     * array(
     *     '<relatedClassName>' => ArrayObject(
     *         '<setName' => array(
     *             '<id1>' => ezcPersistentObject,
     *             '<id2>' => ezcPersistentObject,
     *             // ...
     *         ),
     *         '<anotherSetName' => ArrayObject(
     *             '<idA>' => ezcPersistentObject,
     *             '<idB>' => ezcPersistentObject,
     *             // ...
     *         ),
     *     ),
     *     // ...
     * );
     * ?>
     * </code>
     * 
     * @var array(string=>ArrayObject(mixed=>ezcPersistentObject))
     */
    public $namedRelatedObjectSets;

    /**
     * Stores all references to $object in other identities. 
     *
     * This attribute stores references to all $relatedObjects and
     * $namedRelatedObjectSets sets, the $object of this identity is referenced
     * in.
     * 
     * @var SplObjectStorage(ArrayObject)
     */
    public $references;

    /**
     * Creates a new object identity.
     *
     * Creates an identity struct for $object with relations to its
     * $relatedObjects and $namedRelatedObjectSets. The $references object is
     * used to keep track of places where the $object is referenced (related
     * object sets of other identities).
     * 
     * @param object $object 
     * @param array $relatedObjects 
     * @param array $namedRelatedObjectSets
     * @param SplObjectStorage $references
     */
    public function __construct(
        $object = null,
        array $relatedObjects = array(),
        array $namedRelatedObjectSets = array(),
        SplObjectStorage $references = null
    )
    {
        $this->object                 = $object;
        $this->relatedObjects         = $relatedObjects;
        $this->namedRelatedObjectSets = $namedRelatedObjectSets;
        $this->references             = (
            $references === null
                ? new SplObjectStorage()
                : $references
        );
    }
}

?>
