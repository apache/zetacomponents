<?php

/**
 * Helper class for ezcPersistentSession to handle object loading.
 *
 * An instance of this class is used internally in {@link ezcPersistentSession}
 * and takes care for loading and finding objects.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @access private
 */
class ezcPersistentLoadHandler
{
    /**
     * Session object this instance belongs to.
     * 
     * @var ezcPersistentSession
     */
    private $session;

    /**
     * Creates a new load handler.
     * 
     * @param ezcPersistentSession $session 
     */
    public function __construct( ezcPersistentSession $session )
    {
        $this->session = $session;
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
        $def = $this->session->definitionManager->fetchDefinition( $class ); // propagate exception
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
     * Loads the persistent object with the id $id into the object $object.
     *
     * The class of the persistent object to load is determined by the class
     * of $object.
     *
     * @throws ezcPersistentObjectException
     *         if the object is not available.
     * @throws ezcPersistentDefinitionNotFoundException
     *         if $object is not of a valid persistent object type.
     * @throws ezcPersistentQueryException
     *         if the find query failed.
     *
     * @param object $object
     * @param int $id
     */
    public function loadIntoObject( $object, $id )
    {
        $def = $this->session->definitionManager->fetchDefinition( get_class( $object ) ); // propagate exception
        $q = $this->session->database->createSelectQuery();
        $q->select( $this->session->getColumnsFromDefinition( $def ) )
            ->from( $this->session->database->quoteIdentifier( $def->table ) )
            ->where( $q->expr->eq( $this->session->database->quoteIdentifier( $def->idProperty->columnName ),
                                   $q->bindValue( $id ) ) );

        $stmt = $this->session->performQuery( $q );
        $row  = $stmt->fetch( PDO::FETCH_ASSOC );
        $stmt->closeCursor();
        if ( $row !== false ) // we got a result
        {
            // we could check if there was more than one result here
            // but we don't because of the overhead and since the Persistent
            // Object would be faulty by design in that case and the user would have
            // to execute custom code to get into an invalid state.
            try
            {
                $state = ezcPersistentStateTransformer::rowToStateArray(
                    $row,
                    $def
                );
            }
            catch ( Exception $e )
            {
                throw new ezcPersistentObjectException(
                    "The row data could not be correctly converted to set data.",
                    "Most probably there is something wrong with a custom rowToStateArray implementation"
                );
            }
            $object->setState( $state );
        }
        else
        {
            $class = get_class( $object );
            throw new ezcPersistentQueryException( "No object of class '$class' with id '$id'." );
        }
    }

    /**
     * Syncronizes the contents of $object with those in the database.
     *
     * Note that calling this method is equavalent with calling {@link
     * loadIntoObject()} on $object with the id of $object. Any changes made
     * to $object prior to calling refresh() will be discarded.
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
        $def = $this->session->definitionManager->fetchDefinition( get_class( $object ) ); // propagate exception
        $state = $this->session->getObjectState( $object );
        $idValue = $state[$def->idProperty->propertyName];
        if ( $idValue !== null )
        {
            $this->loadIntoObject( $object, $idValue );
        }
        else
        {
            $class = get_class( $object );
            throw new ezcPersistentObjectNotPersistentException( $class );
        }
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
        $def = $this->session->definitionManager->fetchDefinition( $class ); // propagate exception

        $rows = $this->session->performQuery( $query )->fetchAll( PDO::FETCH_ASSOC );

        // convert all the rows states and then objects
        $result = array();
        foreach ( $rows as $row )
        {
            $object = new $def->class;
            $object->setState(
                ezcPersistentStateTransformer::rowToStateArray( $row, $def )
            );
            $result[] = $object;
        }
        return $result;
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
        $def  = $this->session->definitionManager->fetchDefinition( $class ); // propagate exception
        $stmt = $this->session->performQuery( $query );
        return new ezcPersistentFindIterator( $stmt, $def );
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
        $def = $this->session->definitionManager->fetchDefinition( $class ); // propagate exception

        // init query
        $q = $this->session->database->createSelectQuery();
        $q->setAliases( $this->session->generateAliasMap( $def ) );
        $q->select( $this->session->getColumnsFromDefinition( $def ) )
            ->from( $this->session->database->quoteIdentifier( $def->table ) );

        return $q;
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
        $def = $this->session->definitionManager->fetchDefinition( ( $class = get_class( $object ) ) );
        if ( !isset( $def->relations[$relatedClass] ) )
        {
            throw new ezcPersistentRelationNotFoundException( $class, $relatedClass );
        }
        $relation = $def->relations[$relatedClass];

        $query = $this->createFindQuery( $relatedClass );

        $objectState = $this->session->getObjectState( $object );

        switch ( ( $relationClass = get_class( $relation ) ) )
        {
            case "ezcPersistentOneToManyRelation":
            case "ezcPersistentManyToOneRelation":
            case "ezcPersistentOneToOneRelation":
                foreach ( $relation->columnMap as $map )
                {
                    $query->where(
                        $query->expr->eq(
                            $this->session->database->quoteIdentifier( "{$map->destinationColumn}" ),
                            $query->bindValue( $objectState[$def->columns[$map->sourceColumn]->propertyName] )
                        )
                    );
                }
                break;
            case "ezcPersistentManyToManyRelation":
                $query->from( $this->session->database->quoteIdentifier( $relation->relationTable ) );
                foreach ( $relation->columnMap as $map )
                {
                    $query->where(
                        $query->expr->eq(
                            $this->session->database->quoteIdentifier( $relation->relationTable ) . "." . $this->session->database->quoteIdentifier( $map->relationSourceColumn ),
                            $query->bindValue( $objectState[$def->columns[$map->sourceColumn]->propertyName] )
                        ),
                        $query->expr->eq(
                            $this->session->database->quoteIdentifier( $relation->relationTable ) . "." . $this->session->database->quoteIdentifier( $map->relationDestinationColumn ),
                            $this->session->database->quoteIdentifier( $relation->destinationTable ) . "." . $this->session->database->quoteIdentifier( $map->destinationColumn )
                        )
                    );
                }
                break;
            default:
                throw new ezcPersistentRelationInvalidException( $relationClass );
        }
        return $query;
    }
}

?>
