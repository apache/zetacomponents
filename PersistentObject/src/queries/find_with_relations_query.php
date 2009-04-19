<?php
/**
 * File containing the ezcPersistentFindQuery class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Find query object for pre-fetching queries in ezcPersistentIdentitySession.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentFindWithRelationsQuery extends ezcPersistentFindQuery
{
    /**
     * Creates a new persistent find query.
     *
     * Creates a new persistent find query from the query object $q and the
     * given $className.
     * 
     * @param ezcQuerySelect $query
     * @param string $className
     */
    public function __construct( ezcQuerySelect $query, $className, array $relations )
    {
        parent::__construct( $query, $className );
        
        $this->properties['relations']           = $relations;
        $this->properties['restrictedRelations'] = array();
    }

    /**
     * Adds a where clause with logical expressions to the query.
     *
     * where() accepts an arbitrary number of parameters. Each parameter
     * must contain a logical expression or an array with logical expressions.
     * If you specify multiple logical expression they are connected using
     * a logical and.
     *
     * Multiple calls to where() will join the expressions using a logical and.
     *
     * Example:
     * <code>
     * $q->select( '*' )->from( 'table' )->where( $q->expr->eq( 'id', 1 ) );
     * </code>
     *
     * Note, that whenever you restrict a set of related objects by a custom
     * WHERE expression using this function, this restriction is recorded. For
     * relations that have a WHERE restriction applied, the found related
     * object set is not registered as the main related object set itself, but
     * as a named related object sub-set under the alias name you registered in
     * the relation definition.
     *
     * @TODO Example!
     *
     * @throws ezcQueryVariableParameterException if called with no parameters.
     * @param string|array(string) $... Either a string with a logical expression name
     * or an array with logical expressions.
     * @return ezcQuerySelect
     */
    public function where()
    {
        $args = func_get_args();

        $this->registerWhereConditions( $args );

        $this->query->where( $args );

        return $this;
    }

    /**
     * Registers all WHERE conditions in $whereArgs.
     *
     * Checks through all WHERE conditions in $whereArgs, if they contain
     * restriction on relation fetches. Restricted relation names are
     * registered in the $restrictedRelations property for later fetching.
     * 
     * @param array $whereArgs 
     * @return void
     */
    private function registerWhereConditions( array $whereArgs )
    {
        foreach ( $whereArgs as $condition )
        {
            if ( is_array( $condition ) )
            {
                $this->registerWhere( $condition );
            }
            else
            {
                // Condition is a string
                $this->registerWhereCondition( $condition, $this->relations );
            }
        }
    }

    /**
     * Checks for relation alias occurances in $condition.
     * 
     * Checks which aliases for $relations occur in the given $condition and
     * registers them to be restricted fetches in the property
     * $restrictedRelations.
     *
     * @param string $condition 
     * @param array(ezcPersistentRelationFindDefinition) $relations 
     * @return void
     */
    private function registerWhereCondition( $condition, array $relations )
    {
        foreach ( $relations as $alias => $relation )
        {
            if ( strpos( $condition, $alias ) !== false )
            {
                $this->properties['restrictedRelations'][$alias] = true;
            }
            $this->registerWhereCondition(
                $condition,
                $relation->furtherRelations
            );
        }
    }

    /**
     * Delegate to inner $query object.
     *
     * This query object does not allow any other calls than {where()} and
     * {groupBy()}. Therefore, this method throws an exception, for any other
     * call.
     * 
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     * @throws RuntimeException For any call.
     */
    public function __call( $methodName, $arguments )
    {
        switch ( $methodName )
        {
            case 'orderBy':
            case 'getQuery':
            case 'hasAliases':
            case 'getIdentifier':
            case 'getIdentifiers':
            case 'bindValue':
            case 'bindParam':
            case 'resetBinds':
            case 'doBind':
            case 'prepare':
            case 'subSelect':
                return parent::__call( $methodName, $arguments );
        }
        throw new RuntimeException(
            "Method '$methodName' does not exist or is not allowed to be called."
        );
    }

    /**
     * Property set access.
     * 
     * @param string $propertyName 
     * @param mixed $properyValue
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the desired property could not be found.
     * @throws ezcBaseValueException
     *         if $properyValue is not valid for $propertyName.
     */
    public function __set( $propertyName, $properyValue )
    {
        switch ( $propertyName )
        {
            case 'relations':
                throw new ezcBasePropertyPermissionException(
                    $propertyName,
                    ezcBasePropertyPermissionException::READ
                );

            default:
                return parent::__set( $propertyName, $properyValue );
        }
    }
}

?>
