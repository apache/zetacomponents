<?php
/**
 * File containing the ezcPersistentIdentityMap interface.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Identity map interface.
 *
 * An instance of a class implementing this interface is used in {@link
 * ezcPersistentIdentitySession} and performs the internal work of storing and
 * retrieving object identities.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
interface ezcPersistentIdentityMap
{
    /**
     * Sets the identity of $object.
     *
     * Records the identity for $object. If an identity is already recorded for
     * this object, it is silently replaced. The using object must take care to
     * check for already recorded identity itself.
     *
     * @param ezcPersistentObject $object 
     */
    public function setIdentity( $object );

    /**
     * Returns the identity of the object with $class and $id.
     *
     * Returns the object of $class with $id, if its identity has already been
     * recorded. Otherwise, null is returned.
     * 
     * @param string $class 
     * @param mixed $id 
     * @return object|null
     */
    public function getIdentity( $class, $id );

    /**
     * Removes the identity identitfied by $class and $id from the map. 
     *
     * Removes the object identified by $class and $id from the map and deletes
     * all references of it. If the identity does not exist, the call is
     * silently ignored.
     * 
     * @param string $class 
     * @param mixed $id 
     */
    public function removeIdentity( $class, $id );

    /**
     * Stores a set of $relatedObjects to $sourceObject.
     *
     * Stores the given set of $relatedObjects for $sourceObject. If
     * $relationName is specified, $relatedObjects is not stored as the main
     * related object set, but as a named subset.
     *
     * In case a set of related objects has already been recorded for
     * $sourceObject and the class of the objects in $relatedObjects (and
     * optionally $relationName), an exception is thrown.
     *
     * If $relatedObjects are to be added, for which no identity has been
     * recorded, yet, an exception is thrown.
     * 
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relatedClass 
     * @param string $relationName 
     *
     * @throws ezcPersistentIdentityRelatedObjectsAlreadyExistException
     *         if the set of related objects already exists.
     * @throws ezcPersistentIdentityMissingException
     *         if no identity exists for $sourceObject or an object in
     *         $relatedObjects.
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     *
    */
    public function setRelatedObjects( $sourceObject, array $relatedObjects, $relatedClass );

    /**
     * Stores a named set of $relatedObjects to $sourceObject.
     *
     * Stores the given set of $relatedObjects with name $setName for
     * $sourceObject.
     *
     * In case a set of related objects has already been recorded for
     * $sourceObject with $setName, this set is silently overwritten.
     *
     * If $relatedObjects are to be added, for which no identity has been
     * recorded, yet, an exception is thrown.
     * 
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $setName 
     *
     * @throws ezcPersistentIdentityRelatedObjectsAlreadyExistException
     *         if the set of related objects already exists.
     * @throws ezcPersistentIdentityMissingException
     *         if no identity exists for $sourceObject or an object in
     *         $relatedObjects.
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     *
    */
    public function setRelatedObjectSet( $sourceObject, array $relatedObjects, $setName );

    /**
     * Appends a new $relatedObject to the relation set of $sourceObject.
     *
     * In case no relations have been recorded for $object, yet, the call is
     * ignored and related objects are newly fetched whenever {@link
     * getRelatedObjects()} is called.
     *
     * Note: All named sets for $relatedObject are automatically invalidated,
     * if this method is called, to avoid inconsistencies.
     *
     * @param ezcPersistentObject $sourceObject 
     * @param ezcPersistentObject $relatedObject 
     */
    public function addRelatedObject( $sourceObject, $relatedObject );

    /**
     * Removes a $relatedObject from the relation set of $sourceObject.
     *
     * Removes the $relatedObject from all recorded relation sets for
     * $sourceObject. This also includes named sets.
     *
     * Note: In contrast to {@link addRelatedObject()} a call to this method
     * does not invalidate all named related sets to $sourceObject.
     * 
     * @param ezcPersistentObject $sourceObject 
     * @param ezcPersistentObject $relatedObject 
     */
    public function removeRelatedObject( $sourceObject, $relatedObject );

    /**
     * Returns the set of related objects of $relatedClass for $sourceObject.
     *
     * Returns the set of related objects of $relatedClass for $sourceObject.
     * This might also be an empty set (empty array returned). In case no
     * related objects are recorded, yet, null is returned.
     * 
     * @param ezcPersistentObject $sourceObject 
     * @param string $relatedClass 
     */
    public function getRelatedObjects( $sourceObject, $relatedClass );

    /**
     * Returns a named set of related objects for $sourceObject.
     *
     * Returns the named set of related objects for $sourceObject identified by
     * $setName. This might also be an empty set (empty array returned). In
     * case no related objects with this name are recorded, yet, null is
     * returned.
     * 
     * @param ezcPersistentObject $sourceObject 
     * @param string $setName 
     */
    public function getRelatedObjectSet( $sourceObject, $setName );

    /**
     * Resets the complete identity map.
     *
     * Removes all stored identities from the map.
     */
    public function reset();
}

?>
