<?php
/**
 * File containing the ezcPersistentIdentityRelationQueryCreator class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Creates JOIN queries to fetch related objects for a given object.
 *
 * An instance of this class is used in {@link ezcPersistentIdentitySession} to
 * generate a {@link ezcQuerySelect} object to fetch related objects for a
 * certain object. The results of the generated query are then extracted using
 * {@link ezcPersistentIdentityRelationObjectExtractor}.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @access private
 */
class ezcPersistentIdentityRelationQueryCreator
{
    /**
     * Definition Manager.
     * 
     * @var ezcPersistentDefinitionManager
     */
    protected $defManager;

    /**
     * Database handler. 
     * 
     * @var ezcDbHandler
     */
    protected $db;

    /**
     * Creates a new query generator. 
     *
     * Creates a new query generator that will receive needed persistentence
     * definitions from $defManager.
     * 
     * @param ezcPersistentDefinitionManager $defManager 
     */
    public function __construct( ezcPersistentDefinitionManager $defManager, ezcDbHandler $database )
    {
        $this->defManager = $defManager;
        $this->db         = $database;
    }

    /**
     * Generates a relation pre-fetch query.
     *
     * This method generates a relation pre-fetch query on basis of $q. The
     * query will fetch the object of $class with $id and all related objects
     * defined in $relations.
     * 
     * @param ezcQuerySelect $q 
     * @param string $class 
     * @param mixed $id 
     * @param array $relations 
     */
    public function createQuery( ezcQuerySelect $q, $class, $id, array $relations )
    {
        $srcDef = $this->defManager->fetchDefinition( $class );

        // Set aliases for all joins
        $this->createAliases( $srcDef, $relations );

        // Select the desired object columns as main
        $q->select(
            $q->alias(
                $this->getColumnName( $srcDef->table, $srcDef->idProperty->columnName ),
                $this->db->quoteIdentifier( $srcDef->idProperty->columnName )
            )
        );
        foreach ( $srcDef->properties as $property )
        {
            $q->select(
                $q->alias(
                    $this->getColumnName( $srcDef->table, $property->columnName ),
                    $this->db->quoteIdentifier( $property->columnName )
                )
            );
        }
        
        $this->createSelects( $q, $relations );

        $q->from( $this->db->quoteIdentifier( $srcDef->table ) );

        $this->createJoins( $q, $srcDef->table, $relations );

        $q->where(
            $q->expr->eq(
                $this->getColumnName(
                    $srcDef->table,
                    $srcDef->idProperty->columnName
                ),
                $q->bindValue( $id )
            )
        );
    }

    /**
     * Creates aliases for the given $relations for the $srcDef.
     *
     * Creates aliases for the given $relations, based on $srcDef. $srcDef is
     * the the object definition, where $relations related objects should be
     * fetched for. The $aliasCounter is a global ArrayObject, that takes care
     * of counting up table aliases, so that no alias is used twice.
     *
     * Returns the alias definitions generated recursively from $relations.
     * 
     * @param ezcPersistentObjectDefinition $srcDef 
     * @param array(ezcPersistentRelationFindDefinition) $relations 
     * @param ArrayObject(string=>count) $aliasCounter 
     * @return array(string=>string)
     */
    protected function createAliases( ezcPersistentObjectDefinition $srcDef, array $relations, ArrayObject $aliasCounter = null )
    {
        if ( $aliasCounter === null )
        {
            $aliasCounter = new ArrayObject();
        }

        foreach ( $relations as $relation )
        {
            if ( !isset( $srcDef->relations[$relation->relatedClass] ) )
            {
                throw new ezcPersistentRelationNotFoundException(
                    $srcDef->class, $relation->relatedClass
                );
            }
            $srcRelDef = $srcDef->relations[$relation->relatedClass];
            if ( $relation->relationName !== null )
            {
                $srcRelDef = $srcRelDef[$relation->relationName];
            }
            $relation->relationDefinition = $srcRelDef;

            $relation->definition = $this->defManager->fetchDefinition( $relation->relatedClass );
            
            $this->setTableAliases( $relation, $aliasCounter );

            if ( $relation->furtherRelations !== array() )
            {
                $this->createAliases( $relation->definition, $relation->furtherRelations, $aliasCounter );
            }
        }
    }

    /**
     * Sets aliases for the tables used by $relation.
     *
     * Generates new aliases for all tables affected by $relation and stores
     * them in the struct for later re-use. In addition it returns a mapping
     * array, reflecting the generated aliases.
     * 
     * @param ezcPersistentRelationFindDefinition $relation 
     * @param ArrayObject(string=>int) $aliasCounter 
     * @return array(string=>string)
     */
    protected function setTableAliases( ezcPersistentRelationFindDefinition $relation, ArrayObject $aliasCounter )
    {
        $relationDefinition = $relation->relationDefinition;

        if ( !isset( $aliasCounter[$relationDefinition->destinationTable] ) )
        {
            $aliasCounter[$relationDefinition->destinationTable] = 0;
        }
        ++$aliasCounter[$relationDefinition->destinationTable];
        $relation->tableAlias = sprintf(
            '%s_%s',
            $relationDefinition->destinationTable,
            $aliasCounter[$relationDefinition->destinationTable]
        );
        $aliases[$relation->tableAlias] = $relationDefinition->destinationTable;

        if ( $relationDefinition instanceof ezcPersistentManyToManyRelation )
        {
            if ( !isset( $aliasCounter[$relationDefinition->relationTable] ) )
            {
                $aliasCounter[$relationDefinition->relationTable] = 0;
            }
            ++$aliasCounter[$relationDefinition->relationTable];

            $relation->relationTableAlias = sprintf(
                '%s_%s',
                $relationDefinition->relationTable,
                $aliasCounter[$relationDefinition->relationTable]
            );
            $aliases[$relation->relationTableAlias] = $relationDefinition->relationTable;
        }
    }

    /**
     * Adds all columns to be selected to $q.
     *
     * Adds the columns from all tables defined in $relations to the select
     * query $q. Columns are selected using an alias to identify which relation
     * they belong too, using the tables alias.
     * 
     * @param ezcQuerySelect $q 
     * @param array $relations 
     */
    protected function createSelects( ezcQuerySelect $q, array $relations )
    {
        foreach ( $relations as $relation )
        {
            $q->select(
                $q->alias(
                    $this->getColumnName(
                        $relation->tableAlias,
                        $relation->definition->idProperty->columnName
                    ),
                    $this->getColumnAlias(
                        $relation->tableAlias,
                        $relation->definition->idProperty->columnName
                    )
                )
            );
            foreach ( $relation->definition->properties as $property )
            {
                $q->select(
                    $q->alias(
                        $this->getColumnName( $relation->tableAlias, $property->columnName ),
                        $this->getColumnAlias( $relation->tableAlias, $property->columnName )
                    )
                );
            }
            if ( $relation->furtherRelations !== array() )
            {
                $this->createSelects( $q, $relation->furtherRelations );
            }
        }
    }

    /**
     * Returns an alias for $column from $table.
     * 
     * @param string $table 
     * @param string $column 
     * @return string
     */
    protected function getColumnAlias( $table, $column )
    {
        return $this->db->quoteIdentifier(
            sprintf(
                '%s_%s',
                $table,
                $column
            )
        );
    }

    /**
     * Returns the full qualified column name for the $column in $table.
     * 
     * @param string $table 
     * @param string $column 
     * @return string
     */
    protected function getColumnName( $table, $column )
    {
        return sprintf(
            '%s.%s',
            $this->db->quoteIdentifier( $table ),
            $this->db->quoteIdentifier( $column )
        );
    }
    
    /**
     * Creates the joins to select $relations from $srcTableName.
     *
     * Creates the necessary JOIN statements in $q to select all related
     * objects defined by $relations, seen from $srcTableName point of view.
     * $srcTableName must already be the alias table name of the source table.
     * 
     * @param ezcQuerySelect $q 
     * @param string $srcTableName 
     * @param array(ezcPersistentRelationFindDefinition) $relations 
     */
    protected function createJoins( ezcQuerySelect $q, $srcTableName, array $relations )
    {
        foreach ( $relations as $relation )
        {
            $this->createJoin( $q, $srcTableName, $relation );
            $this->createJoins( $q, $relation->tableAlias, $relation->furtherRelations );
        }
    }

    /**
     * Creates the JOIN necessary to fetch related objects of $relation.
     *
     * Detects if $relation needs a n:m-relation JOIN or just a simple join and
     * dispatches to the correct methods.
     * 
     * @param ezcQuerySelect $q 
     * @param string $srcTableName 
     * @param ezcPersistentRelationFindDefinition $relation 
     */
    protected function createJoin( ezcQuerySelect $q, $srcTableName, ezcPersistentRelationFindDefinition $relation )
    {
        if ( $relation->relationDefinition instanceof ezcPersistentManyToManyRelation )
        {
            $this->createComplexJoin( $q, $srcTableName, $relation );
        }
        else
        {
            $this->createSimpleJoin( $q, $srcTableName, $relation );
        }
    }

    /**
     * Creates an n:m relation JOIN to fetch $relation.
     *
     * Uses the aliases defined in $relation and the relations definition to
     * create 2 LEFT JOIN statements in $q. These 2 JOINs are used to fetch the
     * objects defined in $relation.
     * 
     * @param ezcQuerySelect $q 
     * @param string $srcTableName 
     * @param ezcPersistentRelationFindDefinition $relation 
     */
    protected function createComplexJoin( ezcQuerySelect $q, $srcTableName, ezcPersistentRelationFindDefinition $relation )
    {
        $relationDefinition = $relation->relationDefinition;

        $first        = true;
        $srcJoinCond  = null;
        $destJoinCond = null;

        // Build join conditions in paralell
        foreach ( $relationDefinition->columnMap as $mapping )
        {
            $srcColumn = $this->getColumnName(
                $srcTableName,
                $mapping->sourceColumn
            );
            $relSrcColumn = $this->getColumnName(
                $relation->relationTableAlias,
                $mapping->relationSourceColumn
            );
            $relDestColumn = $this->getColumnName(
                $relation->relationTableAlias,
                $mapping->relationDestinationColumn
            );
            $destColumn = $this->getColumnName(
                $relation->tableAlias,
                $mapping->destinationColumn
            );

            if ( $first )
            {
                $srcJoinCond  = $q->expr->eq( $srcColumn, $relSrcColumn );
                $destJoinCond = $q->expr->eq( $relDestColumn, $destColumn );
                $first        = false;
            }
            else
            {
                $srcJoinCond = $q->expr->and(
                    $srcJoinCond,
                    $q->expr->eq( $srcColumn, $relSrcColumn )
                );
                $destJoinCond = $q->expr->and(
                    $destJoinCond,
                    $q->expr->eq( $relDestColumn, $destColumn )
                );
            }
        }

        // Add 2 joins
        $q->leftJoin(
            $q->alias(
                $this->db->quoteIdentifier( $relationDefinition->relationTable ),
                $this->db->quoteIdentifier( $relation->relationTableAlias )
            ),
            $srcJoinCond
        );
        $q->leftJoin(
            $q->alias(
                $this->db->quoteIdentifier( $relationDefinition->destinationTable ),
                $this->db->quoteIdentifier( $relation->tableAlias )
            ),
            $destJoinCond
        );
    }

    /**
     * Creates a simple JOIN to fetch the objects defined by $relation.
     *
     * Creates a simple LEFT JOIN using the aliases defined in $relation and
     * the $srcTableName, to fetch all objects defined by $relation, which are
     * related to the source object, fetched by $srcTableName.
     * 
     * @param ezcQuerySelect $q 
     * @param string $srcTableName 
     * @param ezcPersistentRelationFindDefinition $relation 
     */
    protected function createSimpleJoin( ezcQuerySelect $q, $srcTableName, ezcPersistentRelationFindDefinition $relation )
    {
        $relationDefinition = $relation->relationDefinition;

        $first    = true;
        $joinCond = null;
        foreach ( $relationDefinition->columnMap as $mapping )
        {
            $srcColumn  = $this->getColumnName( $srcTableName, $mapping->sourceColumn );
            $destColumn = $this->getColumnName( $relation->tableAlias, $mapping->destinationColumn );

            if ( $first )
            {
                $joinCond = $q->expr->eq( $srcColumn, $destColumn );
                $first    = false;
            }
            else
            {
                $joinCond = $q->expr->and(
                    $joinCond,
                    $q->expr->eq( $srcColumn, $destColumn )
                );
            }
        }
        $q->leftJoin(
            $q->alias(
                $this->db->quoteIdentifier( $relationDefinition->destinationTable ),
                $this->db->quoteIdentifier( $relation->tableAlias )
            ),
            $joinCond
        );
    }
}

?>
