<?php
/**
 * File containing the ezcPersistentSession class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Default identity map used in ezcPersistentIdentitySession.
 *
 * An instance of this class is used in {@link ezcPersistentIdentitySession}
 * and performs the internal work of storing and retrieving object identities.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentBasicIdentityMap implements ezcPersistentIdentityMap
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
     * Sets the identity of $object.
     *
     * Records the identity for $object. If an identity is already recorded for
     * this object, it is silently replaced. The using object must take care to
     * check for already recorded identity itself.
     *
     * @param ezcPersistentObject $object 
     */
    public function setIdentity( $object )
    {
        $class = get_class( $object );
        $def   = $this->definitionManager->fetchDefinition( $class );
        $state = $object->getState();
        
        $this->setIdentityWithId(
            $object,
            $class,
            $state[$def->idProperty->propertyName]
        );
    }

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
    public function setIdentityWithId( $object, $class, $id )
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
     * Removes the identity identitfied by $class and $id from the map. 
     *
     * Removes the object identified by $class and $id from the map and deletes
     * all references of it. If the identity does not exist, the call is
     * silently ignored.
     * 
     * @param string $class 
     * @param mixed $id 
     */
    public function removeIdentity( $class, $id )
    {
        if ( isset( $this->identities[$class][$id] ) )
        {
            // First remove all references to this object
            foreach( $this->identities[$class][$id]->references as $refList )
            {
                $removeIds = array();
                // Needs iteration here, to determine key
                foreach ( $refList->getIterator() as $refId => $refItem )
                {
                    if ( $refItem === $this->identities[$class][$id]->object )
                    {
                        $removeIds[] = $refId;
                    }
                }
                foreach ( $removeIds as $removeId )
                {
                    unset( $refList[$removeId] );
                }
            }
            unset( $this->identities[$class][$id] );
        }
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
     * optionally $relationName), this set of related objects is silently
     * replaced..
     *
     * If $relatedObjects are to be added, for which no identity has been
     * recorded, yet, an identity is automatically recorded. If an identity
     * already exists, the identity is used instead of the submited object.
     * 
     * NOTE: Therefore the using object MUST call {@link getRelatedObjects()}
     * after this method was used.
     * 
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relatedClass 
     * @param string $relationName 
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     *
    */
    public function setRelatedObjects( $sourceObject, array $relatedObjects, $relatedClass, $relationName = null )
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
        
        return $this->setRelatedObjectsWithId(
            $srcClass,
            $srcId,
            $relatedObjects,
            $relatedClass,
            $relationName
        );
    }

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
     * @param string $sourceClass 
     * @param mixed $sourceId 
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $relatedClass 
     * @param string $relationName 
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     */
    public function setRelatedObjectsWithId( $sourceClass, $sourceId, array $relatedObjects, $relatedClass, $relationName = null )
    {
        $relDef = $this->definitionManager->fetchDefinition( $relatedClass );

        $relationStoreName = $relatedClass
            . ( $relationName !== null ? "__{$relationName}" : '' );

        // Remove references before replacing a set
        if ( isset( $this->identities[$sourceClass][$sourceId]->relatedObjects[$relationStoreName] ) )
        {
            $this->removeReferences( $this->identities[$sourceClass][$sourceId]->relatedObjects[$relationStoreName] );
        }

        $relStore = new ArrayObject();
        foreach ( $relatedObjects as $relObj )
        {
            if ( !( $relObj instanceof $relatedClass ) )
            {
                // Cleanup already set references before bailing out
                $this->removeReferences( $relStore );
                throw new ezcPersistentIdentityRelatedObjectsInconsistentException(
                    $sourceClass, $sourceId, $relatedClass, get_class( $relObj )
                );
            }

            $relState = $relObj->getState();
            $relId    = $relState[$relDef->idProperty->propertyName];

            // Check and replace identities
            if ( !isset( $this->identities[$relatedClass][$relId] ) )
            {
                $this->identities[$relatedClass][$relId] = new ezcPersistentIdentity(
                    $relObj
                );
            }
            else
            {
                $relObj = $this->identities[$relatedClass][$relId]->object;
            }

            $relStore[$relId] = $relObj;

            // Store reference
            $this->identities[$relatedClass][$relId]->references->attach( $relStore );
        }
        
        $this->identities[$sourceClass][$sourceId]->relatedObjects[$relationStoreName] = $relStore;
    }

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
     * recorded, yet, an identity is automatically recorded. If an identity
     * already exists, the identity is used instead of the submited object.
     * 
     * NOTE: Therefore the using object MUST call {@link getRelatedObjectSet()}
     * after this method was used.
     * 
     * @param ezcPersistentObject $sourceObject
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $setName 
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     *
    */
    public function setRelatedObjectSet( $sourceObject, array $relatedObjects, $setName )
    {
        $srcClass = get_class( $sourceObject );
        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        // Sanity checks

        if ( !isset( $this->identities[$srcClass][$srcId] ) )
        {
            throw new ezcPersistentIdentityMissingException(
                $srcClass,
                $srcId
            );
        }

        $this->setRelatedObjectSetWithId(
            $srcClass,
            $srcId,
            $relatedObjects,
            $setName
        );
    }

    /**
     * Stores a named set of $relatedObjects for the object of $sourceClass with $sourceId.
     *
     * Stores the given set of $relatedObjects with name $setName for
     * the object of $sourceClass with $sourceId.
     *
     * In case a set of related objects has already been recorded for
     * $sourceObject with $setName, this set is silently overwritten.
     * 
     * @param string $sourceClass 
     * @param mixed $sourceId 
     * @param array(ezcPersistentObject) $relatedObjects 
     * @param string $setName 
     *
     * @throws ezcPersistentIdentityRelatedObjectsInconsistentException
     *         if an object in $relatedObjects is not of $relatedClass.
     */
    public function setRelatedObjectSetWithId( $sourceClass, $sourceId, array $relatedObjects, $setName )
    {
        $identity = $this->identities[$sourceClass][$sourceId];

        // Remove references before replacing a set
        if ( isset( $identity->namedRelatedObjectSets[$setName] ) )
        {
            $this->removeReferences( $identity->namedRelatedObjectSets[$setName] );
        }

        $relDefs  = array();
        $relStore = new ArrayObject();

        foreach ( $relatedObjects as $relObj )
        {
            $relClass = get_class( $relObj );
            if ( !isset( $relDefs[$relClass] ) )
            {
                $relDefs[$relClass] = $this->definitionManager->fetchDefinition( $relClass );
            }

            $relState = $relObj->getState();
            $relId    = $relState[$relDefs[$relClass]->idProperty->propertyName];

            // Check and replace identities
            if ( !isset( $this->identities[$relClass][$relId] ) )
            {
                $this->identities[$relClass][$relId] = new ezcPersistentIdentity(
                    $relObj
                );
            }
            else
            {
                $relObj = $this->identities[$relClass][$relId]->object;
            }

            $relStore[$relId] = $relObj;

            // Store reference
            $this->identities[$relClass][$relId]->references->attach( $relStore );
        }
        
        $identity->namedRelatedObjectSets[$setName] = $relStore;
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
     * @param string $relationName
     */
    public function addRelatedObject( $sourceObject, $relatedObject, $relationName = null )
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
        if ( $relationName !== null && !isset( $srcDef->relations[$relClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException(
                $srcClass,
                $relClass,
                $relationName
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
        return $this->addRelatedObjectWithId(
            $srcClass,
            $srcId,
            $relClass,
            $relId,
            $relatedObject,
            $relationName
        );
    }

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
    public function addRelatedObjectWithId( $sourceClass, $sourceId, $relatedClass, $relatedId, $relatedObject, $relationName = null )
    {
        $relationStoreName = $relatedClass
            . ( $relationName !== null ? "__{$relationName}" : '' );

        if ( !isset( $this->identities[$sourceClass][$sourceId]->relatedObjects[$relationStoreName] ) )
        {
            // Ignore call, since related objects for $relatedClass have not been stored, yet
            return null;
        }

        if ( isset( $this->identities[$sourceClass][$sourceId]->relatedObjects[$relationStoreName][$relatedId] ) )
        {
            throw new ezcPersistentIdentityRelatedObjectsAlreadyExistException(
                $sourceClass, $sourceId, $relatedClass
            );
        }

        $this->identities[$sourceClass][$sourceId]->relatedObjects[$relationStoreName][$relatedId] = $relatedObject;

        // Store new reference
        $this->identities[$relatedClass][$relatedId]->references->attach(
            $this->identities[$sourceClass][$sourceId]->relatedObjects[$relationStoreName]
        );
        
        // Invalidate all named sets, since they might be inconsistent now
        $this->removeAllReferences( 
            $this->identities[$sourceClass][$sourceId]->namedRelatedObjectSets
        );
        $this->identities[$sourceClass][$sourceId]->namedRelatedObjectSets = array();

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
     * @param string $relationName
     */
    public function removeRelatedObject( $sourceObject, $relatedObject, $relationName = null )
    {
        $srcClass = get_class( $sourceObject );
        $relClass = get_class( $relatedObject );

        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $relDef   = $this->definitionManager->fetchDefinition( $relClass );

        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        $relState = $relatedObject->getState();
        $relId    = $relState[$relDef->idProperty->propertyName];

        $this->removeRelatedObjectWithId(
            $srcClass,
            $srcId,
            $relClass,
            $relId,
            $relationName
        );
    }

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
    public function removeRelatedObjectWithId( $sourceClass, $sourceId, $relatedClass, $relatedId, $relationName = null )
    {
        if ( !isset( $this->identities[$sourceClass][$sourceId] ) )
        {
            throw new ezcPersistentIdentityMissingException(
                $sourceClass,
                $sourceId
            );
        }
        if ( !isset( $this->identities[$relatedClass][$relatedId] ) )
        {
            // Ignore call
            return null;
        }

        $relationStoreName = $relatedClass
            . ( $relationName !== null ? "__{$relationName}" : '' );

        $sourceIdentity = $this->identities[$sourceClass][$sourceId];
        $relatedIdentity = $this->identities[$relatedClass][$relatedId];

        if ( isset( $sourceIdentity->relatedObjects[$relationStoreName] ) )
        {
            unset( $sourceIdentity->relatedObjects[$relationStoreName][$relatedId] );
            $relatedIdentity->references->detach( $sourceIdentity->relatedObjects[$relationStoreName] );
        }

        foreach ( $sourceIdentity->namedRelatedObjectSets as $setName => $rels )
        {
            if ( isset( $rels[$relatedId] ) && $rels[$relatedId] instanceof $relatedClass )
            {
                unset( $sourceIdentity->namedRelatedObjectSets[$setName][$relatedId] );
                $relatedIdentity->references->detach(
                    $sourceIdentity->namedRelatedObjectSets[$setName]
                );
            }
        }
    }

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
    public function getRelatedObjects( $sourceObject, $relatedClass, $relationName = null )
    {
        $srcClass = get_class( $sourceObject );
        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        if ( !isset( $srcDef->relations[$relatedClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException(
                $srcClass,
                $relatedClass,
                $relationName
            );
        }

        return $this->getRelatedObjectsWithId(
            $srcClass,
            $srcId,
            $relatedClass,
            $relationName
        );
    }

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
    public function getRelatedObjectsWithId( $sourceClass, $sourceId, $relatedClass, $relationName = null )
    {
        $relationStoreName = $relatedClass
            . ( $relationName !== null ? "__{$relationName}" : '' );

        // Sanity checks

        if ( !isset( $this->identities[$sourceClass][$sourceId] ) )
        {
            // No object identity
            return null;
        }

        $identity = $this->identities[$sourceClass][$sourceId];

        if ( isset( $identity->relatedObjects[$relationStoreName] ) )
        {
            // Return a real array here, not the ArrayObject stored
            return $identity->relatedObjects[$relationStoreName]->getArrayCopy();
        }
        return null;
    }

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
    public function getRelatedObjectSet( $sourceObject, $setName )
    {
        $srcClass = get_class( $sourceObject );
        $srcDef   = $this->definitionManager->fetchDefinition( $srcClass );
        $srcState = $sourceObject->getState();
        $srcId    = $srcState[$srcDef->idProperty->propertyName];

        return $this->getRelatedObjectSetWithId(
            $srcClass,
            $srcId,
            $setName
        );
    }

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
    public function getRelatedObjectSetWithId( $sourceClass, $sourceId, $setName )
    {
        if ( !isset( $this->identities[$sourceClass][$sourceId] ) )
        {
            return null;
        }
        $identity = $this->identities[$sourceClass][$sourceId];

        if ( isset( $identity->namedRelatedObjectSets[$setName] ) )
        {
            return $identity->namedRelatedObjectSets[$setName]->getArrayCopy();
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

    /**
     * Removes all references to all $sets from all objects in $sets.
     *
     * Removes all references to all object $sets from all objects contained in
     * each of the $sets.
     * 
     * @param array $sets 
     * @see removeReferences()
     */
    protected function removeAllReferences( array $sets )
    {
        foreach ( $sets as $set )
        {
            $this->removeReferences( $set );
        }
    }

    /**
     * Removes all references to $set from the objects in $set.
     *
     * Maintains the {ezcPersistentIdentity::$references} attribute by removing
     * all refereneces to $set from all objects identities contained in $set.
     *
     * @param ArrayObject $set 
     */
    protected function removeReferences( ArrayObject $set )
    {
        foreach ( $set as $obj )
        {
            $class = get_class( $obj );
            $def   = $this->definitionManager->fetchDefinition( $class );
            $state = $obj->getState();
            $id    = $state[$def->idProperty->propertyName];
            
            if ( $this->identities[$class][$id]->references->contains( $set ) )
            {
                $this->identities[$class][$id]->references->detach( $set );
            }
        }
    }
}

?>
