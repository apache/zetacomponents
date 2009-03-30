<?php
/**
 * File containing the ezcPersistentIdentityMap interface.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
 *
 * @TODO: After implementation of classes related to this interface is
 *        finished, it needs to be evaluated which type of method is used more
 *        often: Object ones or *WithId ones. The interface should be cleaned
 *        up on that basis.
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
     * Sets the identity from $object. 
     *
     * Records the identity for $object. If an identity is already recorded for
     * this object, it is silently replaced. The using object must take care to
     * check for already recorded identity itself.
     * 
     * @param ezcPersistentObject $object 
     * @param string $class 
     * @param mixed $id 
     */
    public function setIdentityWithId( $object, $class, $id );

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
     * If for any of the $relatedObjects no identity is recorded, yet, it will
     * be recorded. Otherwise, the object will be replaced by its existing
     * identity. Except if $replaceIdentities is set to true: In this case a
     * new identity will be recorded for every object in $relatedObjects.
     * 
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relatedClass 
     * @param string $relationName 
     * @param bool $replaceIdentities
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     *
     */
    public function setRelatedObjects( $sourceObject, array $relatedObjects, $relatedClass, $relationName = null, $replaceIdentities = false );

    /**
     * Stores a set of $relatedObjects for the object of $sourceClass with $sourceId.
     *
     * Stores the given set of $relatedObjects for the object of $sourceClass
     * with $sourceId. If $relationName is specified, $relatedObjects is not
     * stored as the main related object set, but as a named subset.
     *
     * In case a set of related objects has already been recorded for the
     * object of $sourceClass with $sourceId and the class of the objects in
     * $relatedObjects (and optionally $relationName), an exception is thrown.
     *
     * If for any of the $relatedObjects no identity is recorded, yet, it will
     * be recorded. Otherwise, the object will be replaced by its existing
     * identity. Except if $replaceIdentities is set to true: In this case a
     * new identity will be recorded for every object in $relatedObjects.
     *
     * @param string $sourceClass 
     * @param mixed $sourceId 
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relatedClass 
     * @param string $relationName 
     * @param bool $replaceIdentities
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     */
    public function setRelatedObjectsWithId( $sourceClass, $sourceId, array $relatedObjects, $relatedClass, $relationName = null, $replaceIdentities = false );

    /**
     * Stores a named set of $relatedObjects to $sourceObject.
     *
     * Stores the given set of $relatedObjects with name $setName for
     * $sourceObject.
     *
     * In case a set of related objects has already been recorded for
     * $sourceObject with $setName, this set is silently overwritten.
     *
     * If for any of the $relatedObjects no identity is recorded, yet, it will
     * be recorded. Otherwise, the object will be replaced by its existing
     * identity. Except if $replaceIdentities is set to true: In this case a
     * new identity will be recorded for every object in $relatedObjects.
     * 
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $setName 
     * @param bool $replaceIdentities
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     */
    public function setRelatedObjectSet( $sourceObject, array $relatedObjects, $setName, $replaceIdentities = false );

    /**
     * Stores a named set of $relatedObjects for the object of $sourceClass with $sourceId.
     *
     * Stores the given set of $relatedObjects with name $setName for
     * the object of $sourceClass with $sourceId.
     *
     * In case a set of related objects has already been recorded for
     * $sourceObject with $setName, this set is silently overwritten.
     *
     * If for any of the $relatedObjects no identity is recorded, yet, it will
     * be recorded. Otherwise, the object will be replaced by its existing
     * identity. Except if $replaceIdentities is set to true: In this case a
     * new identity will be recorded for every object in $relatedObjects.
     * 
     * @param string $sourceClass 
     * @param mixed $sourceId 
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $setName 
     * @param bool $replaceIdentities
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     */
    public function setRelatedObjectSetWithId( $sourceClass, $sourceId, array $relatedObjects, $setName, $replaceIdentities = false );

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
     * @param string $relationName
     */
    public function addRelatedObject( $sourceObject, $relatedObject, $relationName = null );

    /**
     * Appends a new $relatedObject to the relation set for the object of
     * $sourceClass with $sourceId.
     *
     * In case no relations have been recorded for the object of $class with
     * $id, yet, the call is ignored and related objects are newly fetched
     * whenever {@link getRelatedObjects()} is called.
     *
     * Note: All named sets for $relatedObject are automatically invalidated,
     * if this method is called, to avoid inconsistencies.
     *
     * @param string $sourceClass 
     * @param mixed $sourceId 
     * @param string $relatedClass 
     * @param mixed $relatedId 
     * @param ezcPersistentObject $relatedObject 
     * @param string $relationName 
     */
    public function addRelatedObjectWithId( $sourceClass, $sourceId, $relatedClass, $relatedId, $relatedObject, $relationName = null );

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
     * @param string $relationName
     */
    public function removeRelatedObject( $sourceObject, $relatedObject, $relationName = null );

    /**
     * Removes a the object of $relatedClass with $relatedId from the set of
     * related objects of the object of $sourceClass with $sourceId.
     *
     * Removes the object of $relatedClass with $relatedId from all recorded
     * relation sets for the object of $sourceClass with $sourceId. This also
     * includes named sets.
     *
     * Note: In contrast to {@link addRelatedObject()} a call to this method
     * does not invalidate all named related sets to $sourceObject.
     * 
     * @param string $sourceClass 
     * @param mixed $sourceId 
     * @param string $relatedClass 
     * @param mixed $relatedId 
     * @param string $relationName 
     */
    public function removeRelatedObjectWithId( $sourceClass, $sourceId, $relatedClass, $relatedId, $relationName = null );

    /**
     * Returns the set of related objects of $relatedClass for $sourceObject.
     *
     * Returns the set of related objects of $relatedClass for $sourceObject.
     * This might also be an empty set (empty array returned). In case no
     * related objects are recorded, yet, null is returned.
     * 
     * @param ezcPersistentObject $sourceObject 
     * @param string $relatedClass 
     * @param string $relationName
     */
    public function getRelatedObjects( $sourceObject, $relatedClass, $relationName = null );

    /**
     * Returns the set of related objects of $relatedClass for the object of
     * $sourceClass with $sourceId.
     *
     * Returns the set of related objects of $relatedClass for the object of
     * $sourceClass with $sourceId. This might also be an empty set (empty
     * array returned). In case no related objects are recorded, yet, null is
     * returned.
     * 
     * @param string $sourceClass
     * @param might $sourceId
     * @param string $relatedClass 
     * @param string $relationName
     */
    public function getRelatedObjectsWithId( $sourceClass, $sourceId, $relatedClass, $relationName = null );

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
     * Returns a named set of related objects for the object of $sourceClass
     * with $sourceId.
     *
     * Returns the named set of related objects for the object of $sourceClass
     * with $sourceId identified by $setName. This might also be an empty set
     * (empty array returned). In case no related objects with this name are
     * recorded, yet, null is returned.
     * 
     * @param string $sourceClass
     * @param might $sourceId
     * @param string $setName 
     */
    public function getRelatedObjectSetWithId( $sourceClass, $sourceId, $setName );

    /**
     * Resets the complete identity map.
     *
     * Removes all stored identities from the map.
     */
    public function reset();
}

?>
