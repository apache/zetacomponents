<?php
/**
 * File containing the ezcPersistentIdentitySession class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcPersistentIdentitySession is an identity map wrapper around ezcPersistentSession.
 *
 * @property-read ezcPersistentIdentityMap $identityMap
 *                Identity map used by this session. You should usually not
 *                access this property directly.
 * @property ezcPersistentIdentitySessionOptions $options
 *                Options to influence the behaviour of the session.
 *
 * @package PersistentObject
 * @version //autogen//
 * @mainclass
 *
 * @TODO: Should this extend ezcPersistentSession to suite instanceof checks?
 */
class ezcPersistentIdentitySession
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * The persistent session this object wraps.
     * 
     * @var ezcPersistentSession
     */
    protected $session;

    /**
     * Query creator for relation pre-fetching. 
     * 
     * @var ezcPersistentIdentityRelationQueryCreator
     */
    protected $queryCreator;

    /**
     * Related object extractor used for pre-fetching. 
     * 
     * @var ezcPersistentIdentityRelationObjectExtractor
     */
    protected $objectExtractor;

    /**
     * Creates a new identity session.
     *
     * This identity session will use $session to issue the actual database
     * operations and store object identities in $identityMap. $options
     * influence the behavior of the identity session, like setting the
     * $refetch option to force reloading of objects.
     * 
     * @param ezcPersistentSession $session 
     * @param ezcPersistentIdentityMap $identityMap 
     * @param ezcPersistentIdentitySessionOptions $options
     */
    public function __construct( ezcPersistentSession $session, ezcPersistentIdentityMap $identityMap, ezcPersistentIdentitySessionOptions $options = null )
    {
        $this->session                   = $session;
        $this->properties['identityMap'] = $identityMap;
        $this->properties['options']     = (
            $options === null ? new ezcPersistentIdentitySessionOptions() : $options
        );
    }

    /**
     * Returns the persistent object of class $class with id $id.
     *
     * Checks if an identity for $class and $id has already been loaded. If
     * this is the case, the existing identity will be returned. Otherwise the
     * desired object will be loaded from the database and its identity will be
     * recorded.
     *
     * @throws ezcPersistentObjectException
     *         if the object is not available.
     * @throws ezcPersistentObjectException
     *         if there is no such persistent class.
     *
     * @param string $class
     * @param int $id
     *
     * @return object
     */
    public function load( $class, $id )
    {
        $idMap = $this->properties['identityMap'];

        if ( !$this->properties['options']->refetch )
        {
            $identity = $idMap->getIdentity( $class, $id );

            if ( $identity !== null )
            {
                return $identity;
            }
        }

        $identity = $this->session->load( $class, $id );
        $idMap->setIdentityWithId( $identity, $class, $id );
        
        return $identity;
    }

    /**
     * Returns the persistent object of class $class with id $id.
     *
     * This method is equivalent to {@link load()} except that it returns null
     * instead of throwing an exception if the object does not exist. A null
     * value will not be recorded in the identity map, so a second attempt to
     * load it will result in another database query.
     *
     * @param string $class
     * @param int $id
     *
     * @return object|null
     */
    public function loadIfExists( $class, $id )
    {
        $idMap = $this->properties['identityMap'];

        if ( !$this->properties['options']->refetch )
        {
            $identity = $idMap->getIdentity( $class, $id );

            if ( $identity !== null )
            {
                return $identity;
            }
        }

        $identity = $this->session->loadIfExists( $class, $id );

        if ( $identity !== null )
        {
            $idMap->setIdentityWithId( $identity, $class, $id );
        }
        
        return $identity;
    }

    /**
     * Loads the persistent object with the id $id into the object $object.
     *
     * The class of the persistent object to load is determined by the class
     * of $object. In case an identity for the given $id has already been
     * recorded and $object is not the same object, an exception will be
     * thrown.
     *
     * @throws ezcPersistentObjectException
     *         if the object is not available.
     * @throws ezcPersistentDefinitionNotFoundException
     *         if $object is not of a valid persistent object type.
     * @throws ezcPersistentQueryException
     *         if the find query failed.
     * @throws ezcPersistentIdentityAlreadyExistsException
     *         if a different identity for $object and $id already exists.
     *
     * @param object $object
     * @param int $id
     */
    public function loadIntoObject( $object, $id )
    {
        $idMap = $this->properties['identityMap'];
        
        $class = get_class( $object );

        if ( !$this->properties['options']->refetch )
        {
            $identity = $idMap->getIdentity( $class, $id );

            if ( $identity !== null )
            {
                throw new ezcPersistentIdentityAlreadyExistsException(
                    $class,
                    $id
                );
            }
        }

        $this->session->loadIntoObject( $object, $id );

        $idMap->setIdentityWithId( $object, $class, $id );
    }

    /**
     * Syncronizes the contents of $object with those in the database.
     *
     * Note that calling this method is equavalent with calling {@link
     * loadIntoObject()} on $object with the id of $object. Any changes made
     * to $object prior to calling refresh() will be discarded.
     *
     * The refreshing of an object will result in its identity being refreshed
     * automatically.
     *
     * @throws ezcPersistentObjectException
     *         if $object is not of a valid persistent object type.
     * @throws ezcPersistentObjectException
     *         if $object is not persistent already.
     * @throws ezcPersistentObjectException
     *         if the select query failed.
     *
     * @param object $object
     */
    public function refresh( $object )
    {
        $this->session->refresh( $object );
    }

    /**
     * Returns the result of the query $query as a list of objects.
     *
     * Returns the persistent objects found for $class using the submitted
     * $query. $query should be created using {@link createFindQuery()} to
     * ensure correct alias mappings and can be manipulated as needed.
     *
     * The results fetched will be checked for identities that have already
     * been fetched before. If this is the case, the existing identity will be
     * replaced into the result set. Note: This does not prevent the find call
     * from happening.
     *
     * Example:
     * <code>
     * $q = $session->createFindQuery( 'Person' );
     * $allPersons = $session->find( $q, 'Person' );
     * </code>
     *
     * If you are retrieving large result set, consider using {@link
     * findIterator()} instead.
     *
     * Example:
     * <code>
     * $q = $session->createFindQuery( 'Person' );
     * $objects = $session->findIterator( $q, 'Person' );
     *
     * foreach( $objects as $object )
     * {
     *     // ...
     * }
     * </code>
     *
     * @throws ezcPersistentDefinitionNotFoundException
     *         if there is no such persistent class.
     * @throws ezcPersistentQueryException
     *         if the find query failed.
     * @throws ezcBaseValueException
     *         if $query parameter is not an instance of ezcPersistentFindQuery
     *         or ezcQuerySelect. Or if $class is missing if you use
     *         ezcQuerySelect.
     *
     * @param ezcPersistentFindQuery|ezcQuerySelect $query
     * @param string $class
     *
     * @return array(object($class))
     * @apichange This method will only accept an instance of
     *            ezcPersistentFindQuery as the $query parameter in future
     *            major releases. The $class parameter will be removed.
     */
    public function find( $query, $class = null )
    {
        $isRelFindQueryWithSetName = $query instanceof ezcPersistentRelationFindQuery
            && $query->relationSetName !== null;
        if ( !$this->options->refetch && $isRelFindQueryWithSetName )
        {
            // Check if such a subset already exisist
            $objects = $this->identityMap->getRelatedObjectSet(
                $query->relationSource,
                $query->relationSetName
            );
            if ( $objects !== null )
            {
                return $objects;
            }
        }

        $objects = $this->performFind( $query, $class );

        // Query for createRelationFindQuery() with sub-set name assigned
        // No refetch check needed anymore
        if ( $isRelFindQueryWithSetName )
        {
            $objects = $this->identityMap->setRelatedObjectSet(
                $query->relationSource,
                $objects,
                $query->relationSetName
            );
        }

        return $objects;
    }

    private function performFind( $query, $class = null )
    {
        $objects = $this->session->find( $query, $class );

        $defs = array();

        foreach ( $objects as $i => $object )
        {
            $class = get_class( $object );

            if ( !isset( $defs[$class] ) )
            {
                $defs[$class] = $this->session->definitionManager->fetchDefinition(
                    $class
                );
            }

            $state = $object->getState();
            $id    = $state[$defs[$class]->idProperty->propertyName];
            
            $identity = null;

            if ( !$this->properties['options']->refetch )
            {
                $identity = $this->properties['identityMap']->getIdentity(
                    $class,
                    $id
                );
            }

            if ( $identity !== null )
            {
                $objects[$i] = $identity;
            }
            else
            {
                $this->properties['identityMap']->setIdentityWithId(
                    $object,
                    $class,
                    $id
                );
            }
        }

        return $objects;
    }

    /**
     * Returns the result of $query for the $class as an iterator.
     *
     * This method is similar to {@link find()} but returns an {@link
     * ezcPersistentFindIterator} instead of an array of objects. This is
     * useful if you are going to loop over the objects and just need them one
     * at the time.  Because you only instantiate one object it is faster than
     * {@link find()}. In addition, only 1 record is retrieved from the
     * database in each iteration, which may reduce the data transfered between
     * the database and PHP, if you iterate only through a small subset of the
     * affected records.
     *
     * Note that if you do not loop over the complete result set you must call
     * {@link ezcPersistentFindIterator::flush()} before issuing another query.
     *
     * The find interator will automatically look up result objects in the
     * identity map and return existing identities, if they have already been
     * recorded.
     *
     * @throws ezcPersistentDefinitionNotFoundException
     *         if there is no such persistent class.
     * @throws ezcPersistentQueryException
     *         if the find query failed.
     * @throws ezcBaseValueException
     *         if $query parameter is not an instance of ezcPersistentFindQuery
     *         or ezcQuerySelect. Or if $class is missing if you use
     *         ezcQuerySelect.
     *
     * @param ezcPersistentFindQuery|ezcQuerySelect $query
     * @param string $class
     *
     * @return ezcPersistentIdentityFindIterator
     * @apichange This method will only accept an instance of
     *            ezcPersistentFindQuery as the $query parameter in future
     *            major releases. The $class parameter will be removed.
     */
    public function findIterator( $query, $class = null )
    {
        // Sanity checks
        if ( !is_object( $query )
             || ( !( $query instanceof ezcPersistentFindQuery )
                  && !( $query instanceof ezcQuerySelect )
                )
           )
        {
            throw new ezcBaseValueException(
                'query',
                $query,
                'ezcPersistentFindQuery (or ezcQuerySelect)'
            );
        }
        if ( $query instanceof ezcQuerySelect && $class === null )
        {
            throw new ezcBaseValueException(
                'class',
                $class,
                'must be present, if ezcQuerySelect is used for $query'
            );
        }

        // Extract class name and select query form parameter
        if ( $query instanceof ezcPersistentFindQuery )
        {
            $class = $query->className;
            $query = $query->query;
        }

        $def  = $this->definitionManager->fetchDefinition( $class );
        $stmt = $this->session->performQuery( $query );
        return new ezcPersistentIdentityFindIterator(
            $stmt,
            $def,
            $this->identityMap,
            $this->properties['options']
        );
    }

    /**
     * Returns the related objects of a given $relatedClass for an $object.
     *
     * This method returns the related objects of type $relatedClass for the
     * given $object. This method (in contrast to {@link getRelatedObject()})
     * always returns an array of found objects, no matter if only 1 object
     * was found (e.g. {@link ezcPersistentManyToOneRelation}), none or several
     * ({@link ezcPersistentManyToManyRelation}).
     *
     * In case the set of related objects has already been fetched earlier, the
     * request to the database is not repeated, but the recorded object set is
     * returned. If the set of related objects was not recorded, yet, it is
     * fetched from the database and recorded afterwards.
     *
     * Example:
     * <code>
     * $person = $session->load( "Person", 1 );
     * $relatedAddresses = $session->getRelatedObjects( $person, "Address" );
     * echo "Number of addresses found: " . count( $relatedAddresses );
     * </code>
     *
     * Relations that should preferably be used with this method are:
     * <ul>
     * <li>{@link ezcPersistentOneToManyRelation}</li>
     * <li>{@link ezcPersistentManyToManyRelation}</li>
     * </ul>
     * For other relation types {@link getRelatedObject()} is recommended.
     *
     * If multiple relations are defined for the $relatedClass (using {@link
     * ezcPersistentRelationCollection}), the parameter $relationName becomes
     * mandatory to determine which relation definition to use. For normal
     * relations, this parameter is silently ignored.
     *
     * @param object $object
     * @param string $relatedClass
     * @param string $relationName
     *
     * @return array(int=>object($relatedClass))
     *
     * @throws ezcPersistentRelationNotFoundException
     *         if the given $object does not have a relation to $relatedClass.
     */
    public function getRelatedObjects( $object, $relatedClass, $relationName = null )
    {
        if ( !$this->properties['options']->refetch )
        {
            $relatedObjs = $this->identityMap->getRelatedObjects(
                $object,
                $relatedClass,
                $relationName
            );
            if ( $relatedObjs !== null )
            {
                return $relatedObjs;
            }
        }

        $relatedObjs = $this->session->getRelatedObjects(
            $object,
            $relatedClass,
            $relationName
        );

        $storedRelatedObjs = $this->identityMap->setRelatedObjects(
            $object,
            $relatedObjs,
            $relatedClass,
            $relationName,
            $this->properties['options']->refetch
        );

        return $storedRelatedObjs;
    }

    /**
     * Returns the related object of a given $relatedClass for an $object.
     *
     * This method returns the related object of type $relatedClass for the
     * object $object. This method (in contrast to {@link getRelatedObjects()})
     * always returns a single result object, no matter if more related objects
     * could be found (e.g. {@link ezcPersistentOneToManyRelation}). If no
     * related object is found, an exception is thrown, while {@link
     * getRelatedObjects()} just returns an empty array in this case.
     *
     * In case the set of related objects has already been fetched earlier, the
     * request to the database is not repeated, but the recorded object set is
     * returned. If the set of related objects was not recorded, yet, it is
     * fetched from the database and recorded afterwards.
     *
     * Example:
     * <code>
     * $person = $session->load( "Person", 1 );
     * $relatedAddress = $session->getRelatedObject( $person, "Address" );
     * echo "Address of this person: " . $relatedAddress->__toString();
     * </code>
     *
     * Relations that should preferably be used with this method are:
     * <ul>
     * <li>{@link ezcPersistentManyToOneRelation}</li>
     * <li>{@link ezcPersistentOneToOneRelation}</li>
     * </ul>
     * For other relation types {@link getRelatedObjects()} is recommended.
     *
     * If multiple relations are defined for the $relatedClass (using {@link
     * ezcPersistentRelationCollection}), the parameter $relationName becomes
     * mandatory to determine which relation definition to use. For normal
     * relations, this parameter is silently ignored.
     *
     * @param object $object
     * @param string $relatedClass
     * @param string $relationName
     *
     * @return object($relatedClass)
     *
     * @throws ezcPersistentRelationNotFoundException
     *         if the given $object does not have a relation to $relatedClass.
     */
    public function getRelatedObject( $object, $relatedClass, $relationName = null )
    {
        $relObjs = $this->getRelatedObjects(
            $object,
            $relatedClass,
            $relationName
        );
        return reset( $relObjs );
    }

    /**
     * Returns a select query for the given persistent object $class.
     *
     * The query is initialized to fetch all columns from the correct table and
     * has correct alias mappings between columns and property names of the
     * persistent $class.
     *
     * Example:
     * <code>
     * $q = $session->createFindQuery( 'Person' );
     * $allPersons = $session->find( $q, 'Person' );
     * </code>
     *
     * @throws ezcPersistentObjectException
     *         if there is no such persistent class.
     *
     * @param string $class
     *
     * @return ezcPersistentFindQuery
     */
    public function createFindQuery( $class )
    {
        return $this->session->createFindQuery( $class );
    }

    /**
     * Returns the base query for retrieving related objects.
     *
     * See {@link getRelatedObject()} and {@link getRelatedObjects()}. Can be
     * modified by additional where conditions and simply be used with
     * {@link find()} and the related class name, to retrieve a sub-set of
     * related objects.
     *
     * If multiple relations are defined for the $relatedClass (using {@link
     * ezcPersistentRelationCollection}), the parameter $relationName becomes
     * mandatory to determine which relation definition to use. For normal
     * relations, this parameter is silently ignored.
     *
     * If you provide a $setName, the resulting set of related objects fetched
     * by {@link find()} is cached under the given name for $object. You can
     * retrieve this set either through {@link getRelatedObjectSubset()} or by
     * issueing the same query (or a query with the same $object and $setName)
     * again. Overwriting a once created named set can be enfored using the
     * 'refetch' option in {@link ezcPersistentIdentitySessionOptions}.
     *
     * @param object $object
     * @param string $relatedClass
     * @param string $relationName
     * @param string $setName
     *
     * @return ezcPersistentRelationFindQuery
     *
     * @throws ezcPersistentRelationNotFoundException
     *         if the given $object does not have a relation to $relatedClass.
     *
     * @TODO: Implement {@link getRelatedObjectSubset()}.
     */
    public function createRelationFindQuery( $object, $relatedClass, $relationName = null, $setName = null )
    {
        $originalQuery = $this->session->createRelationFindQuery( $object, $relatedClass, $relationName );

        $q = new ezcPersistentRelationFindQuery(
            $originalQuery->query,
            $originalQuery->className
        );
        
        if ( $setName !== null )
        {
            $q->relationSetName = $setName;
            $q->relationSource  = $object;
        }

        return $q;
    }

    /**
     * Saves the new persistent object $object to the database using an INSERT INTO query.
     *
     * The correct ID is set to $object.
     *
     * Newly saved objects are stored in the identity map. They will not be
     * fetched from the database again.
     *
     * @throws ezcPersistentObjectException if $object
     *         is not of a valid persistent object type.
     * @throws ezcPersistentObjectException if $object
     *         is already stored to the database.
     * @throws ezcPersistentObjectException
     *         if it was not possible to generate a unique identifier for the
     *         new object.
     * @throws ezcPersistentObjectException
     *         if the insert query failed.
     *
     * @param object $object
     */
    public function save( $object )
    {
        $class = get_class( $object );
        $def   = $this->definitionManager->fetchDefinition( $class );
        $state = $object->getState();
        
        // Sanity checks
        if ( !$this->properties['options']->refetch && isset( $state[$def->idProperty->propertyName] ) )
        {
            $id       = $state[$def->idProperty->propertyName];
            $identity = $this->identityMap->getIdentity( $class, $id );

            if ( $identity !== null )
            {
                if ( $identity === $object )
                {
                    throw new ezcPersistentObjectAlreadyPersistentException( $class );
                }
                throw new ezcPersistentIdentityAlreadyExistsException( $class, $identity );
            }
        }

        $this->session->save( $object );

        $this->identityMap->setIdentity( $object );
    }

    /**
     * Saves the new persistent object $object to the database using an UPDATE query.
     *
     * Updates are automatically reflected in the identity map.
     *
     * @throws ezcPersistentDefinitionNotFoundException
     *         if $object is not of a valid persistent object type.
     * @throws ezcPersistentObjectNotPersistentException
     *         if $object is not stored in the database already.
     * @throws ezcPersistentQueryException
     *
     * @param object $object
     */
    public function update( $object )
    {
        // The object already must have been fetched before here, so an
        // identity is already recorded.
        $this->session->update( $object );
    }

    /**
     * Saves or updates the persistent object $object to the database.
     *
     * If the object is a new object an INSERT INTO query will be executed. If
     * the object is persistent already it will be updated with an UPDATE
     * query.
     *
     * @throws ezcPersistentDefinitionNotFoundException
     *         if the definition of the persistent object could not be loaded.
     * @throws ezcPersistentObjectException
     *         if $object is not of a valid persistent object type.
     * @throws ezcPersistentObjectException
     *         if any of the definition requirements are not met.
     * @throws ezcPersistentObjectException
     *         if the insert or update query failed.
     * @param object $object
     * @return void
     */
    public function saveOrUpdate( $object )
    {
        $this->session->saveOrUpdate( $object );

        $class = get_class( $object );
        $def   = $this->definitionManager->fetchDefinition( $class );
        $state = $object->getState();
        $id    = $state[$def->idProperty->propertyName];

        if ( $this->properties['options']->refetch || $this->identityMap->getIdentity( $class, $id ) === null )
        {
            $this->identityMap->setIdentityWithId( $object, $class, $id );
        }
    }

    /**
     * Create a relation between $object and $relatedObject.
     *
     * This method is used to create a relation between the given source
     * $object and the desired $relatedObject. The related object is not stored
     * in the database automatically, only the desired properties are set. An
     * exception is {@ezcPersistentManyToManyRelation}s, where the relation
     * record is stored automatically and there is no need to store
     * $relatedObject explicitly after establishing the relation.
     *
     * If there are multiple relations defined between the class of $object and
     * $relatedObject (via {@link ezcPersistentRelationCollection}), the
     * $relationName parameter becomes mandatory to determine, which exact
     * relation should be used.
     *
     * Newly added related objects are stored in the identity map and added to
     * recorded relation sets. Note that all named related sets are
     * invalidated.
     *
     * @param object $object
     * @param object $relatedObject
     * @param string $relationName
     *
     * @throws ezcPersistentRelationOperationNotSupportedException
     *         if a relation to create is marked as "reverse" {@link
     *         ezcPersistentRelation->reverse}.
     * @throws ezcPersistentRelationNotFoundException
     *         if the deisred relation is not defined.
     */
    public function addRelatedObject( $object, $relatedObject, $relationName = null )
    {
        $this->session->addRelatedObject( $object, $relatedObject, $relationName );
        $this->identityMap->addRelatedObject( $object, $relatedObject );
    }


    /**
     * Returns an update query for the given persistent object $class.
     *
     * The query is initialized to update the correct table and
     * it is only neccessary to set the correct values.
     *
     * Attention: If you use a query generated by this method to update object
     * through {@link ezcPersistentIdentitySession}, the internal {@link
     * ezcPersistentIdentityMap} will be completly reset. This is neccessary to
     * avoid inconsistencies, because the session cannot trace which objects
     * are updated by the query.
     *
     * @throws ezcPersistentDefinitionNotFoundException
     *         if there is no such persistent class.
     *
     * @param string $class
     *
     * @return ezcQueryUpdate
     */
    public function createUpdateQuery( $class )
    {
        return $this->session->createUpdateQuery( $class );
    }

    /**
     * Updates persistent objects using the query $query.
     *
     * The $query should be created using createUpdateQuery().
     *
     * Currently this method only executes the provided query. Future
     * releases PersistentSession may introduce caching of persistent objects.
     * When caching is introduced it will be required to use this method to run
     * cusom delete queries. To avoid being incompatible with future releases it is
     * advisable to always use this method when running custom delete queries on
     * persistent objects.
     *
     * Attention: Every call to this method will cause the internal {@link
     * ezcPersistentIdentityMap} to be completly reset. This is neccessary to
     * avoid inconsistencies, because the session cannot trace which objects
     * are updated by the query.
     *
     * @throws ezcPersistentQueryException
     *         if the update query failed.
     *
     * @param ezcQueryUpdate $query
     */
    public function updateFromQuery( ezcQueryUpdate $query )
    {
        $this->identityMap->reset();
        return $this->session->updateFromQuery( $query );
    }

    /**
     * Deletes the persistent object $object.
     *
     * This method will perform a DELETE query based on the identifier of the
     * persistent object $object. After delete() the ID property of $object
     * will be reset to null. It is possible to {@link save()} $object
     * afterwards.  $object will then be stored with a new ID.
     *
     * If you defined relations for the given object, these will be checked to
     * be defined as cascading. If cascading is configured, the related objects
     * with this relation will be deleted, too.
     *
     * The object will also be removed from the identity map and all related
     * object sets in it.
     *
     * Relations that support cascading are:
     * <ul>
     * <li>{@link ezcPersistenOneToManyRelation}</li>
     * <li>{@link ezcPersistenOneToOne}</li>
     * </ul>
     *
     * @throws ezcPersistentDefinitionNotFoundxception
     *         if $the object is not recognized as a persistent object.
     * @throws ezcPersistentObjectNotPersistentException
     *         if the object is not persistent already.
     * @throws ezcPersistentQueryException
     *         if the object could not be deleted.
     *
     * @param object $object The persistent object to delete.
     */
    public function delete( $object )
    {
        $this->session->delete( $object );

        $class = get_class( $object );
        $def = $this->session->definitionManager->fetchDefinition( $class );
        $state = $object->getState();
        $id = $state[$def->idProperty->propertyName];
        
        $this->identityMap->removeIdentity( $class, $id );
    }

    /**
     * Removes the relation between $object and $relatedObject.
     *
     * This method is used to delete an existing relation between 2 objects.
     * Like {@link addRelatedObject()} this method does not store the related
     * object after removing its relation properties (unset), except for {@link
     * ezcPersistentManyToManyRelation()}s, for which the relation record is
     * deleted from the database.
     *
     * If between the classes of $object and $relatedObject multiple relations
     * are defined using a {@link ezcPersistentRelationCollection}, the
     * $relationName parameter becomes necessary. It defines which exact
     * relation to affect here.
     *
     * @param object $object        Source object of the relation.
     * @param object $relatedObject Related object.
     * @param string $relationName
     *
     * @throws ezcPersistentRelationOperationNotSupportedException
     *         if a relation to create is marked as "reverse".
     * @throws ezcPersistentRelationNotFoundException
     *         if the deisred relation is not defined.
     */
    public function removeRelatedObject( $object, $relatedObject, $relationName = null )
    {
        $this->session->removeRelatedObject( $object, $relatedObject, $relationName );
        $this->identityMap->removeRelatedObject( $object, $relatedObject, $relationName );
    }


    /**
     * Deletes persistent objects using the query $query.
     *
     * The $query should be created using {@link createDeleteQuery()}.
     *
     * Currently this method only executes the provided query. Future
     * releases PersistentSession may introduce caching of persistent objects.
     * When caching is introduced it will be required to use this method to run
     * cusom delete queries. To avoid being incompatible with future releases it is
     * advisable to always use this method when running custom delete queries on
     * persistent objects.
     *
     * Attention: Every call to this method will cause the internal {@link
     * ezcPersistentIdentityMap} to be completly reset. This is neccessary to
     * avoid inconsistencies, because the session cannot trace which objects
     * are updated by the query.
     *
     * @throws ezcPersistentQueryException
     *         if the delete query failed.
     *
     * @param ezcQueryDelete $query
     */
    public function deleteFromQuery( ezcQueryDelete $query )
    {
        $this->identityMap->reset();
        return $this->session->deleteFromQuery( $query );
    }

    /**
     * Returns a delete query for the given persistent object $class.
     *
     * The query is initialized to delete from the correct table and
     * it is only neccessary to set the where clause.
     *
     * Example:
     * <code>
     * $q = $session->createDeleteQuery( 'Person' );
     * $q->where( $q->expr->gt( 'age', $q->bindValue( 15 ) ) );
     * $session->deleteFromQuery( $q );
     * </code>
     *
     * Attention: If you use a query generated by this method to delete objects
     * through {@link ezcPersistentIdentitySession}, the internal {@link
     * ezcPersistentIdentityMap} will be completly reset. This is neccessary to
     * avoid inconsistencies, because the session cannot trace which objects
     * are deleted by the query.
     *
     * @throws ezcPersistentObjectException
     *         if there is no such persistent class.
     *
     * @param string $class
     *
     * @return ezcQueryDelete
     */
    public function createDeleteQuery( $class )
    {
        return $this->session->createDeleteQuery( $class );
    }

    /**
     * Loads an object of $class with $id and related objects defined by $relations.
     *
     * This method loads the object of $class identified by $id. In addition,
     * all objects defined by $relations are loaded and fetched into the
     * identity map. Those can then be retrieved using {@link
     * getRelatedObjects()}, without issueing further database queries.
     * 
     * @param string $class 
     * @param string $id 
     * @param array(ezcPersistentRelationFindDefinition) $relations 
     * @return object
     */
    public function loadWithRelatedObjects( $class, $id, array $relations )
    {
        if ( $this->queryCreator === null )
        {
            $this->queryCreator = new ezcPersistentIdentityRelationQueryCreator(
                $this->session->definitionManager,
                $this->session->database
            );
        }

        $select = $this->queryCreator->createLoadQuery( $class, $id, $relations );

        $stmt = $select->prepare();
        $stmt->execute();

        if ( $this->objectExtractor === null )
        {
            $this->objectExtractor = new ezcPersistentIdentityRelationObjectExtractor(
                $this->properties['identityMap'],
                $this->session->definitionManager,
                $this->properties['options']
            );
        }

        $this->objectExtractor->extractObjectWithRelatedObjects(
            $stmt,
            $class,
            $id,
            $relations
        );

        return $this->identityMap->getIdentity( $class, $id );
    }

    /**
     * Returns a hash map between property and column name for the given
     * definition $def.
     *
     * The alias map can be used with the query classes. If $prefixTableName is
     * set to false, only the column names are used as alias targets.
     *
     * @param ezcPersistentObjectDefinition $def Definition.
     * @param bool $prefixTableName
     * @return array(string=>string)
     */
    public function generateAliasMap( ezcPersistentObjectDefinition $def, $prefixTableName = true )
    {
        return $this->session->generateAliasMap( $def, $prefixTableName );
    }

    /**
     * Returns all the columns defined in the persistent object.
     *
     * If $prefixTableName is set to false, raw column names will be used,
     * without prefixed table name.
     *
     * @param ezcPersistentObjectDefinition $def Defintion.
     * @param bool $prefixTableName
     * @return array(int=>string)
     */
    public function getColumnsFromDefinition( ezcPersistentObjectDefinition $def, $prefixTableName = true )
    {
        return $this->session->getColumnsFromDefinition( $def, $prefixTableName );
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property does not exist.
     *
     * @param string $name
     * @param mixed $value
     *
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'identityMap':
                throw new ezcBasePropertyPermissionException(
                    $name,
                    ezcBasePropertyPermissionException::READ
                );

            case 'options':
                if ( !( $value instanceof ezcPersistentIdentitySessionOptions ) )
                {
                    throw new ezcBaseValueException(
                        $name,
                        $value,
                        'ezcPersistentIdentitySessionOptions'
                    );
                }
                break;

            default:
                // Decorator: Dispatch unknown options to inner session
                $this->session->$name = $value;
                return;
        }
        $this->properties[$name] = $value;
    }

    /**
     * Property get access.
     *
     * Simply returns a given property.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property propertys is not an instance of
     * @param string $propertyName The name of the property to get.
     * @return mixed The property value.
     *
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a write-only property.
     */
    public function __get( $propertyName )
    {
        if ( array_key_exists( $propertyName, $this->properties ) )
        {
            return $this->properties[$propertyName];
        }
        return $this->session->$propertyName;
    }

    /**
     * Returns if a property exists.
     *
     * Returns true if the property exists in the {@link $properties} array
     * (even if it is null) and false otherwise. 
     *
     * @param string $propertyName Option name to check for.
     * @return void
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return (
            array_key_exists( $propertyName, $this->properties )
            || isset( $this->session->$propertyName )
        );
    }
}
?>
