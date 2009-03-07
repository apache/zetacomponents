<?php

class ezcPersistentIdentitySessionRelationObjectExtractor
{
    /**
     * Definition manager.
     * 
     * @var ezcPersistentDefinitionManager
     */
    protected $defManager;

    /**
     * Identity map.
     * 
     * @var ezcPersistentIdentityMap
     */
    protected $idMap;

    /**
     * Creates a new object extractor for $idMap on basis of $defManager.
     * 
     * @param ezcPersistentDefinitionManager $defManager 
     * @return void
     */
    public function __construct( ezcPersistentIdentityMap $idMap, ezcPersistentDefinitionManager $defManager )
    {
        $this->defManager = $defManager;
        $this->idMap      = $idMap;
    }

    /**
     * Extracts all objects and relations from $stmt.
     *
     * Extracts the object of $class with $id from $row and all of its related
     * objects defined in $relations.
     * 
     * @param PDOStatement $stmt 
     * @param string $class 
     * @param mixed $id 
     * @param array $relations 
     * @return void
     */
    public function extractObjects( PDOStatement $stmt, $class, $id, array $relations )
    {
        $results = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $def = $this->defManager->fetchDefinition( $class );

        if ( $this->idMap->getIdentity( $class, $id ) === null )
        {
            $object = new $class();
            $this->setObjectState(
                $object,
                $def,
                reset( $results )
            );
            $this->idMap->setIdentityWithId( $object, $class, $id );
        }
        
        foreach ( $results as $row )
        {
            $this->extractObjectsRecursive( $row, $relations, $class, $id );
        }
    }

    /**
     * Extracts objects recursively from $row.
     *
     * Checks if $row contains new objects defined in $relations. If this is
     * the case, the objects will be extracted and added as related objects of
     * their class for the object of $parentClass with $parentId.
     * 
     * @param array $row 
     * @param array $relations 
     * @param string $parentClass 
     * @param mixed $parentId 
     * @return void
     */
    protected function extractObjectsRecursive( array $row, array $relations, $parentClass, $parentId )
    {
        foreach ( $relations as $relation )
        {
            $id = $row[
                $this->getColumnAlias(
                    $relation->definition->idProperty->columnName,
                    $relation->tableAlias
                )
            ];

            // Check if object was already extracted
            $object = $this->idMap->getIdentity( $relation->relatedClass, $id );
            if ( $object === null )
            {
                $object = $this->createObject(
                    $row,
                    $relation
                );
                $this->idMap->setIdentityWithId( $object, $relation->relatedClass, $id );
            }

            // Check if relations from $parentClass to $relation->relatedClass were already recorded
            $relatedObjects = $this->idMap->getRelatedObjectsWithId(
                $parentClass,
                $parentId,
                $relation->relatedClass,
                $relation->relationName
            );
            if ( $relatedObjects === null )
            {
                // Establish empty related objects to be able to add new later.
                $relatedObjects = array();
                $this->idMap->setRelatedObjectsWithId(
                    $parentClass,
                    $parentId,
                    $relatedObjects,
                    $relation->relatedClass,
                    $relation->relationName
                );
            }

            // Check if relation itself is already recorded
            if ( !isset( $relatedObjects[$id] ) )
            {
                // Add related object
                // @TODO: This invalidates all named related sets, which is not
                // a good idea as soon as we support finding restricted related
                // sets.
                $this->idMap->addRelatedObjectWithId(
                    $parentClass,
                    $parentId,
                    $relation->relatedClass,
                    $id,
                    $object,
                    $relation->relationName
                );
            }
            
            // Recurse
            $this->extractObjectsRecursive(
                $row,
                $relation->furtherRelations,
                $relation->relatedClass,
                $id
            );
        }
    }

    /**
     * Creates a new object of $relation->relatedClass with state from $result.
     *
     * Creates a new object of the class defined in $relation->relatedClass and
     * sets its state from the given $result row, as defined in $relation.
     * 
     * @param array $result 
     * @param ezcPersistentRelationFindDefinition $relation 
     * @return ezcPersistentObject
     */
    protected function createObject( array $result, ezcPersistentRelationFindDefinition $relation )
    {
        $object = new $relation->relatedClass;
        $this->setObjectState(
            $object,
            $relation->definition,
            $result,
            $relation->tableAlias
        );
        return $object;
    }

    /**
     * Sets the state of $object from $result.
     *
     * Sets the state of $object from the $result given, using the $def.
     * 
     * @param ezcPersistentObject $object 
     * @param ezcPersistentObjectDefinition $def 
     * @param array $result 
     * @param string $prefix 
     * @return void
     */
    protected function setObjectState( $object, ezcPersistentObjectDefinition $def, array $result, $prefix = null )
    {
        $state = array(
            $def->idProperty->propertyName => $result[
                $this->getColumnAlias(
                    $def->idProperty->columnName,
                    $prefix
                )
            ]
        );

        foreach ( $def->properties as $property )
        {
            $state[$property->propertyName] = $result[
                $this->getColumnAlias( $property->columnName, $prefix )
            ];
        }

        $object->setState( $state );
    }

    /**
     * Returns the column alias for a $column with $prefix.
     * 
     * @param string $column 
     * @param string $prefix 
     * @return string
     */
    protected function getColumnAlias( $column, $prefix = null )
    {
        if ( $prefix === null )
        {
            return $column;
        }
        return sprintf(
            '%s_%s',
            $prefix,
            $column
        );
    }
}

?>
