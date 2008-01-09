<?php
/**
 * File containing the ezcPersistentSession class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcPersistentSession is the main runtime interface for manipulation of persistent objects.
 *
 * Persistent objects can be stored calling save() resulting in an INSERT query. If
 * the object is already persistent you can store it using update() which results in
 * an UPDATE query. If you want to query persistent objects you can use the find methods.
 *
 * @property-read ezcDbHandler $database
 *                The database handler set in the constructor.
 * @property-read ezcPersistentDefinitionManager $definitionManager
 *                The persistent definition manager set in the constructor.
 *
 * @package PersistentObject
 * @version //autogen//
 * @mainclass
 */
class ezcPersistentSession
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Constructs a new persistent session that works on the database $db.
     *
     * The $manager provides valid persistent object definitions to the
     * session. The $db will be used to perform all database operations.
     *
     * @param ezcDbHandler $db
     * @param ezcPersistentDefinitionManager $manager
     */
    public function __construct( ezcDbHandler $db, ezcPersistentDefinitionManager $manager )
    {
        $this->properties['database'] = $db;
        $this->properties['definitionManager'] = $manager;
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
            case 'database':
            case 'definitionManager':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }

    }

    /**
     * Returns the property $name.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property does not exist.
     *
     * @param string $name
     * @return mixed
     *
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'database':
            case 'definitionManager':
                return isset( $this->properties[$name] ) ? $this->properties[$name] : null;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }

    /**
     * Deletes the persistent object $pObject.
     *
     * This method will perform a DELETE query based on the identifier of the
     * persistent object $pObject. After delete() the ID property of $pObject
     * will be reset to null. It is possible to {@link save()} $pObject
     * afterwards.  $pObject will then be stored with a new ID.
     *
     * If you defined relations for the given object, these will be checked to
     * be defined as cascading. If cascading is configured, the related objects
     * with this relation will be deleted, too.
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
     * @param object $pObject The persistent object to delete.
     */
    public function delete( $pObject )
    {
        $class = get_class( $pObject );
        $def = $this->definitionManager->fetchDefinition( $class ); // propagate exception
        $state = $pObject->getState();
        $idValue = $state[$def->idProperty->propertyName];

        // check that the object is persistent already
        if ( $idValue == null || $idValue < 0 )
        {
            $class = get_class( $pObject );
            throw new ezcPersistentObjectNotPersistentException( $class );
        }

        // Transaction savety for exceptions thrown while cascading
        $this->database->beginTransaction();

        try
        {
            // check for cascading relations to follow
            foreach ( $def->relations as $relatedClass => $relation )
            {
                $this->cascadeDelete( $pObject, $relatedClass, $relation );
            }
        }
        catch ( Exception $e )
        {
            // Roll back the current transaction on any exception
            $this->database->rollback();
            throw $e;
        }

        // create and execute query
        $q = $this->database->createDeleteQuery();
        $q->deleteFrom( $this->database->quoteIdentifier( $def->table ) )
            ->where( $q->expr->eq( $this->database->quoteIdentifier( $def->idProperty->columnName ),
                                   $q->bindValue( $idValue ) ) );

        try
        {
            $stmt = $q->prepare();
            $stmt->execute();
            if ( $stmt->errorCode() != 0 )
            {
                throw new ezcPersistentQueryException( "The delete query failed.", $q );
            }
        }
        catch ( PDOException $e )
        {
            // Need to rollbak manually here, if we are on the first transaction
            // level
            $this->database->rollback();
            throw new ezcPersistentQueryException( $e->getMessage(), $q );
        }

        // After recursion of cascades everything should be fine here, or this
        // final commit call should perform the rollback ordered by a deeper level
        $this->database->commit();
    }

    /**
     * Perform the cascading of deletes on a specific relation.
     *
     * This method checks a given $relation of a given $object for necessary
     * actions on a cascaded delete and performs them.
     *
     * @param object $object                  The persistent object.
     * @param string $relatedClass            The class of the related persistent
     *                                        object.
     * @param ezcPersistentRelation $relation The relation to check.
     *
     * @todo Revise cascading code. So far it sends 1 delete statement per
     *       object but we can also collect them table wise and send just 1
     *       for each table.
     */
    private function cascadeDelete( $object, $relatedClass, ezcPersistentRelation $relation )
    {
        // Remove relation records for ManyToMany relations
        if ( $relation instanceof ezcPersistentManyToManyRelation )
        {
            foreach ( $this->getRelatedObjects( $object, $relatedClass ) as $relatedObject )
            {
                // Need to determine the correct direction for removal
                if ( $relation->reverse === true  )
                {
                    $this->removeRelatedObject( $relatedObject, $object );
                }
                else
                {
                    $this->removeRelatedObject( $object, $relatedObject );
                }
            }
        }
        if ( isset( $relation->cascade ) && $relation->cascade === true )
        {
            if ( isset( $relation->reverse ) && $relation->reverse === true )
            {
                throw new ezcPersistentRelationOperationNotSupported(
                    $class,
                    $relatedClass,
                    "cascade on delete",
                    "Reverse relations do not support cascading."
                );
            }
            foreach ( $this->getRelatedObjects( $object, $relatedClass ) as $relatedObject )
            {
                $this->delete( $relatedObject );
            }
        }
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
     * @throws ezcPersistentObjectException
     *         if there is no such persistent class.
     *
     * @param string $class
     *
     * @return ezcQueryDelete
     */
    public function createDeleteQuery( $class )
    {
        $def = $this->definitionManager->fetchDefinition( $class ); // propagate exception

        // init query
        $q = $this->database->createDeleteQuery();
        $q->setAliases( $this->generateAliasMap( $def, false ) );
        $q->deleteFrom( $this->database->quoteIdentifier( $def->table ) );

        return $q;
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
     * @throws ezcPersistentQueryException
     *         if the delete query failed.
     *
     * @param ezcQueryDelete $query
     */
    public function deleteFromQuery( ezcQueryDelete $query )
    {
        try
        {
            $stmt = $query->prepare();
            $stmt->execute();
        }
        catch ( PDOException $e )
        {
            throw new ezcPersistentQueryException( $e->getMessage(), $query );
        }
    }

    /**
     * Returns an update query for the given persistent object $class.
     *
     * The query is initialized to update the correct table and
     * it is only neccessary to set the correct values.
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
        $def = $this->definitionManager->fetchDefinition( $class ); // propagate exception

        // init query
        $q = $this->database->createUpdateQuery();
        $q->setAliases( $this->generateAliasMap( $def, false ) );
        $q->update( $this->database->quoteIdentifier( $def->table ) );

        return $q;
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
     * @throws ezcPersistentQueryException
     *         if the update query failed.
     *
     * @param ezcQueryUpdate $query
     */
    public function updateFromQuery( ezcQueryUpdate $query )
    {
        try
        {
            $stmt = $query->prepare();
            $stmt->execute();
        }
        catch ( PDOException $e )
        {
            throw new ezcPersistentQueryException( $e->getMessage(), $query );
        }
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
     * @return ezcQuerySelect
     */
    public function createFindQuery( $class )
    {
        $def = $this->definitionManager->fetchDefinition( $class ); // propagate exception

        // init query
        $q = $this->database->createSelectQuery();
        $q->setAliases( $this->generateAliasMap( $def ) );
        $q->select( $this->getColumnsFromDefinition( $def ) )
            ->from( $this->database->quoteIdentifier( $def->table ) );

        return $q;
    }

    /**
     * Returns the result of the query $query as a list of objects.
     *
     * Returns the persistent objects found for $class using the submitted
     * $query. $query should be created using {@link createFindQuery()} to
     * ensure correct alias mappings and can be manipulated as needed.
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
     *
     * @param ezcQuerySelect $query
     * @param string $class
     *
     * @return array(object($class))
     */
    public function find( ezcQuerySelect $query, $class )
    {
        $def = $this->definitionManager->fetchDefinition( $class ); // propagate exception

        try
        {
            $stmt = $query->prepare();
            $stmt->execute();
            $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );
        }
        catch ( PDOException $e )
        {
            throw new ezcPersistentQueryException( $e->getMessage(), $query );
        }

        // convert all the rows states and then objects
        $result = array();
        foreach ( $rows as $row )
        {
            $object = new $def->class;
            $object->setState( ezcPersistentStateTransformer::rowToStateArray( $row, $def ) );
            $result[] = $object;
        }
        return $result;
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
     * @param object $object
     * @param string $relatedClass
     *
     * @return array(int=>object($relatedClass))
     *
     * @throws ezcPersistentRelationNotFoundException
     *         if the given $object does not have a relation to $relatedClass.
     */
    public function getRelatedObjects( $object, $relatedClass )
    {
        $query = $this->createRelationFindQuery( $object, $relatedClass );
        return $this->find( $query, $relatedClass );
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
     * Example:
     * <code>
     * $person = $session->load( "Person", 1 );
     * $relatedAddress = $session->getRelatedObject( $person, "Address" );
     * echo "Address of this person: " . $relatedAddress->__toString();
     * </code>
     *
     * Relations that should preferably be used with this method are:
     * <ul>
     * <li>{@link ezcPersistentManyToOneRelation}</ li>
     * <li>{@link ezcPersistentOneToOneRelation}</li>
     * </ul>
     * For other relation types {@link getRelatedObjects()} is recommended.
     *
     * @param object $object
     * @param string $relatedClass
     *
     * @return object($relatedClass)
     *
     * @throws ezcPersistentRelationNotFoundException
     *         if the given $object does not have a relation to $relatedClass.
     */
    public function getRelatedObject( $object, $relatedClass )
    {
        $query = $this->createRelationFindQuery( $object, $relatedClass );
        // This method only needs to return 1 object
        $query->limit( 1 );

        $resArr = $this->find( $query, $relatedClass );
        if ( sizeof( $resArr ) < 1 )
        {
            throw new ezcPersistentRelatedObjectNotFoundException( $object, $relatedClass );
        }
        return $resArr[0];
    }

    /**
     * Returns the base query for retrieving related objects.
     *
     * See {@link getRelatedObject()} and {@link getRelatedObjects()}. Can be
     * modified by additional where conditions and simply be used with
     * {@link find()} and the related class name, to retrieve a sub-set of
     * related objects.
     *
     * @param object $object
     * @param string $relatedClass
     *
     * @return ezcDbSelectQuery
     *
     * @throws ezcPersistentRelationNotFoundException
     *         if the given $object does not have a relation to $relatedClass.
     */
    public function createRelationFindQuery( $object, $relatedClass )
    {
        $def = $this->definitionManager->fetchDefinition( ( $class = get_class( $object ) ) );
        if ( !isset( $def->relations[$relatedClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException( $class, $relatedClass );
        }
        $relation = $def->relations[$relatedClass];

        $query = $this->createFindQuery( $relatedClass );

        $objectState = $object->getState();

        switch ( ( $relationClass = get_class( $relation ) ) )
        {
            case "ezcPersistentOneToManyRelation":
            case "ezcPersistentManyToOneRelation":
            case "ezcPersistentOneToOneRelation":
                foreach ( $relation->columnMap as $map )
                {
                    $query->where(
                        $query->expr->eq(
                            $this->database->quoteIdentifier( "{$map->destinationColumn}" ),
                            $query->bindValue( $objectState[$def->columns[$map->sourceColumn]->propertyName] )
                        )
                    );
                }
                break;
            case "ezcPersistentManyToManyRelation":
                $query->from( $this->database->quoteIdentifier( $relation->relationTable ) );
                foreach ( $relation->columnMap as $map )
                {
                    $query->where(
                        $query->expr->eq(
                            $this->database->quoteIdentifier( $relation->relationTable ) . "." . $this->database->quoteIdentifier( $map->relationSourceColumn ),
                            $query->bindValue( $objectState[$def->columns[$map->sourceColumn]->propertyName] )
                        ),
                        $query->expr->eq(
                            $this->database->quoteIdentifier( $relation->relationTable ) . "." . $this->database->quoteIdentifier( $map->relationDestinationColumn ),
                            $this->database->quoteIdentifier( $relation->destinationTable ) . "." . $this->database->quoteIdentifier( $map->destinationColumn )
                        )
                    );
                }
                break;
            default:
                throw new ezcPersistentRelationInvalidException( $relationClass );
        }
        return $query;
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
     * @param object $object
     * @param object $relatedObject
     *
     * @throws ezcPersistentRelationOperationNotSupportedException
     *         if a relation to create is marked as "reverse" {@link
     *         ezcPersistentRelation->reverse}.
     * @throws ezcPersistentRelationNotFoundException
     *         if the deisred relation is not defined.
     */
    public function addRelatedObject( $object, $relatedObject )
    {
        $class = get_class( $object );
        $def = $this->definitionManager->fetchDefinition( ( $class = get_class( $object ) ) );

        $relatedClass = get_class( $relatedObject );

        $objectState = $object->getState();
        $relatedObjectState = $relatedObject->getState();

        if ( !isset( $def->relations[$relatedClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException( $class, $relatedClass );
        }
        if ( isset( $def->relations[$relatedClass]->reverse ) && $def->relations[$relatedClass]->reverse === true )
        {
            throw new ezcPersistentRelationOperationNotSupportedException(
                $class,
                $relatedClass,
                "addRelatedObject",
                "Relation is a reverse relation."
            );
        }

        $relatedDef = $this->definitionManager->fetchDefinition( get_class( $relatedObject ) );
        switch ( get_class( ( $relation = $def->relations[get_class( $relatedObject )] ) ) )
        {
            case "ezcPersistentOneToManyRelation":
            case "ezcPersistentOneToOneRelation":
                foreach ( $relation->columnMap as $map )
                {
                    $relatedObjectState[$relatedDef->columns[$map->destinationColumn]->propertyName] =
                        $objectState[$def->columns[$map->sourceColumn]->propertyName];
                }
                break;
            case "ezcPersistentManyToManyRelation":
                $q = $this->database->createInsertQuery();
                $q->insertInto( $this->database->quoteIdentifier( $relation->relationTable ) );
                $insertColumns = array();
                foreach ( $relation->columnMap as $map )
                {
                    if ( in_array( $map->relationSourceColumn, $insertColumns ) === false )
                    {
                        $q->set(
                            $this->database->quoteIdentifier( $map->relationSourceColumn ),
                            $q->bindValue( $objectState[$def->columns[$map->sourceColumn]->propertyName] )
                        );
                        $insertColumns[] = $map->relationSourceColumn;
                    }
                    if ( in_array( $map->relationDestinationColumn, $insertColumns ) === false )
                    {
                        $q->set(
                            $this->database->quoteIdentifier( $map->relationDestinationColumn ),
                            $q->bindValue( $relatedObjectState[$relatedDef->columns[$map->destinationColumn]->propertyName] )
                        );
                        $insertColumns[] = $map->relationDestinationColumn;
                    }
                }
                try
                {
                    $stmt = $q->prepare();
                    $stmt->execute();
                }
                catch ( PDOException $e )
                {
                    throw new ezcPersistentQueryException( $e->getMessage(), $q );
                }
                break;
        }

        $relatedObject->setState( $relatedObjectState );
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
     * @param object $object        Source object of the relation.
     * @param object $relatedObject Related object.
     *
     * @throws ezcPersistentRelationOperationNotSupportedException
     *         if a relation to create is marked as "reverse".
     * @throws ezcPersistentRelationNotFoundException
     *         if the deisred relation is not defined.
     */
    public function removeRelatedObject( $object, $relatedObject )
    {
        $class = get_class( $object );
        $def = $this->definitionManager->fetchDefinition( ( $class = get_class( $object ) ) );

        $relatedClass = get_class( $relatedObject );

        if ( !isset( $def->relations[$relatedClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException( $class, $relatedClass );
        }
        if ( isset( $def->relations[$relatedClass]->reverse ) && $def->relations[$relatedClass]->reverse === true )
        {
            throw new ezcPersistentRelationOperationNotSupportedException(
                $class,
                $relatedClass,
                "deleteRelation",
                "Relation is a reverse relation."
            );
        }

        $objectState = $object->getState();
        $relatedObjectState = $relatedObject->getState();

        $relatedDef = $this->definitionManager->fetchDefinition( get_class( $relatedObject ) );
        switch ( get_class( ( $relation = $def->relations[get_class( $relatedObject )] ) ) )
        {
            case "ezcPersistentOneToManyRelation":
            case "ezcPersistentOneToOneRelation":
                foreach ( $relation->columnMap as $map )
                {
                    $relatedObjectState[$relatedDef->columns[$map->destinationColumn]->propertyName] = null;
                }
                break;
            case "ezcPersistentManyToManyRelation":
                $q = $this->database->createDeleteQuery();
                $q->deleteFrom( $this->database->quoteIdentifier( $relation->relationTable ) );
                foreach ( $relation->columnMap as $map )
                {
                    $q->where(
                        $q->expr->eq(
                            $this->database->quoteIdentifier( $map->relationSourceColumn ),
                            $q->bindValue( $objectState[$def->columns[$map->sourceColumn]->propertyName] )
                        ),
                        $q->expr->eq(
                            $this->database->quoteIdentifier( $map->relationDestinationColumn ),
                            $q->bindValue( $relatedObjectState[$relatedDef->columns[$map->destinationColumn]->propertyName] )
                        )
                    );
                }
                try
                {
                    $stmt = $q->prepare();
                    $stmt->execute();
                }
                catch ( PDOException $e )
                {
                    throw new ezcPersistentQueryException( $e->getMessage(), $q );
                }
                break;
        }

        $relatedObject->setState( $relatedObjectState );
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
     * @throws ezcPersistentDefinitionNotFoundException
     *         if there is no such persistent class.
     * @throws ezcPersistentQueryException
     *         if the find query failed.
     *
     * @param ezcQuerySelect $query
     * @param string $class
     *
     * @return ezcPersistentFindIterator
     */
    public function findIterator( ezcQuerySelect $query, $class )
    {
        $def = $this->definitionManager->fetchDefinition( $class ); // propagate exception
        try
        {
            $stmt = $query->prepare();
            $stmt->execute();
        }
        catch ( PDOException $e )
        {
            throw new ezcPersistentQueryException( $e->getMessage(), $query );
        }
        return new ezcPersistentFindIterator( $stmt, $def );
    }

    /**
     * Returns the persistent object of class $class with id $id.
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
        $def = $this->definitionManager->fetchDefinition( $class ); // propagate exception
        $object = new $def->class;
        $this->loadIntoObject( $object, $id );
        return $object;
    }

    /**
     * Returns the persistent object of class $class with id $id.
     *
     * This method is equivalent to {@link load()} except that it returns null
     * instead of throwing an exception if the object does not exist.
     *
     * @param string $class
     * @param int $id
     *
     * @return object|null
     */
    public function loadIfExists( $class, $id )
    {
        $result = null;
        try
        {
            $result = $this->load( $class, $id );
        }
        catch ( Exception $e )
        {
            // eat, we return null on error
        }
        return $result;
    }

    /**
     * Loads the persistent object with the id $id into the object $pObject.
     *
     * The class of the persistent object to load is determined by the class
     * of $pObject.
     *
     * @throws ezcPersistentObjectException
     *         if the object is not available.
     * @throws ezcPersistentDefinitionNotFoundException
     *         if $pObject is not of a valid persistent object type.
     * @throws ezcPersistentQueryException
     *         if the find query failed.
     *
     * @param object $pObject
     * @param int $id
     */
    public function loadIntoObject( $pObject, $id )
    {
        $def = $this->definitionManager->fetchDefinition( get_class( $pObject ) ); // propagate exception
        $q = $this->database->createSelectQuery();
        $q->select( $this->getColumnsFromDefinition( $def ) )
            ->from( $this->database->quoteIdentifier( $def->table ) )
            ->where( $q->expr->eq( $this->database->quoteIdentifier( $def->idProperty->columnName ),
                                   $q->bindValue( $id ) ) );
        try
        {
            $stmt = $q->prepare();
            $stmt->execute();
        }
        catch ( PDOException $e )
        {
            throw new ezcPersistentQueryException( $e->getMessage(), $q );
        }

        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        $stmt->closeCursor();
        if ( $row !== false ) // we got a result
        {
            // we could check if there was more than one result here
            // but we don't because of the overhead and since the Persistent
            // Object would be faulty by design in that case and the user would have
            // to execute custom code to get into an invalid state.
            try
            {
                $state = ezcPersistentStateTransformer::rowToStateArray( $row, $def );
            }
            catch ( Exception $e )
            {
                throw new ezcPersistentObjectException( "The row data could not be correctly converted to set data.", "Most probably there is something wrong with a custom rowToStateArray implementation" );
            }
            $pObject->setState( $state );
        }
        else
        {
            $class = get_class( $pObject );
            throw new ezcPersistentQueryException( "No object of class '$class' with id '$id'." );
        }
    }

    /**
     * Syncronizes the contents of $pObject with those in the database.
     *
     * Note that calling this method is equavalent with calling {@link
     * loadIntoObject()} on $pObject with the id of $pObject. Any changes made
     * to $pObject prior to calling refresh() will be discarded.
     *
     * @throws ezcPersistentObjectException
     *         if $pObject is not of a valid persistent object type.
     * @throws ezcPersistentObjectException
     *         if $pObject is not persistent already.
     * @throws ezcPersistentObjectException
     *         if the select query failed.
     *
     * @param object $pObject
     */
    public function refresh( $pObject )
    {
        $def = $this->definitionManager->fetchDefinition( get_class( $pObject ) ); // propagate exception
        $state = $pObject->getState();
        $idValue = $state[$def->idProperty->propertyName];
        if ( $idValue !== null )
        {
            $this->loadIntoObject( $pObject, $idValue );
        }
        else
        {
            $class = get_class( $pObject );
            throw new ezcPersistentObjectNotPersistentException( $class );
        }
    }

    /**
     * Saves the new persistent object $pObject to the database using an INSERT INTO query.
     *
     * The correct ID is set to $pObject.
     *
     * @throws ezcPersistentObjectException if $pObject
     *         is not of a valid persistent object type.
     * @throws ezcPersistentObjectException if $pObject
     *         is already stored to the database.
     * @throws ezcPersistentObjectException
     *         if it was not possible to generate a unique identifier for the
     *         new object.
     * @throws ezcPersistentObjectException
     *         if the insert query failed.
     *
     * @param object $pObject
     */
    public function save( $pObject )
    {
        $this->saveInternal( $pObject );
    }

    /**
     * Saves the new persistent object $pObject to the database using an INSERT INTO query.
     *
     * If $doPersistenceCheck is set this function will check if the object is persistent before
     * saving. If not, the check is omitted. The correct ID is set to $pObject.
     *
     * @throws ezcPersistentObjectException
     *         if $pObject is not of a valid persistent object type.
     * @throws ezcPersistentObjectException
     *         if $pObject is already stored to the database.
     * @throws ezcPersistentObjectException
     *         if it was not possible to generate a unique identifier for the
     *         new object.
     * @throws ezcPersistentObjectException
     *         if the insert query failed.
     *
     * @param object $pObject
     * @param bool $doPersistenceCheck
     * @param ezcPersistentIdentifierGenerator $idGenerator
     */
    private function saveInternal( $pObject, $doPersistenceCheck = true,
                                   ezcPersistentIdentifierGenerator $idGenerator = null )
    {
        $def = $this->definitionManager->fetchDefinition( get_class( $pObject ) );// propagate exception
        $state = $this->filterAndCastState( $pObject->getState(), $def );
        $idValue = $state[$def->idProperty->propertyName];

        // fetch the id generator
        if ( $idGenerator == null && ezcBaseFeatures::classExists( $def->idProperty->generator->class ) )
        {
            $idGenerator = new $def->idProperty->generator->class;
            if ( !( $idGenerator instanceof ezcPersistentIdentifierGenerator ) )
            {
                throw new ezcPersistentIdentifierGenerationException( get_class( $pObject ),
                                                                      "Could not initialize identifier generator: ". "{$def->idProperty->generator->class} ." );
            }
        }

        if ( $doPersistenceCheck == true && $idGenerator->checkPersistence( $def, $this->database, $state ) )
        {
            $class = get_class( $pObject );
            throw new ezcPersistentObjectAlreadyPersistentException( $class );
        }


        // set up and execute the query
        $q = $this->database->createInsertQuery();
        $q->insertInto( $this->database->quoteIdentifier( $def->table ) );
        foreach ( $state as $name => $value )
        {
            if ( $name != $def->idProperty->propertyName ) // skip the id field
            {
                // set each of the properties
                $q->set( $this->database->quoteIdentifier( $def->properties[$name]->columnName ), $q->bindValue( $value ) );
            }
        }

        $this->database->beginTransaction();
        // let presave id generator do its work
        $idGenerator->preSave( $def, $this->database, $q );

        // execute the insert query
        try
        {
            $stmt = $q->prepare();
            $stmt->execute();
        }
        catch ( PDOException $e )
        {
            $this->database->rollback();
            throw new ezcPersistentObjectException( "The insert query failed.", $e->getMessage() );
        }

        // fetch the newly created id, and set it to the object
        $id = $idGenerator->postSave( $def, $this->database );
        if ( $id === null )
        {
            $this->database->rollback();
            throw new ezcPersistentIdentifierGenerationException( $def->class );
        }

        // everything seems to be fine, lets commit the queries to the database
        // and update the object with its newly created id.
        $this->database->commit();

        $state[$def->idProperty->propertyName] = $id;
        $pObject->setState( $state );
    }

    /**
     * Saves or updates the persistent object $pObject to the database.
     *
     * If the object is a new object an INSERT INTO query will be executed. If
     * the object is persistent already it will be updated with an UPDATE
     * query.
     *
     * @throws ezcPersistentDefinitionNotFoundException
     *         if the definition of the persistent object could not be loaded.
     * @throws ezcPersistentObjectException
     *         if $pObject is not of a valid persistent object type.
     * @throws ezcPersistentObjectException
     *         if any of the definition requirements are not met.
     * @throws ezcPersistentObjectException
     *         if the insert or update query failed.
     * @param object $pObject
     * @return void
     */
    public function saveOrUpdate( $pObject )
    {
        $def = $this->definitionManager->fetchDefinition( get_class( $pObject ) );// propagate exception
        $state = $pObject->getState();

        // fetch the id generator
        $idGenerator = null;
        if ( ezcBaseFeatures::classExists( $def->idProperty->generator->class ) )
        {
            $idGenerator = new $def->idProperty->generator->class;
            if ( !( $idGenerator instanceof ezcPersistentIdentifierGenerator ) )
            {
                throw new ezcPersistentIdentifierGenerationException( get_class( $pObject ),
                                                                      "Could not initialize identifier generator: ". "{$def->idProperty->generator->class} ." );
            }
        }

        if ( !$idGenerator->checkPersistence( $def, $this->database, $state ) )
        {
            $this->saveInternal( $pObject, false, $idGenerator );
        }
        else
        {
            $this->updateInternal( $pObject, false );
        }
    }

    /**
     * Saves the new persistent object $pObject to the database using an UPDATE query.
     *
     * @throws ezcPersistentDefinitionNotFoundException if $pObject is not of a valid persistent object type.
     * @throws ezcPersistentObjectNotPersistentException if $pObject is not stored in the database already.
     * @throws ezcPersistentQueryException
     * @param object $pObject
     * @return void
     */
    public function update( $pObject )
    {
        $this->updateInternal( $pObject );
    }

    /**
     * Saves the new persistent object $pObject to the database using an UPDATE query.
     *
     * If $doPersistenceCheck is set this function will check if the object is persistent before
     * saving. If not, the check is omitted.
     *
     * @throws ezcPersistentDefinitionNotFoundException if $pObject is not of a valid persistent object type.
     * @throws ezcPersistentObjectNotPersistentException if $pObject is not stored in the database already.
     * @throws ezcPersistentQueryException
     * @param object $pObject
     * @param bool $doPersistenceCheck
     * @return void
     */
    private function updateInternal( $pObject, $doPersistenceCheck = true )
    {
        $def = $this->definitionManager->fetchDefinition( get_class( $pObject ) ); // propagate exception
        $state = $this->filterAndCastState( $pObject->getState(), $def );
        $idValue = $state[$def->idProperty->propertyName];

        // fetch the id generator
        $idGenerator = null;
        if ( ezcBaseFeatures::classExists( $def->idProperty->generator->class ) )
        {
            $idGenerator = new $def->idProperty->generator->class;
            if ( !( $idGenerator instanceof ezcPersistentIdentifierGenerator ) )
            {
                throw new ezcPersistentIdentifierGenerationException( get_class( $pObject ),
                                                                      "Could not initialize identifier generator: ". "{$def->idProperty->generator->class} ." );
            }
        }

        if ( $doPersistenceCheck == true && !$idGenerator->checkPersistence( $def, $this->database, $state ) )
        {
            $class = get_class( $pObject );
            throw new ezcPersistentObjectNotPersistentException( get_class( $pObject ) );
        }

        // set up and execute the query
        $q = $this->database->createUpdateQuery();
        $q->update( $this->database->quoteIdentifier( $def->table ) );
        foreach ( $state as $name => $value )
        {
            if ( $name != $def->idProperty->propertyName ) // skip the id field
            {
                // set each of the properties
                $q->set( $this->database->quoteIdentifier( $def->properties[$name]->columnName ), $q->bindValue( $value ) );
            }
        }
        $q->where( $q->expr->eq( $this->database->quoteIdentifier( $def->idProperty->columnName ),
                                 $q->bindValue( $idValue ) ) );
        try
        {
            $stmt = $q->prepare();
            $stmt->execute();
        }
        catch ( PDOException $e )
        {
            throw new ezcPersistentQueryException( $e->getMessage(), $q );
        }
    }

    /**
     * Returns a hash map between property and column name for the given definition $def.
     * The alias map can be used with the query classes.
     *
     * @param ezcPersistentObjectDefinition $def Definition.
     * @return array(string=>string)
     */
    public function generateAliasMap( ezcPersistentObjectDefinition $def, $prefixTableName = true )
    {
        $table = array();
        $table[$def->idProperty->propertyName] = ( $prefixTableName 
            ? $this->database->quoteIdentifier( $def->table ) . '.' . $this->database->quoteIdentifier( $def->idProperty->columnName )
            : $this->database->quoteIdentifier( $def->idProperty->columnName ) );
        foreach ( $def->properties as $prop )
        {
            $table[$prop->propertyName] = ( $prefixTableName 
                ? $this->database->quoteIdentifier( $def->table ) . '.' . $this->database->quoteIdentifier( $prop->columnName )
                : $this->database->quoteIdentifier( $prop->columnName ) );
        }
        $table[$def->class] = $def->table;
        return $table;
    }

    /**
     * Returns all the columns defined in the persistent object.
     *
     * @param ezcPersistentObjectDefinition $def Defintion.
     * @return array(int=>string)
     */
    public function getColumnsFromDefinition( ezcPersistentObjectDefinition $def, $prefixTableName = true )
    {
        $columns = array();
        $columns[] = ( $prefixTableName 
            ? $this->database->quoteIdentifier( $def->table ) . '.' . $this->database->quoteIdentifier( $def->idProperty->columnName )
            : $this->database->quoteIdentifier( $def->idProperty->columnName ) );
        foreach ( $def->properties as $property )
        {
            $columns[] = ( $prefixTableName
                ? $this->database->quoteIdentifier( $def->table ) . '.' . $this->database->quoteIdentifier( $property->columnName )
                : $this->database->quoteIdentifier( $property->columnName ) );
        }
        return $columns;
    }

    /**
     * Filters out all properties not in the definition and casts the
     * values to native PHP types.
     *
     * @param array(string=>string) $state
     * @param ezcPersistentObjectDefinition $def
     * @return array(string=>mixed)
     */
    private function filterAndCastState( array $state, ezcPersistentObjectDefinition $def )
    {
        $typedState = array();
        foreach ( $state as $name => $value )
        {
            $type = null;
            if ( $name == $def->idProperty->propertyName )
            {
                $type = $def->idProperty->propertyType;
                $conv = null;
            }
            else
            {
                if ( !isset( $def->properties[$name] ) )
                {
                    continue;
                }
                $type = $def->properties[$name]->propertyType;
                $conv = $def->properties[$name]->converter;
            }

            if ( !is_null( $value ) )
            {
                if ( !is_null( $conv ) )
                {
                    $value = $conv->toDatabase( $value );
                }
                switch ( $type )
                {
                    case ezcPersistentObjectProperty::PHP_TYPE_INT:
                        $value = (int) $value;
                        break;
                    case ezcPersistentObjectProperty::PHP_TYPE_FLOAT:
                        $value = (float) $value;
                        break;
                    case ezcPersistentObjectProperty::PHP_TYPE_STRING:
                        $value = (string) $value;
                        break;
                }
            }

            $typedState[$name] = $value;
        }
        return $typedState;
    }
}
?>
