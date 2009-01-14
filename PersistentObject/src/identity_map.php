<?php
/**
 * File containing the ezcPersistentSession class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Identity map used in ezcPersistentIdentitySession.
 *
 * An instance of this class is used in {@link ezcPersistentIdentitySession}
 * and performs the internal work of storing and retrieving object identities.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityMap
{

    /**
     * Stores the identity of $object.
     *
     * Records the identity of the given $object. In case another identity of
     * the $object has already been stored, an exception is thrown.
     * 
     * @param object $object 
     * @throws ezcPersistentIdentityAlreadyStoredException
     *         if the identity of the given $object has already been stored.
     *
     * @TODO: We need the persistence definitions to determine the objects ID.
     */
    public function addIdentity( $object )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

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
    public function getIdentity( $class, $id )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

    /**
     * Replaces a recorded identity for $object.
     *
     * This method acts mostly like {@link addIdentity()} except that it
     * replaces a recorded identity with the given $object instead of throwung
     * an exception.
     * 
     * @param object $object 
     *
     * @TODO: We need the persistence definitions to determine the objects ID.
     */
    public function replaceIdentity( $object )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

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
     * @param object $sourceObject
     * @param array(object) $relatedObjects 
     * @param string $relationName 
     *
     * @TODO: We need the persistence definitions to determine the objects ID.
     */
    public function addRelatedObjects( $sourceObject, array $relatedObjects, $relationName = null )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

    /**
     * Replaces a set of $relatedObjects for $sourceObject.
     *
     * This method acts basically like {@addRelatedObjects()}, except that is
     * does not throw an exception, if the related objects set is already
     * recorded. Instead, the set is replaced by $relatedObjects.
     * 
     * @param object $sourceObject
     * @param array(object) $relatedObjects 
     * @param string $relationName 
     *
     * @TODO: We need the persistence definitions to determine the objects ID.
     */
    public function replaceRelatedObjects( $sourceObject, array $relatedObjects, $relationName = null )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

    /**
     * Appends a new $relatedObject to the relation set of $sourceObject.
     *
     * In case no relations have been recorded for $object, yet, the call is
     * ignored and related objects are newly fetched whenever {@link
     * getRelatedObjects()} is called.
     *
     * @param object $sourceObject 
     * @param object $relatedObject 
     *
     * @TODO: We need the persistence definitions to determine the objects ID.
     */
    public function addRelatedObject( $sourceObject, $relatedObject )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

    /**
     * Removes a $relatedObject from the relation set of $sourceObject.
     *
     * Removes the $relatedObject from all recorded relation sets for
     * $sourceObject.
     * 
     * @param object $sourceObject 
     * @param object $relatedObject 
     */
    public function removeRelatedObject( $sourceObject, $relatedObject )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

    /**
     * Returns the set of related objects of $class for $sourceObject.
     *
     * Returns the set of related objects for $sourceObject identified by
     * $class and optionally $relationName. This might also be an empty set
     * (empty array returned). In case no related objects are recorded, yet,
     * null is returned.
     * 
     * @param object $sourceObject 
     * @param string $class 
     * @param string $relationName 
     */
    public function getRelatedObjects( $sourceObject, $class, $relationName = null )
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }

    /**
     * Resets the complete identity map.
     *
     * Removes all stored identities from the map.
     */
    public function reset()
    {
        // @TODO: Implement.
        throw new RuntimeException( 'Not implemented, yet.' );
    }
}

?>
