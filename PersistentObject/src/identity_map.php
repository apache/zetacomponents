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
     * Object identities.
     *
     * Structure:
     *
     * <code>
     * <?php
     * array(
     *     '<className>' => array(
     *         '<id1>' => ezcPersistentIdentity(),
     *         '<id2>' => ezcPersistentIdentity(),
     *         // ...
     *     ),
     *     '<anotherClassName>' => array(
     *         '<idA>' => ezcPersistentIdentity(),
     *         '<idB>' => ezcPersistentIdentity(),
     *         // ...
     *     ),
     *     // ...
     * );
     * ?>
     * </code>
     * 
     * @var array(string=>array(mixed=>ezcPersistentIdentity))
     */
    protected $identities = array();

    /**
     * Definition manager used by {@link ezcPersistentSession}.
     * 
     * @var ezcPersistentDefinitionManager
     */
    protected $definitionManager;

    /**
     * Creates a new identity map.
     *
     * Creates a new identity map, which makes use of the given
     * $definitionManager to determine object identities and relations.
     * 
     * @param ezcPersistentDefinitionManager $definitionManager 
     */
    public function __construct( ezcPersistentDefinitionManager $definitionManager )
    {
        $this->definitionManager = $definitionManager;
    }

    /**
     * Stores the identity of $object.
     *
     * Records the identity of the given $object. In case another identity of
     * the $object has already been stored, an exception is thrown.
     * 
     * @param ezcPersistentObject $object 
     * @throws ezcPersistentIdentityAlreadyExistsException
     *         if the identity of the given $object has already been stored.
     */
    public function addIdentity( $object )
    {
        $class = get_class( $object );
        $def   = $this->definitionManager->fetchDefinition( $class );
        $state = $object->getState();
        $id    = $state[$def->idProperty->propertyName];

        if ( isset( $this->identities[$class][$id] ) )
        {
            throw new ezcPersistentIdentityAlreadyExistsException(
                $class, $id
            );
        }
        
        $this->setIdentity( $object, $class, $id );
    }

    /**
     * Sets the identity of $object.
     *
     * $object is of the class $class and has $id.
     *
     * @see addIdentity()
     * @see replaceIdentity()
     * 
     * @param ezcPersistentObject $object 
     * @param string $class 
     * @param mixed $id 
     */
    protected function setIdentity( $object, $class, $id )
    {
        if ( !isset( $this->identities[$class] ) )
        {
            $this->identities[$class] = array();
        }

        $this->identities[$class][$id] = new ezcPersistentIdentity( $object );
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
        if ( !isset( $this->identities[$class] ) )
        {
            return null;
        }
        if ( !isset( $this->identities[$class][$id] ) )
        {
            return null;
        }
        return $this->identities[$class][$id]->object;
    }

    /**
     * Replaces a recorded identity for $object.
     *
     * This method acts mostly like {@link addIdentity()} except that it
     * replaces a recorded identity with the given $object instead of throwung
     * an exception.
     * 
     * @param ezcPersistentObject $object 
     */
    public function replaceIdentity( $object )
    {
        $class = get_class( $object );
        $def   = $this->definitionManager->fetchDefinition( $class );
        $state = $object->getState();
        $id    = $state[$def->idProperty->propertyName];

        $this->setIdentity( $object, $class, $id );
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
     * If $relatedObjects are to be added, for which no identity has been
     * recorded, yet, an exception is thrown.
     * 
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relationName 
     *
     * @throws ezcPersistentIdentityRelatedObjectsAlreadyExistException
     *         if the set of related objects already exists.
     * @throws ezcPersistentIdentityMissingException
     *         if no identity exists for an object in $relatedObjects.
     *
     * @todo We need the related class here, too, to be able to store empty
     *       related sets.
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
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relationName 
     *
     * @todo We need the related class here, too, to be able to store empty
     *       related sets.
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
     * Note: All named sets for $relatedObject are automatically invalidated,
     * if this method is called, to avoid inconsistencies.
     *
     * @param ezcPersistentObject $sourceObject 
     * @param ezcPersistentObject $relatedObject 
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
     * $sourceObject. This also includes named sets.
     *
     * Note: In contrast to {@link addRelatedObject()} a call to this method
     * does not invalidate all named related sets to $sourceObject.
     * 
     * @param ezcPersistentObject $sourceObject 
     * @param ezcPersistentObject $relatedObject 
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
     * @param ezcPersistentObject $sourceObject 
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
