<?php
/**
 * File containing the ezcPersistentIdentityRelatedObjectsAlreadyExistException class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if the same set of related objects is added twice to the identity map.
 *
 * {@link ezcPersistentIdentityMap::addRelatedObjects()} will throw this
 * exception, if the same set of related objects is added twice.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityRelatedObjectsAlreadyExistException extends ezcPersistentObjectException
{

    /**
     * Creates a new ezcPersistentIdentityRelatedObjectsAlreadyExistException.
     *
     * Creates a new ezcPersistentIdentityRelatedObjectsAlreadyExistException
     * for the object of $class with ID $id and the related objects of class
     * $relatedClass, with optional set name $relationName.
     *
     * @param string $class
     * @param mixed $id
     * @param string $relatedClass
     * @param string $relationName
     */
    public function __construct( $class, $id, $relatedClass, $relationName = null )
    {
        parent::__construct(
            "Related objects of {$relatedClass}"
            . ( $relationName !== null ? " with set name $relationName" : '' )
            . " already exist in the identity map."
        );
    }
}
?>
