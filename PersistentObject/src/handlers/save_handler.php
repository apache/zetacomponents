<?php

/**
 * Helper class for ezcPersistentSession to handle object saving.
 *
 * An instance of this class is used internally in {@link ezcPersistentSession}
 * and takes care for saving and updating objects.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @access private
 */
class ezcPersistentSaveHandler
{
    /**
     * Session object this instance belongs to.
     * 
     * @var ezcPersistentSession
     */
    private $session;

    /**
     * Creates a new save handler.
     * 
     * @param ezcPersistentSession $session 
     */
    public function __construct( ezcPersistentSession $session )
    {
        $this->session = $session;
    }

    /**
     * Saves the new persistent object $object to the database using an INSERT INTO query.
     *
     * The correct ID is set to $object.
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
        $this->saveInternal( $object );
    }

    /**
     * Saves the new persistent object $object to the database using an UPDATE query.
     *
     * @throws ezcPersistentDefinitionNotFoundException if $object is not of a valid persistent object type.
     * @throws ezcPersistentObjectNotPersistentException if $object is not stored in the database already.
     * @throws ezcPersistentQueryException
     * @param object $object
     * @return void
     */
    public function update( $object )
    {
        $this->updateInternal( $object );
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
        $def = $this->session->definitionManager->fetchDefinition( get_class( $object ) );// propagate exception
        $state = $this->session->getObjectState( $object );

        // fetch the id generator
        $idGenerator = null;
        if ( ezcBaseFeatures::classExists( $def->idProperty->generator->class ) )
        {
            $idGenerator = new $def->idProperty->generator->class;
            if ( !( $idGenerator instanceof ezcPersistentIdentifierGenerator ) )
            {
                throw new ezcPersistentIdentifierGenerationException( get_class( $object ),
                                                                      "Could not initialize identifier generator: ". "{$def->idProperty->generator->class} ." );
            }
        }

        if ( !$idGenerator->checkPersistence( $def, $this->session->database, $state ) )
        {
            $this->saveInternal( $object, false, $idGenerator );
        }
        else
        {
            $this->updateInternal( $object, false );
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
        $def = $this->session->definitionManager->fetchDefinition( ( $class = get_class( $object ) ) );

        $relatedClass = get_class( $relatedObject );

        $objectState = $this->session->getObjectState( $object );
        $relatedObjectState = $this->session->getObjectState( $relatedObject );

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

        $relatedDef = $this->session->definitionManager->fetchDefinition( get_class( $relatedObject ) );
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
                $q = $this->session->database->createInsertQuery();
                $q->insertInto( $this->session->database->quoteIdentifier( $relation->relationTable ) );
                $insertColumns = array();
                foreach ( $relation->columnMap as $map )
                {
                    if ( in_array( $map->relationSourceColumn, $insertColumns ) === false )
                    {
                        $q->set(
                            $this->session->database->quoteIdentifier( $map->relationSourceColumn ),
                            $q->bindValue( $objectState[$def->columns[$map->sourceColumn]->propertyName] )
                        );
                        $insertColumns[] = $map->relationSourceColumn;
                    }
                    if ( in_array( $map->relationDestinationColumn, $insertColumns ) === false )
                    {
                        $q->set(
                            $this->session->database->quoteIdentifier( $map->relationDestinationColumn ),
                            $q->bindValue( $relatedObjectState[$relatedDef->columns[$map->destinationColumn]->propertyName] )
                        );
                        $insertColumns[] = $map->relationDestinationColumn;
                    }
                }
                $this->session->performQuery( $q );
                break;
        }

        $relatedObject->setState( $relatedObjectState );
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
        $def = $this->session->definitionManager->fetchDefinition( $class ); // propagate exception

        // init query
        $q = $this->session->database->createUpdateQuery();
        $q->setAliases( $this->session->generateAliasMap( $def, false ) );
        $q->update( $this->session->database->quoteIdentifier( $def->table ) );

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
        $this->session->performQuery( $query );
    }

    /**
     * Saves the new persistent object $object to the database using an INSERT INTO query.
     *
     * If $doPersistenceCheck is set this function will check if the object is persistent before
     * saving. If not, the check is omitted. The correct ID is set to $object.
     *
     * @throws ezcPersistentObjectException
     *         if $object is not of a valid persistent object type.
     * @throws ezcPersistentObjectException
     *         if $object is already stored to the database.
     * @throws ezcPersistentObjectException
     *         if it was not possible to generate a unique identifier for the
     *         new object.
     * @throws ezcPersistentObjectException
     *         if the insert query failed.
     *
     * @param object $object
     * @param bool $doPersistenceCheck
     * @param ezcPersistentIdentifierGenerator $idGenerator
     */
    private function saveInternal( $object, $doPersistenceCheck = true,
                                   ezcPersistentIdentifierGenerator $idGenerator = null )
    {
        $def = $this->session->definitionManager->fetchDefinition( get_class( $object ) );// propagate exception
        $state = $this->filterAndCastState( $this->session->getObjectState( $object ), $def );
        $idValue = $state[$def->idProperty->propertyName];

        // fetch the id generator
        if ( $idGenerator == null && ezcBaseFeatures::classExists( $def->idProperty->generator->class ) )
        {
            $idGenerator = new $def->idProperty->generator->class;
            if ( !( $idGenerator instanceof ezcPersistentIdentifierGenerator ) )
            {
                throw new ezcPersistentIdentifierGenerationException( get_class( $object ),
                                                                      "Could not initialize identifier generator: ". "{$def->idProperty->generator->class} ." );
            }
        }

        if ( $doPersistenceCheck == true && $idGenerator->checkPersistence( $def, $this->session->database, $state ) )
        {
            $class = get_class( $object );
            throw new ezcPersistentObjectAlreadyPersistentException( $class );
        }


        // set up and execute the query
        $q = $this->session->database->createInsertQuery();
        $q->insertInto( $this->session->database->quoteIdentifier( $def->table ) );
        foreach ( $state as $name => $value )
        {
            if ( $name != $def->idProperty->propertyName ) // skip the id field
            {
                // set each of the properties
                $q->set( $this->session->database->quoteIdentifier( $def->properties[$name]->columnName ), $q->bindValue( $value ) );
            }
        }

        $this->session->database->beginTransaction();
        // let presave id generator do its work
        $idGenerator->preSave( $def, $this->session->database, $q );

        // execute the insert query
        try
        {
            $this->session->performQuery( $q );
        }
        catch ( Exception $e )
        {
            $this->session->database->rollback();
            throw $e;
        }

        // fetch the newly created id, and set it to the object
        $id = $idGenerator->postSave( $def, $this->session->database );
        if ( $id === null )
        {
            $this->session->database->rollback();
            throw new ezcPersistentIdentifierGenerationException( $def->class );
        }

        // everything seems to be fine, lets commit the queries to the database
        // and update the object with its newly created id.
        $this->session->database->commit();

        $state[$def->idProperty->propertyName] = $id;
        $object->setState( $state );
    }

    /**
     * Saves the new persistent object $object to the database using an UPDATE query.
     *
     * If $doPersistenceCheck is set this function will check if the object is persistent before
     * saving. If not, the check is omitted.
     *
     * @throws ezcPersistentDefinitionNotFoundException if $object is not of a valid persistent object type.
     * @throws ezcPersistentObjectNotPersistentException if $object is not stored in the database already.
     * @throws ezcPersistentQueryException
     * @param object $object
     * @param bool $doPersistenceCheck
     * @return void
     */
    private function updateInternal( $object, $doPersistenceCheck = true )
    {
        $def = $this->session->definitionManager->fetchDefinition( get_class( $object ) ); // propagate exception
        $state = $this->filterAndCastState( $this->session->getObjectState( $object ), $def );
        $idValue = $state[$def->idProperty->propertyName];

        // fetch the id generator
        $idGenerator = null;
        if ( ezcBaseFeatures::classExists( $def->idProperty->generator->class ) )
        {
            $idGenerator = new $def->idProperty->generator->class;
            if ( !( $idGenerator instanceof ezcPersistentIdentifierGenerator ) )
            {
                throw new ezcPersistentIdentifierGenerationException( get_class( $object ),
                                                                      "Could not initialize identifier generator: ". "{$def->idProperty->generator->class} ." );
            }
        }

        if ( $doPersistenceCheck == true && !$idGenerator->checkPersistence( $def, $this->session->database, $state ) )
        {
            $class = get_class( $object );
            throw new ezcPersistentObjectNotPersistentException( get_class( $object ) );
        }

        // set up and execute the query
        $q = $this->session->database->createUpdateQuery();
        $q->update( $this->session->database->quoteIdentifier( $def->table ) );
        foreach ( $state as $name => $value )
        {
            if ( $name != $def->idProperty->propertyName ) // skip the id field
            {
                // set each of the properties
                $q->set( $this->session->database->quoteIdentifier( $def->properties[$name]->columnName ), $q->bindValue( $value ) );
            }
        }
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( $def->idProperty->columnName ),
                                 $q->bindValue( $idValue ) ) );

        $this->session->performQuery( $q );
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
