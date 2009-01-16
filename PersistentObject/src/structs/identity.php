<?php
/**
 * File containing the ezcPersistentIdentity struct.
 *
 * @package PersistentObject
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
     *     '<relatedClassName>' => array(
     *         '<id1>' => ezcPersistentObject,
     *         '<id2>' => ezcPersistentObject,
     *         // ...
     *     ),
     *     '<anotherRelatedClassName>' => array(
     *         '<idA>' => ezcPersistentObject,
     *         '<idB>' => ezcPersistentObject,
     *         // ...
     *     ),
     *     // ...
     * );
     * ?>
     * </code>
     * 
     * @var array(string=>array(mixed=>ezcPersistentObject))
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
     *     '<relatedClassName>' => array(
     *         '<setName' => array(
     *             '<id1>' => ezcPersistentObject,
     *             '<id2>' => ezcPersistentObject,
     *             // ...
     *         ),
     *         '<anotherSetName' => array(
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
     * @var array(string=>array(mixed=>ezcPersistentObject))
     */
    public $namedRelatedObjectSets;

    /**
     * Creates a new object identity.
     *
     * Creates an identity struct for $object with references to its
     * $relatedObjects and $namedRelatedObjectSets.
     * 
     * @param object $object 
     * @param array $relatedObjects 
     * @param array $namedRelatedObjectSets
     */
    public function __construct(
        $object = null,
        array $relatedObjects = array(),
        array $namedRelatedObjectSets = array()
    )
    {
        $this->object                 = $object;
        $this->relatedObjects         = $relatedObjects;
        $this->namedRelatedObjectSets = $namedRelatedObjectSets;
    }
}

?>
