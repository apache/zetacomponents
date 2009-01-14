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
     * @var array(string=>array(object))
     */
    public $relatedObjects;

    /**
     * Creates a new object identity.
     *
     * Creates an identity struct for $object with references to its
     * $relatedObjects.
     * 
     * @param object $object 
     * @param array $relatedObjects 
     */
    public function __construct( $object = null, array $relatedObjects = null )
    {
        $this->object         = $object;
        $this->relatedObjects = $relatedObjects;
    }
}

?>
