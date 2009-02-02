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
     * @todo We need the related class here, too, to be able to store empty
     *       related sets.
     */
    public function addRelatedObjects( $sourceObject, array $relatedObjects, $relatedClass, $relationName = null )
    {
        $this->setRelatedObjects( $sourceObject, $relatedObjects, $relatedClass, $relationName );
    }

    /**
     * Sets a set of $relatedObjects to $sourceObject.
     *
     * Performs the actual store of $relatedObjects as required by {@link
     * addRelatedObjects()} and {@link replaceRelatedObjects()}. If
     * $failExisting is true, checks required by {@link addRelatedObjects()}
     * are performed. Otherwise, $relatedObjects will replace existing sets.
     * 
     * @param ezcPersistentObject $sourceObject 
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relatedClass 
     * @param string $relationName 
     * @param bool $failExisting 
     */
    protected function setRelatedObjects( $sourceObject, array $relatedObjects, $relatedClass, $relationName, $failExisting = true )
    {
        $srcClass = get_class( $sourceObject );
        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        // Sanity checks

        if ( !isset( $srcDef->relations[$relatedClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException(
                $srcClass,
                $relatedClass,
                $relationName
            );
        }

        if ( !isset( $this->identities[$srcClass][$srcId] ) )
        {
            throw new ezcPersistentIdentityMissingException(
                $srcClass,
                $srcId
            );
        }

        if ( $failExisting && (
             ( $relationName === null 
                 && isset( $this->identities[$srcClass][$srcId]->relatedObjects[$relatedClass] ) )
          || ( $relationName !== null
                 && isset( $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relatedClass][$relationName] ) )
        ) )
        {
            throw new ezcPersistentIdentityRelatedObjectsAlreadyExistException(
                $srcClass, $srcId, $relatedClass, $relationName
            );
        }

        $relDef = $this->definitionManager->fetchDefinition( $relatedClass );

        $relStore = array();
        foreach ( $relatedObjects as $relObj )
        {
            if ( !( $relObj instanceof $relatedClass ) )
            {
                throw new ezcPersistentIdentityRelatedObjectsInconsistentException(
                    $srcClass, $srcId, $relatedClass, get_class( $relObj )
                );
            }

            $relState = $relObj->getState();
            if ( !isset( $this->identities[$relatedClass][$relState[$relDef->idProperty->propertyName]] ) )
            {
                throw new ezcPersistentIdentityMissingException(
                    $relatedClass,
                    $relState[$relDef->idProperty->propertyName]
                );
            }

            $relStore[$relState[$relDef->idProperty->propertyName]] = $relObj;
        }
        
        if ( $relationName === null )
        {
            $this->identities[$srcClass][$srcId]->relatedObjects[$relatedClass] = $relStore;
        }
        else
        {
            $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relatedClass][$relationName] = $relStore;
        }
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
    public function replaceRelatedObjects( $sourceObject, array $relatedObjects, $relatedClass, $relationName = null )
    {
        $this->setRelatedObjects( $sourceObject, $relatedObjects, $relatedClass, $relationName, false );
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
        $srcClass = get_class( $sourceObject );
        $relClass = get_class( $relatedObject );

        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $relDef   = $this->definitionManager->fetchDefinition( $relClass );

        if ( !isset( $srcDef->relations[$relClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException(
                $srcClass,
                $relClass
            );
        }

        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        if ( !isset( $this->identities[$srcClass][$srcId] ) )
        {
            throw new ezcPersistentIdentityMissingException(
                $srcClass,
                $srcId
            );
        }

        $relState = $relatedObject->getState();
        $relId    = $relState[$relDef->idProperty->propertyName];

        if ( !isset( $this->identities[$relClass][$relId] ) )
        {
            throw new ezcPersistentIdentityMissingException(
                $relClass,
                $relId
            );
        }

        if ( !isset( $this->identities[$srcClass][$srcId]->relatedObjects[$relClass] ) )
        {
            // Ignore call, since related objects for $relClass have not been stored, yet
            return null;
        }

        if ( isset( $this->identities[$srcClass][$srcId]->relatedObjects[$relClass][$relId] ) )
        {
            throw new ezcPersistentIdentityRelatedObjectsAlreadyExistException(
                $srcClass, $srcId, $relClass
            );
        }

        $this->identities[$srcClass][$srcId]->relatedObjects[$relClass][$relId] = $relatedObject;
        
        // Invalidate all named sets for $relClass
        unset( $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relClass] );
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
        $srcClass = get_class( $sourceObject );
        $relClass = get_class( $relatedObject );

        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $relDef   = $this->definitionManager->fetchDefinition( $relClass );

        if ( !isset( $srcDef->relations[$relClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException(
                $srcClass,
                $relClass
            );
        }

        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        if ( !isset( $this->identities[$srcClass][$srcId] ) )
        {
            throw new ezcPersistentIdentityMissingException(
                $srcClass,
                $srcId
            );
        }

        $relState = $relatedObject->getState();
        $relId    = $relState[$relDef->idProperty->propertyName];

        if ( !isset( $this->identities[$relClass][$relId] ) )
        {
            // Ignore call
            return null;
        }

        if ( !isset( $this->identities[$srcClass][$srcId]->relatedObjects[$relClass] ) )
        {
            // Ignore call, since related objects for $relClass have not been stored, yet
            return null;
        }

        unset( $this->identities[$srcClass][$srcId]->relatedObjects[$relClass][$relId] );
        if ( isset( $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relClass] ) )
        {
            foreach ( $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relClass] as $setName => $rels )
            {
                unset( $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relClass][$setName][$relId] );
            }
        }
    }

    /**
     * Returns the set of related objects of $relatedClass for $sourceObject.
     *
     * Returns the set of related objects for $sourceObject identified by
     * $relatedClass and optionally $setName. This might also be an empty set
     * (empty array returned). In case no related objects are recorded, yet,
     * null is returned.
     * 
     * @param ezcPersistentObject $sourceObject 
     * @param string $relatedClass 
     * @param string $setName 
     */
    public function getRelatedObjects( $sourceObject, $relatedClass, $setName = null )
    {
        $srcClass = get_class( $sourceObject );
        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        // Sanity checks

        if ( !isset( $srcDef->relations[$relatedClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException(
                $srcClass,
                $relatedClass,
                $relationName
            );
        }

        if ( !isset( $this->identities[$srcClass][$srcId] ) )
        {
            return null;
        }

        if ( $setName !== null
             && isset( $this->identities[$srcClass][$srcId] )
             && isset( $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relatedClass][$setName] )
        )
        {
            return $this->identities[$srcClass][$srcId]->namedRelatedObjectSets[$relatedClass][$setName];
        }
        elseif ( $setName === null
                 && isset( $this->identities[$srcClass][$srcId] )
                 && isset( $this->identities[$srcClass][$srcId]->relatedObjects[$relatedClass] )
        )
        {
            return $this->identities[$srcClass][$srcId]->relatedObjects[$relatedClass];
        }
        return null;
    }

    /**
     * Resets the complete identity map.
     *
     * Removes all stored identities from the map.
     */
    public function reset()
    {
        $this->identities = array();
    }
}

?>
